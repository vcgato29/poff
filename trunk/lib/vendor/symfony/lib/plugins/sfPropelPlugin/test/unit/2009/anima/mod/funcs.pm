our $G;

*funcs::G = *G;

package funcs;
use strict;
use warnings;
require Exporter;
@funcs::ISA = qw(Exporter);
@funcs::EXPORT = qw(wprint pref add_state lang st i);
# @funcs::EXPORT_OK = qw(wprint pref);  # symbols to export on request
use Data::Dumper;

our $G;

sub i($);
sub wprint($);
sub pref($);
sub add_state($);

sub pref($) {
	my $t = shift;
	$t =~ s/%p/$funcs::G->conf('db_pref')/ge;
	return $t;
}

sub wprint($) {
	unless ($global::headers_sent) {
		print("Content-type: text/html; charset=utf-8\n\n");
		$global::headers_sent = 1;
	}
	print @_;
}

sub lang {
	return $funcs::G->param('lang') || 1;
}

sub st {
	return $G->get_state('st') || $G->param('st') || ''; 
}

sub i($) {
	return sprintf('front_utf8_%s.%s', lang_string(), shift);
}

sub lang_string {
	return 'est' if (lang() eq '1');
	return 'eng' if (lang() eq '2');
}

1;