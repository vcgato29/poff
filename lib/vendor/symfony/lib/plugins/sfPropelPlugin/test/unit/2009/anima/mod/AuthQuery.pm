package AuthQuery;
use Data::Dumper;
use Mrt::Util('trace');
use Mrt::Iterator;
use strict;
use warnings;

sub new {
	my $classname  = shift;     # What class are we constructing?
	my $this  = {};             # Allocate new memory   
	bless($this, $classname);   # Mark it of the right type
	$this->{g} = shift;
	return $this;
}

sub verify_user {
	my $user = shift;
	my $pass = shift;

	return 1;	
}

sub fetch_rights {
	my $this = shift;
	my $user = shift;
	
	my @rights = ();
	@rights = ('r1', 'r2') if ($user eq 'mrt');
	@rights = ('r1') if ($user eq 'test');
	
	return new Mrt::Iterator(\@rights);
}

1;