package Query;

my %fields = (
	dbh => undef,
	table => undef,
	rank => undef,
	parent_field => undef
);

sub new {
   my $classname  = shift;
	my $this  = {%fields};
   bless($this, $classname);
   $this->{dbh} = shift;
   $this->{table} = shift;
   $this->{rank} = shift;
   return $this;
}

sub set_parent_field{ my $this = shift; $this->{parent_field} = shift; }
sub set_lang{ my $this = shift; $this->{lang} = shift; }

sub get_order_by{
	return '';	
}

sub fetch_query{
	my $this = shift;
	my $start = shift;
	$start +=0;
	
	my $table = $this->{table};
	my $rank_field = $this->{rank};
	my $order = " ORDER BY $rank_field " if ($rank_field);
	if ($this->get_order_by){
		$order = $this->get_order_by;
	}
	
	$limit = " LIMIT $start," . $main::CONFIG{list_limit};
	my $qs = "SELECT * FROM $table $order" . $limit ;

	my $sth = $this->{dbh}->prepare($qs) || die $dbh->errstr;
	$sth->execute() || die $sth->errstr;
	return $sth;
}

sub count_query{
	my $this = shift;
	my $lang = $this->{lang};
	my $qs = "SELECT count(*) FROM ". $this->{table};
	my $sth = $this->{dbh}->prepare($qs) || die $dbh->errstr;
	$sth->execute() || die $sth->errstr;
	return $sth->fetchrow_array();
}

sub _get_id_field{	my $this = shift;  	return $this->{table}."_id";	}

sub delete_query{
	my $this = shift;
	my $id = shift;
	
	my $rank_field = $this->{rank};
	my $table = $this->{table};
	my $id_field = $this->_get_id_field();
	
	my $parent_field = $this->{'parent_field'};
	
	my @child_ids; my $tree = new Tree1;

	if ($parent_field){ # if table is tree structured then we have to delete all childs also
		my $rf = ", $rank_field" if ($rank_field);
		my $sth = $this->fetch_query("$id_field, $parent_field $rf");	
		
		while (my ($_id,$parent_id, $rank) = $sth->fetchrow_array()){ # build tree of all entries in the table
			$tree->add_node($_id, $parent_id, $rank); # id, parent_id, value
		}
		
		my $node = $tree->_get_node($id);					# get tree node of id to delete
		@child_ids = @{$tree->get_ordered_ids($node)};	# get childs recursively
	}
	
	if ($rank_field and $parent_field){ # deletes childs
		foreach $child_id (@child_ids){
			my $rank = $tree->get_value($child_id);
			$this->{dbh}->do(qq~UPDATE $table SET $rank_field=$rank_field-1 WHERE $rank_field>$rank~)  || die $this->{dbh}->errstr;
			$this->{dbh}->do(qq~DELETE FROM $table WHERE $id_field ='$child_id'~)  || die $this->{dbh}->errstr;
		}	
	}
	
	# above and below should be united

	if($rank_field){ # handles main one 
		my $sth = $this->{dbh}->prepare(qq~SELECT $rank_field FROM $table WHERE $id_field = '$id'~) || die $this->{dbh}->errstr;
		$sth->execute() || die $sth->errstr;
		my $rank = $sth->fetchrow_array();
		$this->{dbh}->do(qq~UPDATE $table SET $rank_field=$rank_field-1 WHERE $rank_field>$rank~)  || die $this->{dbh}->errstr;
	}	
	
	$this->{dbh}->do(qq~DELETE FROM $table WHERE $id_field ='$id'~)  || die $this->{dbh}->errstr;
}

sub up_query{
	my $this = shift;
	my $id = shift;
	
	my $rank_field = $this->{rank};
	my $table = $this->{table};
	my $id_field = $this->_get_id_field();
	
	my $qs = qq~SELECT $rank_field FROM $table WHERE $id_field = '$id'~;
	my $sth = $this->{dbh}->prepare($qs) || die $this->{dbh}->errstr;
	$sth->execute() || die $sth->errstr;
	my $rank = $sth->fetchrow_array();
	
	$rank--;
	$this->{dbh}->do(qq~UPDATE $table SET $rank_field=$rank_field+1 WHERE $rank_field=$rank~)  || die $this->{dbh}->errstr;
	$this->{dbh}->do(qq~UPDATE $table SET $rank_field=$rank_field-1 WHERE $id_field='$id'~)  || die $this->{dbh}->errstr;
}

