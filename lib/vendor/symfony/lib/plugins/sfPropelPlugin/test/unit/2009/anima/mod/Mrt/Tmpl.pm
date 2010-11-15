package Mrt::Tmpl;
use Data::Dumper;
use Mrt::Util('trace');
use strict;
use warnings;

$Mrt::Tmpl::file_ext='.tpl';

sub new {
	my $classname  = shift;     # What class are we constructing?
	my $this  = {};             # Allocate new memory   
	bless($this, $classname);   # Mark it of the right type
	$this->{dir} = shift;
	return $this;
}

# loads templates into package variable
sub _load_templates {
	my $this = shift;
	my $path = shift;
	my $bundle = _get_bundlename($path);
	
	my $page = Mrt::Util::read_file($path);
	while ( $$page =~ m/(^[\w.]+)=(?:\r?\n)?~([^~]*)~/mg) { # m- Enhanced line-anchor match mode ^ and $ at every logical line (not whole string)
		$this->{$bundle}->{$1} = $2;
	}
}

sub _get_file_path {
	my $this = shift;
	my $name = shift;
	my ($bundle, $name) = split(/\./, $name, 2); # list, odd_row
	return $this->{dir} . '/' . $bundle . $Mrt::Tmpl::file_ext;
}

sub _get_bundlename { # static
	my $path = shift;
	my $ext = $Mrt::Tmpl::file_ext;
	my ($bn) = $path =~ m/([\w\d]+)$ext$/g; # templates/list.tpl -> list
	return $bn;
}

# returns named template with substituded parameters (<html>$var$</html>) -> <html>test</html>
# $t->get('temlate_name',{var=>'test'});
sub get {
	my $this = shift;
	my $name_in = shift; # list.odd_row
	my $values_ref = shift;
	my $opt = shift || {};
	my ($bundle, $name) = split(/\./, $name_in, 2); # list, odd_row
	
	if (! exists $this->{$bundle}->{$name}){
		$this->_load_templates($this->_get_file_path($name_in));
		trace("no such template: '$name_in'") unless (exists $this->{$bundle}->{$name});
	}
	
	my $retval = $this->{$bundle}->{$name};

	unless( exists $opt->{no_substitution} ) {
		$retval =~ s/\$([^\$]+)\$/$values_ref->{$1} || ''/eg;
	}

	return \$retval;
}

1;