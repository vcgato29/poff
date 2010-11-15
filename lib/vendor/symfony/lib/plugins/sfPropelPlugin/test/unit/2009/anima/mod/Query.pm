package Query;
use Data::Dumper;
use Mrt::Iterator;
use strict;
use warnings;

sub new {
   my $classname  = shift;
	my $this  = {};
   bless($this, $classname);
   $this->{table} = shift;
   $this->{g} = shift;
   # $this->{rank} = shift;
   return $this;
}

# this form fetches html and produces fetch_query restrictions
sub set_restriction_form {
	my $this = shift;	
	my $rf = shift;
	$this->{restriction_form} = $rf;
}

sub set_fields { my $this = shift; @{$this->{fields}} = @_; }
sub set_global { my $this = shift; $this->{g} = shift; }
sub set_parent_field { my $this = shift; $this->{parent_field} = shift; }
sub set_lang { my $this = shift; $this->{lang} = shift; }
sub set_order_by { my $this = shift; $this->{order_by} = shift; }
sub get_order_by { my $this = shift; return $this->{order_by} || '' }


sub fetch_query {
	my $this = shift;
	my $start = shift || '0';
	
	my $table = $this->{table};
	my $rank_field = $this->{rank};
	my $id_field = $this->{table} . '_id';
	
	die "no fields specified" if (! defined $this->{fields} or scalar @{$this->{fields}} == 0);
	my $fields = join ", ", @{$this->{fields}};
	
	my $limit = " LIMIT $start, " . $this->{g}->conf('list_page_size');
	my $lang = $this->{g}->get('lang');
	my $order_by = $this->{order_by} ? "order by " . $this->{order_by} . " desc" : '';
	my $qs = "SELECT $id_field as id, $fields FROM $table where lang_id=$lang $order_by $limit";
	my $sth = $this->{g}->execute($qs);
	
	my @array = ();
	
	while(my $h_ref = $sth->fetchrow_hashref){
		push @array, $h_ref;
	}
	
	#$sth->execute() || die $sth->errstr;
	#return $sth;
	
	#print Dumper @array;
	
	return new Mrt::Iterator(\@array);

}



sub fetch_query2 {
	my $this = shift;
	my $start_row = ($this->{g}->param("start") || 0);
	my @data = ();
	
	unless ($start_row) {
		@data = ([1, 'user 1', '1@hot.ee'], [2, 'user 2', '2@hot.ee']);
	} else {
		@data = ([3, 'user 3', '3@hot.ee'], [4, 'user 4', '4@hot.ee']);
	}
	
	my @array = ();
	for my $a_ref (@data) {
		my $h_ref = {};
		$h_ref->{id} = $a_ref->[0];
		$h_ref->{name} = $a_ref->[1];
		$h_ref->{mail} = $a_ref->[2];
		push @array, $h_ref;
	}
	
	return new Mrt::Iterator(\@array);
}


sub fetch_query1 {
	my $this = shift;
	my $table = $this->{table};
	my $start_row = ($this->{g}->param("start") || 0);
	
	my $restrictions = $this->{restriction_form} ? $this->{restriction_form}->get_sql()
																: '';
	my $limit = " LIMIT $start_row," . $this->{g}->conf('list_page_size');
	my $qs = "SELECT mail_list_id, name, mail FROM $table where 1=1 $restrictions order by mail $limit";
	my $sth = $this->{g}->execute($qs);
	
	my @array = ();
	while ( my (@tmp) = $sth->fetchrow_array()) {
		my $h_ref = {};
		$h_ref->{id} = shift @tmp;
		$h_ref->{name} = shift @tmp;
		$h_ref->{mail} = shift @tmp;
		push @array, $h_ref;
	}
	
	my $iter = new Mrt::Iterator(\@array);
	return $iter;
}

sub count_query {
	my $this = shift;
	my $table = $this->{table};
	my $lang = $this->{g}->get('lang');
	my $qs = "SELECT count(*) FROM $table where lang_id = $lang";
	my $sth = $this->{g}->execute($qs);
	return $sth->fetchrow_array();
}

sub _get_id_field {	my $this = shift;  	return $this->{table}."_id";	}

sub delete_query {
	my $this = shift;
	my $id = shift;
	my $table = $this->{table};
	my $qs = "delete from $table where $table"."_id=$id";
	$this->{g}->do($qs);
}

1;