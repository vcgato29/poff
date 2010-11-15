package PageQuery;
@PageQuery::ISA = qw(Query);
use strict;
use funcs;
use Query;
use Mrt::Tree;
use Data::Dumper;

# use Mrt::Util('trace');
use constant NEXT     => 1;
use constant PREVIOUS => 2;

#use Mrt::Util('trace');

sub new {
	my $classname = shift;
	my $this      = {};
	bless($this, $classname);
	$this->{table} = shift;
	$this->{g}     = shift;
	$this->{rank}  = shift || 'rank';
	return $this;
}

sub set_lang { my $this = shift; $this->{lang} = shift; }

sub set_menu_getter {
	my $this = shift;
	# should by func ref to return menu tree object
	$this->{menu_getter} = shift;	
}

sub new_page {
	my $this = shift;
	my $id = shift;
	my $qs = sprintf('insert into %s_content values (?, "")', $this->{table});
	$this->{g}->execute($qs, $id);
}

sub fetch_query {
	my $this = shift;
	my $start_row = ($this->{g}->param("start") || 0);
	my $ids_ref = $this->{menu_getter}->()->get_ordered_ids();
	
	my @array = ();
	for my $id (@$ids_ref) {
		my $h_ref = $this->{menu_getter}->()->get_value($id);
		next if $h_ref->{dummy};
		$h_ref->{level} = $this->{menu_getter}->()->get_level($id);
		push @array, $h_ref;
	}
	
	return new Mrt::Iterator(\@array);
}

sub count_query {
	return 0;
}

sub _lang_test_string {
	my $this = shift;
	my $lang = $this->{lang};
	return "lang_id=$lang";
}

sub set_new_parent {
	my $this = shift;
	my $id = shift;
	my $new_parent = shift;
	
	my $max_rank = $this->_get_max_rank();
	my $tree = $this->get_tree();
	
	# check that request is valid
	return unless $tree->exists($id);
	return unless $tree->exists($new_parent);
	return if ($tree->is_descendant($new_parent, $id));
	my ($parent) = $this->_get_parent_and_rank($id);
	return if ($parent == $new_parent);

	$this->{g}->autocommit_off();
	$this->{g}->begin();
	
	my $ids = $tree->get_ordered_ids({start_id => $id});
	push @$ids, $id;
	$ids = join ', ', map { "'" . $_ . "'" } @$ids;	
	# increase rank of all the descendants
	my $qs = sprintf('update %s set rank = rank + %s where %s_id in(%s)',
		$this->{table},
		$max_rank,
		$this->{table},
		$ids);
	$this->{g}->execute($qs);

	# set the parent field 
	$qs = sprintf(pref 'update %s set parent_id = ? where %s_id = ?',
		$this->{table},
		$this->{table});
	
	undef $new_parent unless ($new_parent); # NULL instead on 0
	$this->{g}->execute($qs, $new_parent, $id);
	
	$this->_fix_ranks();
	
	$this->{g}->commit();
	$this->{g}->autocommit_on();
}

sub _fix_ranks {
	my $this = shift;
	$this->{g}->execute('set @r=0');
	$this->{g}->execute(sprintf 'update %s set rank = @r:=@r+1 order by rank', 
			$this->{table});
}

sub get_tree {
	my $this = shift;
	my $qs = sprintf('SELECT * FROM %s where lang_id=1 order by rank', 
								$this->{table});
	
	my $sth = $this->{g}->execute($qs);
	my $tree = Mrt::Tree->new();
	
	while (my @values = $sth->fetchrow_array()) {
		$tree->add_node($values[0], $values[1]); 
	}
	
	return $tree;
}

sub up_query {
	my $this = shift;
	my $idCurrent   = shift;

	my ($parentCurrent, $rankCurrent) = $this->_get_parent_and_rank($idCurrent);

	return unless (defined $rankCurrent);    # no such id

	my ($idPrevious, $rankPrevious) =
	  $this->_get_id_and_rank_of_sibling($parentCurrent, $rankCurrent, PREVIOUS);
	return unless (defined $idPrevious); # node is first [child]

	$this->_switchNodes($idPrevious, $rankPrevious, $idCurrent, $rankCurrent);
}

sub down_query {
	my $this = shift;
	my $idCurrent   = shift;

	my ($parentCurrent, $rankCurrent) = $this->_get_parent_and_rank($idCurrent);
	return if ($idCurrent eq $parentCurrent);

	my ($idNext, $rankNext) =
	  $this->_get_id_and_rank_of_sibling($parentCurrent, $rankCurrent, NEXT);
	return unless ($idNext && $rankNext); # node is first [child]

	$this->_switchNodes($idCurrent, $rankCurrent, $idNext, $rankNext);
}

sub _switchNodes {
	my $this = shift;
	my $idFirst = shift, 
	my $rankFirst = shift,
	my $idSecond = shift, 
	my $rankSecond = shift;
	
	$this->_update_rank($idFirst, '0'); 
	$this->_update_rank($idSecond, $rankFirst);
	$this->_increaseRanksBetween($rankFirst, $rankSecond);
	$this->_update_rank($idFirst, $rankFirst + 1);
}

sub _increaseRanksBetween {
	my $this = shift;
	my $min = shift;
	my $max = shift;
	my $qs = sprintf(
		q~update %s set rank=rank+1 
			where rank > ? and rank < ? order by rank desc~, 
			$this->{table}
		);
	$this->{g}->execute($qs, $min, $max);
}

sub _get_max_rank {
	my $this = shift;
	my $id   = shift;
	my $qs   = sprintf('select max(rank) from ' . $this->{table});

	return $this->{g}->execute($qs)->fetchrow_array();	
}

sub _update_rank {
	my $this = shift;
	my $id = shift;
	my $new_value = shift;
	my $qs = sprintf(
		'update %s set rank=? where %s_id=?', $this->{table}, $this->{table});

	$this->{g}->execute($qs, $new_value, $id);
}

sub _get_parent_and_rank {
	my $this = shift;
	my $id   = shift;
	my $qs   = sprintf(
		pref 'select parent_id, rank from %s where %s_id=?',
		$this->{table}, $this->{table}
	);

	return $this->{g}->execute($qs, $id)->fetchrow_array();
}

sub _get_id_and_rank_of_sibling {
	my $this          = shift;
	my $parentCurrent = shift;
	my $rankCurrent   = shift;
	my $direction     = shift;
	my $sign          = ($direction eq NEXT) ? ">" : "<";
	my $order 			= ($direction eq NEXT) ? "asc" : "desc";
	
	my $test = (!defined $parentCurrent) ? ' is null' : '=?';
	
	
	my $qs = sprintf
				pref q~select %s_id, rank from %s 
				where parent_id %s and rank%s? 
				order by rank %s;~, 
				$this->{table}, $this->{table}, $test, $sign, $order;

	my @to_bind = ($rankCurrent);
	unshift @to_bind, $parentCurrent if (defined $parentCurrent);
	
	return $this->{g}->execute($qs, @to_bind)->fetchrow_array();
}


1;
