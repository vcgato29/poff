package Mrt::Auth;
use Data::Dumper;
use Mrt::Util('trace');
use strict;
use warnings;

sub new {
	my $classname = shift;     # What class are we constructing?
	my $this  = {};            # Allocate new memory
	bless($this, $classname);  # Mark it of the right type
	$this->{tmp_dir} = shift;
	$this->{query} = shift;
	$this->{timeout} = (shift || 15) * 60; # entered in minutes
	return $this;
}

# verifies that user exists and generates token if yes
sub login {
	my $this = shift;
	my $user = shift || '';
	my $pass = shift || '';
	
	$this->_delete_expired_tokens();
	
	if ($this->{query}->verify_user($user, $pass)) {
		my $token = Mrt::Util::rand_string(20);
		$this->_write_token($token, $user);
		return $token;
	} else {
		return undef;
	}
}

# returns rights for token
sub get_rights {
	my $this = shift;
	my $token = shift;
	$token =~ m/[^\w\n]+/ and trace("token contains forbiden characters. token: '$token'");
	return if ($this->_is_token_expired($token));
	my $user = $this->_get_user_from_token($token);
	return unless (defined $user);	
	$this->_refresh_token($token);
	return $this->{query}->fetch_rights($user)->as_array();
}

sub _refresh_token {
	my $this = shift;
	my $token = shift;
	my $path = $this->{tmp_dir} . '/' . $token;
	utime(time(), time(), $path);
}

sub _get_user_from_token {
	my $this = shift;
	my $token = shift;
	my $path = $this->{tmp_dir} . '/' . $token;
	return ${Mrt::Util::read_file($path)};
}

sub _write_token {
	my $this = shift;
	my $token = shift;
	my $user = shift;
	my $path = $this->{tmp_dir} . '/' . $token;
	Mrt::Util::write_file($path, \$user);
}

sub _is_token_expired {
	my $this = shift;
	my $token = shift;
	my $path = $this->{tmp_dir} . "/" . $token;
	return 1 if (! -e $path);
	my $mtime = ((stat($path))[9]); # modification time
 	return ((time - $mtime) > $this->{timeout}) ? 1 : 0;
}

sub _delete_expired_tokens {
	my $this = shift;
	my $cnt = 0;
	opendir my $dh, $this->{tmp_dir} or trace("can't open dir, reason: '$!'");
	while ($_ = readdir $dh) {
		$_ =~ /^\./ and next;
		if ($this->_is_token_expired($_)) {
 			unlink $_;
 			last if ($cnt++ > 50); # Stop after 50 deleted files			
		}
	}
	close $dh;
}

1;