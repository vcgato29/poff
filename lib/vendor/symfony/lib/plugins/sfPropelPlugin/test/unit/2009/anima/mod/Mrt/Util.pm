package Mrt::Util;
use strict;
use warnings;
use HTML::Entities();
use Data::Dumper;
# static functions
require Exporter;
@Mrt::Util::ISA = qw(Exporter);
@Mrt::Util::EXPORT_OK = qw(trace da join_hashes);  # symbols to export on request
use Unicode::String qw(utf8);

sub da(&$);

# da {print 8} 3;
# executes code after third
sub da(&$) {
   my $code = shift;
	my $cnt = shift;

	if (! defined $Mrt::Util::c) {
	   $Mrt::Util::c = $cnt;	
   } else {
   	$Mrt::Util::c--;
   }
	
   if ($Mrt::Util::c <=0) {
   	$code->();
      exit;
   }
}

sub trace {
	my $reason = shift || '';
	require 'Carp/Heavy.pm';
	print "<plaintext>\n";
	print Carp::longmess_heavy("error: " . $reason);
	exit;
}

sub join_hashes {
	my $href1 = shift;
	my $href2 = shift;
	my $href3 = {};
	
	for my $key (keys %{$href1}) {
   	$href3->{$key} = $href1->{$key}; 
   }
	for my $key (keys %{$href2}) {
   	$href3->{$key} = $href2->{$key}; 
   }
	return $href3;
}

sub read_file {
	my $path = shift;
	my $retval = '';
	my $op = $path =~ /utf8/ ? '<:utf8' : '<';
	open my $fh, $op, $path or trace("can\'t load from '$path'. reason: $!");
	do {local $/; $retval = <$fh>};
   close $fh;
   return \$retval;
}

sub write_file {
	my $path = shift;
	my $content_ref = shift;
	open my $fh, '>', $path or trace("can\'t write to '$path'. reason: $!");
	print $fh $$content_ref;
	close $fh;
}

# generates random string of length as param
# defalult length = 20
# print &rand_string(30);
sub rand_string {
	my $len = shift;
	$len = 20 unless $len; 
	my @abc;
	
	do {
		no strict;
		@abc = ('a'..'z','A'..'Z',0..9);	
	};
	
	my $retval;
	for (my $i = 0; $i<$len;$i++) {
		my $pos = rand() * scalar @abc;
		$retval .= $abc[$pos];
	}
	return $retval;
}

sub html_to_text {
	my $s_ref = shift;
	my $r = (ref $s_ref) ? 1 : 0;
	if (! $r) { my $a = $s_ref; $s_ref = \$a }
	$$s_ref =~ s/&lt;/</g;
	$$s_ref =~ s/&gt;/>/g;
	$$s_ref =~ s/<br>/\015\012/g;
	return $$s_ref if (! $r);
}

sub text_to_html {
	my $s_ref = shift;
	my $r = (ref $s_ref) ? 1 : 0;
	if (! $r) { my $a = $s_ref; $s_ref = \$a }
	$$s_ref =~ s/</&lt;/g;
	$$s_ref =~ s/>/&gt;/g;
	$$s_ref =~ s/\015?\012/<br>/g;
	return $$s_ref if (! $r);
}

#sub text_to_html {
#	my $s_ref = shift;
#	
#	if (! ref $s_ref) {
#		my $a = HTML::Entities::encode(utf8($s_ref));
#		$s_ref = \$a;
#	} else {
#		HTML::Entities::encode(utf8($$s_ref));
#	}
#	$$s_ref =~ s/\015?\012/<br>/g;
#	return $$s_ref; 
#}
#
#sub html_to_text {
#	my $s_ref = shift;
#	if (! ref $s_ref) {
#		my $a = HTML::Entities::encode($s_ref);
#		$s_ref = \$a;
#	}
#	HTML::Entities::decode($$s_ref);
#	$$s_ref =~ s/<br>/\015\012/g;
#	return $$s_ref;
#}

sub abbriviate {
	my $text = shift;
	$text = html_to_text($text);
	my $remaining = shift;
	my $append = shift;
	$append = '..' unless ($append);
	$text =~ s/(^.{$remaining}).*/$1$append/;
	$text = text_to_html($text);
	return $text;
}

# TODO
sub do_crypt {
	my $cr = crypt shift(), 'salt';
	$cr = crypt $cr, substr($cr,5,2); # 2x des, widh salt from previous encryption
}

1;