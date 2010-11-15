package Mrt::Global;
use strict;
use warnings;
use CGI;
use DBI;
use Mrt::Tmpl;
use Mrt::Auth;
use AuthQuery;
use Mrt::Util('trace', 'join_hashes');
use Data::Dumper;
use constant DEBUG_DATABASE => 0; 

# use Session;

$Mrt::Global::default_conf_file = './conf.txt';

sub new {
	my $classname = shift;    # What class are we constructing?
	my $this      = {};       # Allocate new memory
	bless($this, $classname); # Mark it of the right type
	my $opt = shift;

	$this->{error_sub} = \&trace;

	
	my $conf_file = $opt->{conf} || $Mrt::Global::default_conf_file; 
	
	$this->load_conf($conf_file);

	$this->{cgi}  = new CGI;
	$this->{dbh}  = shift;
	$this->{tmpl} = new Mrt::Tmpl($this->conf('template_dir'));

	$this->{stash} = {};
	$this->{state} = {};

	$this->connect_it();
	$this->_add_url_params();
	
	return $this;
}

sub error {
	my $this = shift;
	$this->{error_sub}->(@_);
}

################################################################################
# dbh

sub connect_it {
	my $this = shift;

	$this->{dbh} = DBI->connect(
		'dbi:mysql:' . $this->conf('db_name') . ':' . $this->conf('db_addr'), $this->conf('db_user'),
		$this->conf('db_pass'), { PrintError => 1 }
	  ) || $this->{error_sub}->("can't connect: " . $!);
	  
	 $this->autocommit_on();
}

sub execute {
	my $this = shift;
	my $qs   = shift;
	my $sth  = $this->{dbh}->prepare($qs);
	print $qs . "<br>" if DEBUG_DATABASE;
	print "&nbsp;&nbsp;&nbsp;[" . (Dumper @_) . "]<br>" if (@_ && DEBUG_DATABASE);
	$sth->execute(@_) || warn($qs) && trace($sth->errstr);
	return $sth;
}

sub errstr {
	my $this = shift;
	return $this->{dbh}->errstr();
}

sub do {
	my $this = shift;
	# print @_ . "\n";
	return $this->{dbh}->do(@_) || trace() . "<br> @_";
}

sub quote {
	my $this = shift;
	return $this->{dbh}->quote(@_);
}

sub insert_id {
	my $this = shift;
	return $this->{dbh}->{'mysql_insertid'};
}

sub autocommit_on {
	my $this = shift;
	# print "autocommit on\n";
	$this->{dbh}->{AutoCommit} = 1;
}

sub autocommit_off {
	my $this = shift;
	# print "autocommit off\n";
	$this->{dbh}->{AutoCommit} = 0;
}

sub begin {
	my $this = shift;
	$this->{dbh}->do('BEGIN');
}

sub commit {
	my $this = shift;
	$this->{dbh}->commit;
}

sub rollback {
	my $this = shift;
	$this->{dbh}->rollback;
}

# dbh end
################################################################################

################################################################################
# cgi

sub vars {
	my $this = shift;
	return $this->{cgi}->Vars();
}

sub param {
	my $this = shift;
	my $key  = shift;
	
	$this->_add_url_params() unless $this->{url_params_added};
	
#	my $retval;
#	my $retval = join "lll", $this->{cgi}->param($key);
	
	my @tmp = $this->{cgi}->param($key);
	return (scalar @tmp == 1) ? $tmp[0] : @tmp;
	
#	# param converts 0 to ''
#	$retval = $this->{cgi}->Vars->{$key} unless $retval;
#	$retval = '' unless defined $retval;
#	return $retval;
}

sub _add_url_params {
	my $this = shift;
	my $p = $this->{cgi}->Vars;
	
	for ($this->{cgi}->url_param()) {
		$p->{$_} = $this->{cgi}->url_param($_) if (! exists $p->{$_});	
	}
	
	$this->{url_params_added} = 1;
}

sub get_input {
	my $this   = shift;
	my $p      = $this->{cgi}->Vars;
	my $retval = '';
	foreach my $param_name (keys %$p) {
		$retval .= $param_name . " = " . $p->{$param_name} . "<br>\n" 
			if ($p->{$param_name});
	}
	return $retval;
}

sub show_input {
	my $this = shift;
	print $this->get_input();
}

# cgi end
################################################################################

################################################################################
# template

sub tmpl {
	my $this       = shift;
	my $tmpl       = shift;
	my $extra_params = @_;
	my $values_ref = {};
	
	if ($extra_params) {
		$values_ref = _get_value_ref(@_);
	}
	
	my $text_ref;
	if ($tmpl =~ m/\.html$/i) {
		$text_ref =
		  Mrt::Util::read_file($this->conf('template_dir') . '/' . $tmpl);
	}
	else {
		$text_ref =
		  $this->{tmpl}->get($tmpl, $values_ref, { no_substitution => 1 });
	}

#	$$text_ref =~
#	  s/\$([^\$]+)\$/${_ensure_ref(\$values_ref->{$1})} || ${_ensure_ref(\$this->{config}->{$1})} || ''/eg;

	$$text_ref =~
	  s/\$([^\$]+)\$/${&_get_value_as_ref($values_ref, $1)} || $this->{config}->{$1} || ''/eg;

	return $$text_ref;
}

