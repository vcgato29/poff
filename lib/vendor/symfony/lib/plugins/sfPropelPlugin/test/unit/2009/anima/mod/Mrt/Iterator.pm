package Mrt::Iterator;
use strict;
use warnings;

sub new {
   my $classname  = shift;  
	my $this  = {};           
	$this->{array_ref} = shift;
	$this->{pos} = 0;
   bless($this, $classname); 
	return $this;
}

sub as_array {
	my $this = shift;
	return @{$this->{array_ref}};
}

sub is_first {
	my $this = shift;	
	return $this->{pos} == 1 ? 1 : 0;
}

sub has_next {
	my $this = shift;
	return defined $this->{array_ref}->[$this->{pos}] ? 1 : 0;
}

sub next {
	my $this = shift;
	die 'no more items' if ! $this->has_next();
	return $this->{array_ref}->[$this->{pos}++];
}

1;