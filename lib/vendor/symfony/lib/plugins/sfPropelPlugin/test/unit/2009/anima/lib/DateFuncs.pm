package DateFuncs;
use Date::EzDate;
use strict;

# static functions for Date::EzDate

# yyyy, yy, mm, dd, hour, min, sec
sub format_datetime {
	my $format = shift;
	my $date = shift;
	my $month_array_ref = shift;
	
	$date = to_date_obj($date);
	
	$format =~ s/yyyy/$date->{year}/g;
	$format =~ s/yy/sprintf("%.2d",$date->{year}-2000)/eg;
	$format =~ s/mm/sprintf("%.2d",$date->{'month number'} + 1)/eg;
	$format =~ s/M/$$month_array_ref[$date->{'month number'}]/g;
	$format =~ s/dd/$date->{'day of month'}/g;
	$format =~ s/hour/$date->{hour}/g;
	$format =~ s/min/$date->{min}/g;
	$format =~ s/sec/$date->{sec}/g;
	
	return $format;
}

sub get_day_name {
	my $date = shift;
	my $names = shift;
	my @names = split / /, $names;
	my $num = $date->{'weekday number'}-1;
	$num = 6 if ($num == -1);
	return $names[ $num ];
}

# in: Date::EzDate object
# out: -
# make it the very beginning of the day
# modifies object passed in
sub floor_day{
	my $date = shift;
	$date->{'min'} = 0;
	$date->{'sec'} = 0;
	$date->{'hour'} = 0;
}

sub ceil_day{
	my $date = shift;
	$date->{'sec'} = 59;
	$date->{'min'} = 59;
	$date->{'hour'} = 23;
}

# in: Date::EzDate object
# out: -
# make it the very beginning of the current month
# modifies object passed in
sub floor_month{
	my $date = shift;
 	$date->{'day of month'} = 1;
	$date = floor_day($date);
}

sub ceil_month{
	my $date = shift;
 	$date->{'day of month'} = 1;
 	$date->{'month number'}++;
	$date->{'day of month'}--;
	$date = ceil_day($date);
}

# in: Date::EzDate object
# out: -
# make it the very beginning of the current week
# modifies object passed in
sub floor_week{
	my $date = shift;
	
 	if ($date->{'weekday number'} == 0){	# sunday is 0
 		$date->{epochday}--; 					# otherwise instead of backing some days we forward one
 	}
 	
 	$date->{'weekday number'} = 1;
	$date = floor_day($date);
}

sub ceil_week{
	my $date = shift;

	if ($date->{'weekday number'} != 0){
		while ( $date->{'weekday number'} != 0 ){
			$date->{'weekday number'}++;
		}
	}
	
	$date = ceil_day($date);
}


# in: Date::EzDate object
# out: -
# to the very beginning of the next month
# modifies object passed in
sub next_month{ # ->next_month(1); has bug
	my $date = shift;
	my $prev_month = $date->{'month number'};
	while ($date->{'month number'} eq $prev_month){
		$date->{'epochday'}++;
	}
	floor_month($date);
}

sub prev_month{ # ->next_month(-1); has bug
	my $date = shift;
	my $prev_month = $date->{'month number'};

	while ($date->{'month number'} eq $prev_month){
		$date->{'epochday'}--;
	}
	
	floor_month($date);
}


# in: string of epoch || string of mysql date (2004-10-30 09:00:00)
# output:	Date::EzDate
sub to_date_obj {
	my $date = shift;
	# its not object
	if (!ref($date)){ # its not an object
		if ( ! $date ){
			$date = Date::EzDate->new();
		}
		elsif ( length($date) == 19){ # its mysql date/time string
			$date =~ /(.{4})-(.{2})-(.{2}) (.{2}):(.{2}):(.{2})/;
			
			$date = Date::EzDate->new();
			
			$date->{'year'} = $1;
			$date->{'month number'} = $2 - 1;
			$date->{'day of month'} = $3;
			$date->{'hour'} = $4;
			$date->{'min'} = $5;
			$date->{'sec'} = $6;

			
		}elsif (length($date) == 10){ # its epoch string
			$date = Date::EzDate->new($date);
		}
	}
	return $date;
}

sub to_mysql_date{
	my $date = shift;
	my $retval;
	
	$retval .= $date->{'year'}."-";
	$retval .=  sprintf ("%.2d",$date->{'month number'}+1)."-";
	$retval .=  sprintf ("%.2d",$date->{'day of month'})." ";
	$retval .=  sprintf ("%.2d",$date->{'hour'}).":";
	$retval .=  sprintf ("%.2d",$date->{'min'}).":";
	$retval .=  sprintf ("%.2d",$date->{'sec'});
	
	return $retval;
}


# in obj || epoch sting
# out: eg. "0000-00-00 00:00:00" || "00:00:00"
sub timestring{ # object passed in stays unmodified
	my $date = shift;	
	my $time_only = shift;
	$date = to_date_obj($date);
	my $mn = sprintf("%.2d",$date->{'month number'} + 1);
	my $time = $date->{hour}.":".$date->{min}.":".$date->{sec};
	return $time if ($time_only);
	return $date->{year}."-".$mn."-".$date->{'day of month'}." ".$time;
}

# is_ahead("6:00") - whether 6:00 today is allready been or not
sub is_ahead{
	my $time = shift;
	my $curdate = to_date_obj(time());
	my $date = date_today_at($time);
	return ($curdate->{epochsec} < $date->{epochsec}); 
}

# date_today_at('06:00') gives date object today at '06:00'
sub date_today_at{
	my $time = shift;
	my $date = to_date_obj(time());
	$date = floor_date($date);
	$date->{'epoch second'}+=get_sec($time);
	return $date;
}

# next_date_at("06:00") gives date object of next time it is 06:00
sub next_date_at{
	my $time = shift;
	my $date = to_date_obj(time());
	floor_date($date);
	$date++ unless ( is_ahead($time));
	$date->{'epoch second'}+=get_sec($time);
	return $date;
}

sub get_sec{
	my $time = shift;
	my ($h,$m,$s) = split /:/, $time;
	return (60*$m + 3600*$h +$s);	
}

1;
