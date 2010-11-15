package SearchRestriction;
use strict;
use warnings;
use Mrt::Util('trace');

use AbstractBean;
@SearchRestriction::ISA = qw(AbstractBean);

sub new {
   my $classname = shift;
	my $this  = {};
   bless($this, $classname);
   $this->{$_} = '' for (qw/name value op/);
   return $this;
}

1