sub down_query{
	my $this = shift;
	my $id = shift;

	my $rank_field = $this->{rank};
	my $table = $this->{table};
	my $id_field = $this->_get_id_field();
	
	my $qs = qq~SELECT $rank_field FROM $table WHERE $id_field = '$id'~;
	my $sth = $this->{dbh}->prepare($qs) || die $this->{dbh}->errstr;
	$sth->execute() || die $sth->errstr;
	my $rank = $sth->fetchrow_array();
	
	$rank++;
	$this->{dbh}->do(qq~UPDATE $table SET $rank_field=$rank_field-1 WHERE $rank_field=$rank~)  || die $this->{dbh}->errstr;
	$this->{dbh}->do(qq~UPDATE $table SET $rank_field=$rank_field+1 WHERE $id_field='$id'~)  || die $this->{dbh}->errstr;
}

package PageQuery;
@ISA = qw( Query );

sub fetch_query{
	my $this = shift;
	my $fields = shift;
	
	unless ($fields){
		$fields = '*';
	}
	
	my $table = $this->{table};
	my $lang_test_string = $this->_lang_test_string();
	$lang_test_string = " WHERE " . $lang_test_string if ($lang_test_string);
	
	my $qs = "SELECT $fields FROM $table $lang_test_string ORDER by rank";
	my $sth = $this->{dbh}->prepare($qs) || die $dbh->errstr;
	$sth->execute() || die $sth->errstr;
	return $sth;
}

sub _lang_test_string{
	my $this = shift;
	my $lang = $this->{lang};
	return "lang_id=$lang";
}

sub up_query{
	my $this = shift;
	my $id = shift;
	
	my $lang_test_string = $this->_lang_test_string();
	$lang_test_string = " and $lang_test_string" if ($lang_test_string);
	my $rank_field = $this->{rank};
	my $table = $this->{table};
	my $id_field = $this->_get_id_field();
	
	my $qs = qq~SELECT $rank_field, parent_id FROM $table WHERE $id_field = '$id'~;
	my $sth = $this->{dbh}->prepare($qs) || die $this->{dbh}->errstr;
	$sth->execute() || die $sth->errstr;
	my ($rank_this,$parent_id) = $sth->fetchrow_array();
	# currents rank and parent (parent is for finding same level entry)
	
	# get previous entry with the same parent and same lang and smaller rank
	my $qs = qq~SELECT $id_field, $rank_field FROM $table WHERE $rank_field<$rank_this and parent_id=$parent_id $lang_test_string~;
	my $sth = $this->{dbh}->prepare($qs) || die $this->{dbh}->errstr;
	$sth->execute() || die $sth->errstr;
	my $id_prev; my $rank_prev;

	# only the lastone is needed
	while (my ($id,$r) = $sth->fetchrow_array()){
		$id_prev = $id;
		$rank_prev = $r;
	}
	
	# now we have ids and ranks of this and previous
	# previous rank to current
	$this->{dbh}->do(qq~UPDATE $table SET $rank_field=$rank_prev WHERE $id_field=$id~)  || die $this->{dbh}->errstr;
	
	
	# inc all ranks between previous and current except current.	
	$this->{dbh}->do(qq~UPDATE $table SET $rank_field=$rank_field+1 WHERE $rank_field BETWEEN $rank_prev AND $rank_this AND $id_field != $id~)  || die $this->{dbh}->errstr;
}


sub down_query{
	my $this = shift;
	my $id = shift;
	
	my $lang_test_string = $this->_lang_test_string();
	$lang_test_string = " and $lang_test_string" if ($lang_test_string);
	my $rank_field = $this->{rank};
	my $table = $this->{table};
	my $id_field = $this->_get_id_field();
	
	my $qs = qq~SELECT $rank_field, parent_id FROM $table WHERE $id_field = '$id'~;
	my $sth = $this->{dbh}->prepare($qs) || die $this->{dbh}->errstr;
	$sth->execute() || die $sth->errstr;
	my ($rank_this,$parent_id) = $sth->fetchrow_array();
	# currents rank and parent (parent is for finding same level entry)
	
	# get next entry with the same parent and same lang and greater rank
	my $qs = qq~SELECT $id_field, $rank_field FROM $table WHERE $rank_field>$rank_this and parent_id=$parent_id $lang_test_string LIMIT 1~;
	my $sth = $this->{dbh}->prepare($qs) || die $this->{dbh}->errstr;
	$sth->execute() || die $sth->errstr;
	my ($id_next,$rank_next) = $sth->fetchrow_array();
	
	# now we have ids and ranks of this and nextone at the same level
	# next rank to current
	$this->{dbh}->do(qq~UPDATE $table SET $rank_field=$rank_next WHERE $id_field=$id~)  || die $this->{dbh}->errstr;
	
	# dec all ranks between current and next except current.	
	$this->{dbh}->do(qq~UPDATE $table SET $rank_field=$rank_field-1 WHERE $rank_field BETWEEN $rank_this AND $rank_next AND $id_field != $id~)  || die $this->{dbh}->errstr;
}

