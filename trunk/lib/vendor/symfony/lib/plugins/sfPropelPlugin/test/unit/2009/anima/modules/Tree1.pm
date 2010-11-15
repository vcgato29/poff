package _Node;

my %fields = (
   level => undef,
   id => undef,
   parent_id => undef,
	value => undef
);

sub new {
   my $classname  = shift;         # What class are we constructing?
	my $this  = {};                 # Allocate new memory 
   bless($this, $classname);       # Mark it of the right type
   
	$this->{id} = shift;
   $this->{parent_id} = shift;
   $this->{level} = shift;
   $this->{value} = shift;
   
   $this->{childs} = [];
   return $this;                		# And give it back
}

sub add_child{
	my $this = shift;
	my $node = shift;
	push @{$this->{childs}}, $node;
}

sub get_parent_id{ my $this = shift; 	return $this->{parent_id};	 }
sub get_id{ my $this = shift; 	return $this->{id};	 }
sub get_level{ my $this = shift; 	return $this->{level};	 }
sub get_value{ my $this = shift; 	return $this->{value};	 }
sub set_level{ my $this = shift; $this->{level} = shift;}

package Tree1;
#use Data::Dumper;

my %fields = (
   root => undef,
   lookup => undef
);

sub new {
   my $classname  = shift;         # What class are we constructing?
	my $this  = {};                 # Allocate new memory 
   bless($this, $classname);       # Mark it of the right type
   
	$this->{lookup} = {};
   
   my $node = new _Node(0,-1,-1); # make root node
   $this->{root} = $node;
   $this->{lookup}->{0} = $node;
   
   return $this;                		# And give it back
}

sub get_level{
	my $this = shift;
	my $id = shift;
	my $node = $this->_get_node($id);
	return $node->get_level();
}

sub get_first_level_id{
	my $this = shift;
	my $id = shift;
	my $node = $this->_get_node($id);
	while ($node->get_level() > 0){
		$id = $node->get_parent_id($id);	
		$node = $this->_get_node($id);
	}
	return $id;
}

sub get_child_ids{
	my $this = shift;
	my $id = shift;
	die 'no id specified on &get_child_ids()' unless ($id);
	my $node = $this->_get_node($id);
	
	my @retval;
	foreach my $s (@{$node->{childs}}) {		
		push @retval , $s->get_id();
   }
	return @retval;
}

sub get_value{
	my $this = shift;
	my $id = shift;
	my $node = $this->_get_node($id);
	return $node->get_value();
}

sub _get_parent{
	my $this = shift;
	my $id = shift; die ('no id') unless ($id);
	my $node = $this->_get_node($id);
	my $parent_id = $node->get_parent_id();
	return $this->_get_node($parent_id);	
}

sub is_first{
	my $this = shift;
	my $id = shift;
	my $node = $this->_get_node($id);
	my $parent = $this->_get_parent($id);
	return ($node == $parent->{childs}->[0]);
}

sub is_last{
	my $this = shift;
	my $id = shift;
	my $node = $this->_get_node($id);
	my $parent = $this->_get_parent($id);
	return ($node == $parent->{childs}->[-1]);
}

sub _get_node{ # gets node by id
	my $this = shift;
	my $id = shift;
	my $node = $this->{lookup}->{$id};
	die "no such node: $id (probably refress pressed when page allready deleted" unless ($node);
	return $node
}

sub add_node {
	my $this = shift;
	my $id = shift;
	my $parent_id = shift;
	my $value = shift;

#	print main::my_caller(1);	
	my $level = $this->{lookup}->{$parent_id}->get_level() + 1;
	my $node = new _Node($id,$parent_id,$level,$value);
	$this->{lookup}->{$id} = $node;

	my $parent = $this->_get_node($parent_id);
	$parent->add_child($node);
}

sub get_ids{ # returns all ids
	my $this = shift;
	my @keys = keys %{$this->{lookup}};
	return @keys;
}

sub get_ordered_ids{ # returns arrayref of (depth_first)ordered ids
   my $this = shift;
	my $node = shift; # hash ref on first call - node on recursive ones
	my $ids = shift;
	my $id_to_skip = shift;

	if (ref $node eq 'HASH'){
		$id_to_skip = $node->{no_descendants};	
		$node = undef;
	}

	$node = $this->_get_node(0) unless ($node);
	
	foreach my $n (@{$node->{childs}}) {		
		next if ($n->{'id'} eq $id_to_skip);
		push @$ids, $n->{'id'};
		$this->get_ordered_ids($n,$ids,$id_to_skip);
   }
	
	return $ids;
}

sub dump_tree {
   my $this = shift;
	my $node = shift;
	$node = $this->_get_node(0) unless ($node);
	
	foreach my $s (@{$node->{childs}}) {		
		printf "&nbsp;&nbsp;&nbsp;" x ($s->get_level());
		print $s->get_level()," - ",$s->{'id'},"<br>";	
		$this->dump_tree($s);
   }
}

package MenuTree;
@ISA = qw( Tree1 );

sub build_menu{
   my $this = shift;
	my $node = shift;
	my $retval = shift;
	my $hiddens = shift;
	my $first = 0;
	my $prop = '';
	
	unless ($node){ # first element
		$node = $this->_get_node(0);
		$prop = qq~ id=menu style="VISIBILITY: hidden" ~;
	}
	
	if (scalar @{$node->{childs}}){
		$$retval .= qq~<UL $prop>\n~;	
	}
	
	foreach my $n (@{$node->{childs}}) {		
		my $val = $n->get_value();
		next if (@$val[6] and ! $hiddens); # @$val[6] is hidden flag
		$$retval .= "<li>";
		my $name = @$val[2];
		$$retval .= $name;
   	$this->build_menu($n,$retval,$hiddens);
   	$$retval .= "</li>\n"; 
   }
	
	if (scalar @{$node->{childs}}){
		$$retval .= qq~</UL>\n~;	
	}
	
	return $retval;
}

1;