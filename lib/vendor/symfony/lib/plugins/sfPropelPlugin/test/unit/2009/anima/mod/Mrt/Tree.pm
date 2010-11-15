package Mrt::_Node;
use strict;

sub new {
	my $classname = shift;    # What class are we constructing?
	my $this      = {};       # Allocate new memory
	bless($this, $classname); # Mark it of the right type

	$this->{id}        = shift;
	$this->{parent_id} = shift;
	$this->{level}     = shift;
	$this->{value}     = shift;

	$this->{children} = [];
	return $this;             # And give it back
}

sub add_child {
	my $this = shift;
	my $node = shift;
	push @{ $this->{children} }, $node;
}

sub get_parent_id { my $this = shift; return $this->{parent_id}; }
sub get_id        { my $this = shift; return $this->{id}; }
sub get_level     { my $this = shift; return $this->{level}; }
sub get_value     { my $this = shift; return $this->{value}; }
sub set_level     { my $this = shift; $this->{level} = shift; }

package Mrt::Tree;
use strict;
use Data::Dumper;
use Mrt::Util(qw/trace da/);

sub new {
	my $classname = shift;    # What class are we constructing?
	my $this      = {};       # Allocate new memory
	bless($this, $classname); # Mark it of the right type

	$this->{lookup} = {};

	my $node = new Mrt::_Node(0, -1, -1);    # make root node
	$this->{root} = $node;
	$this->{lookup}->{0} = $node;

	return $this;                       # And give it back
}

sub get_level {
	my $this = shift;
	my $id   = shift;
	my $node = $this->_get_node($id);
	return $node->get_level();
}

sub get_first_level_id {
	my $this = shift;
	my $id   = shift;
	
	my $node = $this->_get_node($id);
	
	while ($node->get_level() > 0) {
		$id   = $node->get_parent_id($id);
		$node = $this->_get_node($id);
	}
	return $id;
}

sub get_child_ids {
	my $this = shift;
	my $id   = shift;
	my $node = $this->_get_node($id);

	my @retval;
	foreach my $s (@{ $node->{children} }) {
		push @retval, $s->get_id();
	}
	return @retval;
}

sub get_value {
	my $this = shift;
	my $id   = shift;
	my $node = $this->_get_node($id);
	return $node->get_value(); 
}

sub is_descendant {
	my $this = shift;
	my $id_child   = shift;
	my $id_parent   = shift;
	
	# print "$id_child, $id_parent\n";
	
	# require Mrt::Util;
	
	my $runner = $id_child;
	while ($runner != 0) {
		# print $runner, "r: \n";
		return 1 if $runner == $id_parent;
		# Mrt::Util::da {die "done"} 30;
		my $node = $this->_get_node($runner);
		$runner = $node->get_parent_id();
	}
	
	return 0;
}

sub _get_parent {
	my $this = shift;
	my $id   = shift;
	my $node      = $this->_get_node($id);
	my $parent_id = $node->get_parent_id();
	return $this->_get_node($parent_id);
}

sub is_first {
	my $this   = shift;
	my $id     = shift;
	my $node   = $this->_get_node($id);
	my $parent = $this->_get_parent($id);
	return ($node == $parent->{children}->[0]) ? 1 : 0;
}

sub is_last {
	my $this   = shift;
	my $id     = shift;
	my $node   = $this->_get_node($id);
	my $parent = $this->_get_parent($id);
	return ($node == $parent->{children}->[-1]) ? 1 : 0;
}

sub _get_node { # gets node by id
	my $this = shift;
	my $id   = shift;
	my $node = $this->{lookup}->{$id};
	trace "no node with id: '$id'" unless $node;
	return $node;
}

sub exists {
	my $this = shift;
	my $id   = shift;
	return (defined $this->{lookup}->{$id}) ? 1 : 0;
}

sub add_node {
	my $this      = shift;
	my $id        = shift;
	my $parent_id = shift;
	my $value     = shift;

	my $parent;
	if ($this->exists($parent_id)) {
		$parent = $this->_get_node($parent_id);
	} else {
		$parent = $this->_get_node(0);
	}

	my $level = $parent->get_level() + 1;
	my $node = new Mrt::_Node($id, $parent_id, $level, $value);
	$this->{lookup}->{$id} = $node;
	$parent->add_child($node);
}

sub get_ids {    # returns all ids
	my $this = shift;
	my @keys = grep { $_ != 0 } keys %{ $this->{lookup} };
	return @keys;
}

sub get_ordered_ids {    # returns arrayref of (depth_first)ordered ids
	my $this       = shift;
	my $node       = shift;    # hash ref on first call - node on recursive ones
	my $ids        = shift || [];
	my $id_to_skip = shift || '';

	if (ref $node eq 'HASH') {
		$id_to_skip = $node->{no_descendants} || '';
		if ($node->{start_id}) {
			$node = $this->_get_node($node->{start_id});
		} else {
			$node = undef;
		}
	}

	$node = $this->_get_node(0) unless ($node);

	foreach my $n (@{ $node->{children} }) {
		next if ($n->{'id'} eq $id_to_skip);
		push @$ids, $n->{'id'};
		$this->get_ordered_ids($n, $ids, $id_to_skip);
	}

	return $ids;
}

sub dump_tree {
	my $this = shift;
	my $node = shift;
	$node = $this->_get_node(0) unless ($node);

	foreach my $s (@{ $node->{children} }) {
		printf "   " x ($s->get_level());
		# print $s->get_level(), " - ", $s->{'id'}, "\n";
		print $s->{'id'}, "\n";
		$this->dump_tree($s);
	}
}

1;
