package AbstractBean;
use strict;
use warnings;

our $AUTOLOAD;

sub AUTOLOAD {
   my $this = shift;
   my $type = ref ($this) || die "$this is not an object";
   my $method_name = $AUTOLOAD;

   if (my $f = _get_getfield($method_name)) {
		die "no such field: '$f'" if (! exists $this->{$f});
		return $this->{$f};
	}
	if (my $f = _get_setfield($method_name)) {
		die "no such field: '$f'" if (! exists $this->{$f});
		$this->{$f} = shift;
	}
}

sub _get_getfield {
	my $method = shift;
	$method =~ m/.*:get_(\w+)/;
	return $1;
}

sub _get_setfield {
	my $method = shift;
	$method =~ m/.*:set_(\w+)/;
	return $1;
}

1