sub _get_value_as_ref {
	my $values_ref = shift;
	my $name = shift;
	return \ '' if (! exists $values_ref->{$name});
	return (ref $values_ref->{$name} eq 'SCALAR') ? 
			$values_ref->{$name} : 
			\$values_ref->{$name};
}

sub _get_value_ref {
	my @params = @_;
	return $params[0] if (ref $params[0] eq 'HASH');
	my $retval = {};
	my $cnt = 1;
	for my $param (@params) {
		my $key = sprintf('_%.2d', $cnt++);
		$retval->{$key} = $param;
	}
	return $retval;
}


################################################################################
# auth

sub _get_auth_object {
	my $this = shift;
	return $this->{stash}->{auth_object} ||= new Mrt::Auth(
		$this->conf('tmp_dir'),
		new AuthQuery($this),
		$this->conf('session_timeout')
	);
}

sub login {
	my $this = shift;
	my $user = shift;
	my $pass = shift;
	$this->_get_auth_object()->login($user, $pass);
}

sub get_rights {
	my $this  = shift;
	my $token = shift;
	return @{ $this->{rights} } = $this->_get_auth_object()->get_rights($token);
}

sub has_right {
	my $this  = shift;
	my $right = shift;

	trace("get_rights(<token>) must be called first")
	  if (!defined $this->{rights});

	for my $r (@{ $this->{rights} }) {
		return 1 if ($r eq $right);
	}
	return 0;
}

################################################################################
# session

sub init_session {
	my $this       = shift;
	my $id         = shift;
	my $table_name = shift;
	my $how_old    = shift;
	$this->{session} = new Session($this->{dbh}, $id, $table_name, $how_old);
}

sub get_session_value {
	my $this = shift;
	return $this->{session}->get(shift);
}

sub set_session_value {
	my $this = shift;
	return $this->{session}->set(shift, shift);
}

sub save_session {
	my $this = shift;
	$this->{session}->save();
}

# session end
################################################################################

# conf

# adds all conf entries to h_ref inputed
sub add_conf_entries {
	my $this  = shift;
	my $h_ref = shift;

	while (my ($k, $v) = each %{ $this->{config} }) {
		$this->error("double entry from conf: '" . $k . "'")
		  if (exists $h_ref->{$k});
		$h_ref->{$k} = $v;
	}
}

sub load_conf {
	my $this = shift;
	my $file = shift;
	open my $fh, $file or die "can't open: '$file'";

	while (my $line = <$fh>) {

		next unless $line =~ m/^([\w\d]+)=([^\n\r]*)$/g;    
		my $key   = $1;
		my $value = $2;
		$value =~ s/\${(\w+)}/$this->{config}->{$1}/g;

		# print "$key '$value' <br>";
		$this->{config}->{$key} = $value;
	}

	my @tmp = split /\//, $0;
	$this->{config}->{script} = $tmp[-1];

	close $fh;
}

sub conf {
	my $this = shift;
	my $key  = shift;
	$this->error("no such conf entry: '$key'")
	  unless exists $this->{config}->{$key};
	return $this->{config}->{$key};
}

################################################################################
# stash

sub put {
	my $this  = shift;
	my $key   = shift;
	my $value = shift;
	$this->{stash}{$key} = $value;
}

sub get {
	my $this = shift;
	my $key  = shift;
	return $this->{stash}->{$key};
}

sub remove {
	my $this = shift;
	my $key  = shift;
	delete $this->{stash}->{$key};
}

################################################################################
# state

sub get_state {
	my $this  = shift;
	my $key   = shift;
	return $this->{state}->{$key};
}

sub set_state {
	my $this  = shift;
	my $key   = shift;
	my $value = shift;
	$this->{state}->{$key} = $value;	
}

sub hstate {
	my $this = shift;
	my $str = shift || '';
	my ($path, $params_href) = _get_parts($str);
   my $joined_href = join_hashes($this->{state}, $params_href);
   my $retval = '';
	for my $key (keys %{$joined_href}) {
		next if $joined_href->{$key} eq '';
      $retval .= sprintf '<input type="hidden" name="%s" value="%s">' . "\n", 
      		$key, $joined_href->{$key};
	}
   return $retval;
}

sub ustate {
	my $this = shift;
	my $str = shift || '';
	my ($path, $params_href) = _get_parts($str);
   my $joined_href = join_hashes($this->{state}, $params_href);
   my @pairs = ();
	for my $key (keys %{$joined_href}) {
		next if $joined_href->{$key} eq '';
      push @pairs, $key . '=' . $joined_href->{$key};
	}
	$path ||= '?';
   return $path . join '&', @pairs;
}

sub _get_parts {
	my $str = shift;
   $str =~ m/([^\?]*\?)?(.*)/;
   my $path = $1 || '';  
   my $params = $2 || '';
   my @pairs = split /&/, $params;
   my %params = ();
   for my $pair (@pairs) {
   	my ($key, $val) = split /=/, $pair;
      $params{$key} = $val;
   }
   return $path, \%params;
}

1;
