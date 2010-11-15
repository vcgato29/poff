package FileManager;
use strict;
use warnings;
use Data::Dumper;
use Mrt::Util('trace');
#use File::Path();
#mkpath('/foo/bar/baz', 1, 0711); # 1 - print info
#rmtree('foo/bar/baz', 1, 1); print info, skip unaccessible

sub new {
	my $classname = shift;
	my $this  = {};
	bless($this, $classname);
   
	$this->{g} = shift;
	$this->{root_path} = shift;
	
	return $this;
}

sub delete_file {
	my $this = shift;
	my $relative_path = shift;
	my $filename = normalize_filename(shift);
	my $abs_path = $this->_add_root_path($relative_path . '/' . $filename);
	unlink_file($abs_path);
}

sub rename_file {
	my $this = shift;
	my $relative_path = shift;
	my $old_name = shift;
	my $new_name = shift;
	my $old_path = $this->_add_root_path($relative_path . '/' . $old_name);
	my $new_path = $this->_add_root_path($relative_path . '/' . $new_name);
	rename_file_sub($old_path, $new_path);
}

sub new_folder {
	my $this = shift;
	my $relative_path = shift;
	my $name = normalize_filename(shift);
	$this->make_dir($relative_path . '/' . $name);
	return $name;
}

sub _add_root_path {
	my $this = shift;
	my $relative_path = shift;
	return $this->{root_path} . '/' . $relative_path;
}

sub get_folder_list {
	my $this = shift;
	my $path = $this->_add_root_path('./');
	# get only name (not path)
	return map { $_=~ m!(.*/)?(.+)!; $2 } grep { -d $_ } <$path*>;
}

sub get_file_list {
	my $this = shift;
	my $folder = shift;
	my $path = $this->_add_root_path($folder);
	
	return map { $_=~ m!(.*/)?(.+)!; $2 } <$path/*.*>;
}

sub normalize_filename {
	my $name = shift;
	$name =~ s/[^-\w\.]/_/g; # - . \w are allowed
	$name =~ s/^\./_/; # can't start with .
	return $name;
}

sub _get_write_path {
	my $this = shift;
	my $input_file_path = shift;
	my $write_dir = shift;
	my $new_name = shift;
	
	unless ($new_name) {
		$new_name = get_name_from_path($input_file_path);
		$new_name = normalize_filename($new_name);
	}
	
	my $write_file_path = $this->_add_root_path($write_dir . '/' . $new_name);	
	
	if (-e $write_file_path) {
		
		#	$f = "C:/www/ollesummer_intranet/calendar.pl";
		#	$f2 = "C:/www/ollesummer_intranet/calendar[1].pl";
		$write_file_path =~ s/(.*)(\..*$)/$1\[1\]$2/;
		
		my $c = 2;
		my $prev = 1;
		
		while (-e $write_file_path) {
			$write_file_path =~ s/(.*\[)$prev(\]\..*)/$1$c$2/;
			$c++;
			$prev++;
		}
	}
	
	return $write_file_path;
}

sub upload {
	my $this = shift;
	my $request_field_name = shift;
	my $write_dir = shift;
	my $new_name = shift; # optional
	my $input_file_path = $this->{g}->param($request_field_name); # ie gives path ff just a name
	
	trace("upload file is missing") unless ($input_file_path);
	
	my $write_file_path = $this->_get_write_path($input_file_path, $write_dir, $new_name);
	
	open my $fh, '>', $write_file_path or trace("can't write file: '$write_file_path', reason $!");
	
	binmode $fh;
	my ($bytes_read, $size, $buff);
	while ($bytes_read = read($input_file_path, $buff, 2096)) {
		$size += $bytes_read;
		if ($bytes_read > 5*2**20) {
			close($fh);
			unlink_file($write_file_path);
			last;
		}
		print $fh $buff;
	}
	
   close($fh);

   if ((stat $write_file_path)[7] <= 0) {
	   unlink_file($write_file_path);
		trace("Could not upload file: '$write_file_path'");
	}

	return get_name_from_path($write_file_path);
}

sub get_name_from_path {
	my @tokens = split /[\/\\]/, shift; 
	return pop @tokens;
}

sub unlink_file {
	my $path = shift;
	unlink($path) or trace("can't unlink file: $path, reason: '$!'");
}

sub rename_file_sub {
	my $old_path = shift;	
	my $new_path = shift;
	rename($old_path, $new_path) or trace("can't rename file: $old_path, reason: '$!'");
}

sub make_dir {
	my $this = shift;
	my $write_dir = shift;
	my $path = $this->_add_root_path($write_dir);
	mkdir $path or trace("can't create dir: $!");
	chmod 0777, $path or trace("can't change mode: $!");
}

1;