package MenuTree;
use Mrt::Tree;
use Data::Dumper;
@MenuTree::ISA = qw(Mrt::Tree);

sub get_value {
	my $this = shift;
	my $id   = shift;
	return undef unless $this->exists($id);
	return $this->SUPER::get_value($id);
}

sub build_menu {
	my $this    = shift;
	my $node    = shift;
	my $retval  = shift;
	my $hiddens = shift;
	my $first = 0;
	my $prop    = '';

	if (! defined $retval) {
		my $a = ''; $retval = \$a;
	}

	unless ($node) {    # first element
		$node = $this->_get_node(0);
		$prop = qq~ id=menu style="VISIBILITY: hidden" ~;
		$first = 1;
	}

	if ($this->ul_needed($node->{children})) {
		$$retval .= qq~\n<UL $prop>\n~;
	}
	
	my $c = 0;
	foreach my $n (@{ $node->{children} }) {
		my $val = $n->get_value();
		next if ($val->{hidden} and !$hiddens);    # @$val[6] is hidden flag
		$$retval .= "<li></li>" if ($first and $c++);
		$$retval .= "<li>";
		$$retval .= $val->{link};
		
		
		$this->build_menu($n, $retval, $hiddens);
		$$retval .= "</li>\n";
	}

	if ($this->ul_needed($node->{children})) {
		$$retval .= qq~</UL>\n~;
	}

	return $retval;
}

sub ul_needed {    
	my $this          = shift;
	my $child_arr_ref = shift;

	#  ul is needed when there has not hidden children
	foreach my $c (@{$child_arr_ref}) {
		my $val = $c->get_value();
		return 1 if ($val->{hidden} == 0);
	}
	return 0;
}

1;
