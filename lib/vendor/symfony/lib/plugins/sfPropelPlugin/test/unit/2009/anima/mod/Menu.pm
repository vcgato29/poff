package Menu;
use strict;
use warnings;
use Mrt::Tree;
use Data::Dumper;

@Menu::ISA = ('Mrt::Tree');

# this function procces node to get value for html output
# $retval .= $this->{func}->($h_ref);
sub set_func {
	my $this = shift;
	$this->{func} = shift;
}

sub get_html {
   my $this = shift;
	my $node = shift;
	my $retval = shift;
	my $hiddens = shift; # show hiddens in output
	
	my $first = 0;
	my $prop = '';

	unless ($node){ # first element
		$$retval = '';
		$node = $this->_get_node(1);
		$prop = qq~ id=menu style="VISIBILITY: hidden" ~;
		$first = 1;
	}
	
	if ($this->ul_needed($node->{children})){
		$$retval .= qq~\n<UL $prop>\n~;	
	}

	my $c = 0;
	foreach my $n (@{$node->{children}}) {		
		my $h_ref = $n->get_value();
		next if ($h_ref->{hidden} and ! $hiddens); # is hidden flag
		$$retval .= "<li></li>" if ($first and $c++);
		$$retval .= "<li>";
		$$retval .= $this->{func}->($h_ref);
   	$this->get_html($n, $retval, $hiddens);
   	$$retval .= "</li>\n"; 
   }
	
	if ($this->ul_needed($node->{children})){
		$$retval .= qq~</UL>\n~;	
	}
	
	return $retval;
}

sub ul_needed {
	my $this = shift;
	my $child_arr_ref = shift;
	# ul is needed when there are not hidden children
	foreach my $n (@{$child_arr_ref}) {
		my $h_ref = $n->get_value();
		return 1 if ($h_ref->{hidden} == 0);
	}
	return 0;
}

#sub get_id_from_virtual_path {
#	my $this = shift;
#	my $path = shift;
#	my $node = shift;
#	my $id;
#	
#	unless ($node){ # first element
#		$node = $this->_get_node(0);
#	}
#	
#	foreach my $n (@{$node->{children}}) {
#		my $values = $n->get_value();
#		if ($$values[12] eq $path) {
#			return $n->get_id();
#		}
#		last if ($id);
#		$id = $this->get_id_from_virtual_path($path,$n);
#	}

#	return $id;
#}

1;