package FilmQuery;
@ISA = qw( Query );

sub fetch_query{
	my $this = shift;
	
	my $lang = $this->{lang};
	my $qs = "SELECT film_id, name_est, duration, year FROM film";

	my $sth = $this->{dbh}->prepare($qs) || die $dbh->errstr;
	$sth->execute() || die $sth->errstr;
	return $sth;
}

package TimetableQuery;
@ISA = qw( Query );

sub fetch_query{
	my $this = shift;
	
	my $qs = "SELECT timetable_id, date, film.name_est, cinema.name_est FROM timetable
				LEFT JOIN film ON timetable.film_id = film.film_id
				LEFT JOIN cinema ON timetable.cinema_id = cinema.cinema_id
				ORDER BY date
	";

	my $sth = $this->{dbh}->prepare($qs) || die $dbh->errstr;
	$sth->execute() || die $sth->errstr;
	return $sth;
}

package CinemaQuery;
@ISA = qw( Query );

sub fetch_query{
	my $this = shift;
	
	my $qs = "SELECT timetable_id, date, film.name_est, cinema.name FROM timetable
				LEFT JOIN film ON timetable.film_id = film.film_id
				LEFT JOIN cinema ON timetable.cinema_id = cinema.cinema_id
				ORDER BY date
	";

	my $sth = $this->{dbh}->prepare($qs) || die $dbh->errstr;
	$sth->execute() || die $sth->errstr;
	return $sth;
}
#####################################################################################
package ProgramQuery;
@ISA = qw( PageQuery );

sub _lang_test_string{}


#####################################################################################
package ImageQuery;
@ISA = qw( Query );

sub fetch_query{
	my $this = shift;
	
	my $qs = "SELECT catalog_id, name FROM catalog WHERE image = 1";
	my $sth = $this->{dbh}->prepare($qs) || die $dbh->errstr;
	$sth->execute() || die $sth->errstr;
	return $sth;
}

sub count_query{
	my $this = shift;
	my $qs = "SELECT count(*) FROM catalog	WHERE image = 1;";
	my $sth = $this->{dbh}->prepare($qs) || die $dbh->errstr;
	$sth->execute() || die $sth->errstr;
	return $sth->fetchrow_array();
}


package FileQuery;
@ISA = qw( Query );

sub fetch_query{
	my $this = shift;
	my $qs = "SELECT catalog_id, name FROM catalog	WHERE image = 0;";
	my $sth = $this->{dbh}->prepare($qs) || die $dbh->errstr;
	$sth->execute() || die $sth->errstr;
	return $sth;
}

sub count_query{
	my $this = shift;
	my $qs = "SELECT count(*) FROM catalog	WHERE image = 0;";
	my $sth = $this->{dbh}->prepare($qs) || die $dbh->errstr;
	$sth->execute() || die $sth->errstr;
	return $sth->fetchrow_array();
}

package BannerQuery;
@ISA = qw( Query );

sub fetch_query{
	my $this = shift;
	my $qs = "SELECT banner_id, disc FROM banner";
	my $sth = $this->{dbh}->prepare($qs) || die $dbh->errstr;
	$sth->execute() || die $sth->errstr;
	return $sth;
}

############################################################################
package StateQuery;
@ISA = qw( Query );

sub get_order_by{
	return " ORDER BY 2";	
}

############################################################################
package NewsQuery;
@ISA = qw( Query );

sub get_order_by{
	return " ORDER BY 2 DESC";	
}

sub fetch_query{
	my $this = shift;
	my $start = shift;
	$start +=0;
	
	my $table = $this->{table};
	if ($this->get_order_by){
		$order = $this->get_order_by;
	}
	
	$limit = " LIMIT $start," . $main::CONFIG{list_limit};
	$lang = $main::LANG;

	my $qs = "SELECT anima_news_2006_id, date, title FROM $table WHERE lang_id=$lang  $order $limit" ;

	my $sth = $this->{dbh}->prepare($qs) || die $dbh->errstr;
	$sth->execute() || die $sth->errstr;
	return $sth;
}

package UserQuery;
@ISA = qw( Query );

sub fetch_query{
	my $this = shift;
	my $start = shift;
	$start +=0;
	
	my $table = $this->{table};
	
	$limit = " LIMIT $start," . $main::CONFIG{list_limit};

	my $user = $main::USER;
	my $restriction = "WHERE username='$user' " if (! main::is_super_user());	
	
	my $qs = "SELECT * FROM $table $restriction $limit" ;

	my $sth = $this->{dbh}->prepare($qs) || die $dbh->errstr;
	$sth->execute() || die $sth->errstr;
	return $sth;
}



1;