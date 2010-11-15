package Tmpl;
$Tmpl::SINGLE = undef;
%Tmpl::TEMPLATES;
%Tmpl::FILES;

# singelton pattern
sub new {
   my $classname  = shift;     
	my $file = shift;
	my $retval;
	
	if ($Tmpl::SINGLE == undef){
		my $this  = {};           
	   bless($this, $classname); 
	   $retval = $Tmpl::SINGLE = $this;
	}else {
		$retval = $Tmpl::SINGLE;
	}
	if ($file and ! defined $Tmpl::FILES{$file}){ # load templates unless allready loaded
		$Tmpl::SINGLE->load_templates($file);
	}
	return $retval;
}

# loads templates into package variable
sub load_templates {
	my $this = shift;		
	my $file = shift;
	open IN, $file or die "can't open: '$file'";
	my $page = do { local $/, <IN> };
	close IN;
	$Tmpl::FILES{$file}=1;
	while ( $page =~ m/(^\w+)=\015?\012~([^~]*)~/mg){     # m- Enhanced line-anchor match mode ^ and $ at every logical line (not whole string)
		$Tmpl::TEMPLATES{$1} = $2;
	}
}

# returns named template with substituded parameters (<html>$_01</html>)
# $t->get_tmpl('temlate_name',1,2,3);
sub get_tmpl{
	my $this = shift;
	my $tmpl = shift;
	my $c = 1;
	my $retval;
	
	$retval = $Tmpl::TEMPLATES{$tmpl};
	$retval =~ s/\$_(\d\d)/@_[$1 - 1]/eg;

	return $retval;
}

1;