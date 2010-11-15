package QueryAddresses;
use strict;
use warnings;
use Query;
use Data::Dumper;
use Mrt::Util('trace');

@QueryAddresses::ISA = qw(Query);

sub fetch_query {
	my $this = shift;
	my $start = shift || 0;
	my $limit = shift || die "no limit provided";	
	
	# my $table = $this->{table};
	# my $restrictions = $this->{restriction_form} ? $this->{restriction_form}->get_sql()
	#															: '';
	
	my $iter = new Mrt::Iterator(_get_data($start, $limit));
	return $iter;
}

sub count_query {
	return scalar @{_get_rawdata()};
}


sub _get_rawdata {
	my @data = ();
	for (my $i = 0; $i < 40; $i++) {
		my $nr = sprintf("%.2d", $i + 1);
		my $h_ref = {};
		$h_ref->{id} = $nr;
		$h_ref->{name} = "name_$nr";
		$h_ref->{mail} = "$nr\@hot.ee";
		push @data, $h_ref;
	}	
	return \@data;
}

sub _get_data {
	my $start_pos = shift;
	my $limit = shift;
	
	my @data = @{_get_rawdata()};
	
	my $end_pos = $start_pos + $limit - 1;
	
	my @retval = @data[$start_pos..$end_pos];
	
	return \@retval;
}

1;