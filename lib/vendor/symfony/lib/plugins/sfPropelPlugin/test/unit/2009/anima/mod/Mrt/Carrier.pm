package Mrt::Carrier;
use strict;
use warnings;
use Data::Dumper;
# abstract

sub set_carry_fields { my $this = shift; $this->{carry_fields} = shift; }
sub get_carry_fields { my $this = shift; return $this->{carry_fields}; }

sub add_carry_field {
	my $this = shift;
	my $key = shift;
	my $value = shift;
	$this->{carry_fields}->{$key} = $value;
}

sub _get_fields_and_values {
	my $this = shift;
	my $opt = shift;
	my $param = shift;
	my $retval;

	my %h = ();
	foreach my $key (keys %{$this->{carry_fields}}) {
		# don't put items specified in list $opt->{remove}
		next if (grep(/$key/, @{$opt->{remove}}));

		my $value;
		if (defined $this->{carry_fields}->{$key}) { # defined when class was inited (set_carry_fields({st=>2 vs. st=>undef}))
			$h{$key} = $this->{carry_fields}->{$key};
		} else { # value comes form parameters
			
			next unless $this->{g}->param($key);
		
			$h{$key} = $this->{g}->param($key);
		}
	}
	
	return %h;
}

sub _make_hiddens {
	my $this = shift;
	my $opt = shift || {};
	
	my $retval = '';
	my %h = $this->_get_fields_and_values($opt);
	
	for my $key (keys %h) {
		my $value = $h{$key};
		$retval .= qq~<input type=hidden name="$key" value="$value">\n~;
	}
	
	return $retval;
}

sub _add_base_path {
	my $this = shift;
	my $params = shift;
	my $opt = shift || {};
	
	my $retval = '?';
	my %h = $this->_get_fields_and_values($opt);
	
	for my $key (keys %h) {
		my $value = $h{$key};
		$retval .= qq~$key=$value&~;
	}

	return $retval . $params;
}

1;