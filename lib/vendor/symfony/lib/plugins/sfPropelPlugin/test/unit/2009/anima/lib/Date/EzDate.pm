package Date::EzDate;
use strict;
use Carp;
# use Debug::ShowStuff ':all';
use vars qw($VERSION @ltimefields $overload $default_warning);

# documentation at end of file

# object overloading
use overload
	'""'     => sub{$_[0]->{'default'}},  # stringification
	'<=>'    => \&compare,               # comparison
	'+'      => \&addition,              # addition
	'-'      => \&subtraction,           # subtraction
	fallback => 1;                    # operations not defined here


# version
$VERSION = '1.08';

# constants and globals
use constant WARN_NONE   => 0;
use constant WARN_STDERR => 1;
use constant WARN_CROAK  => 2;
$default_warning = WARN_STDERR;
$overload = 'epochday';

# psuedo-constants
@ltimefields = 	qw[sec min hour dayofmonth monthnum year weekdaynum yearday dst];


#========================================================================================
# new
#
sub new {
	my ($class, $init, %opts) = @_;
	my ($rv, %tiehash);
	
	tie(%tiehash, $class . '::Tie', $init, %opts) or return undef;
	$rv = bless(\%tiehash, $class);
	$rv->after_create();
	
	return $rv;
}


# Called after object is created. By default, does nothing
sub after_create{}

#
# new
#========================================================================================


#========================================================================================
# clone
#
sub clone {
	my ($self) = @_;
	my $ob = $self->tie_ob;
	my ($rv);
	
	$rv = ref($self)->new([
		$ob->{'sec'},
		$ob->{'min'},
		$ob->{'hour'},
		$ob->{'dayofmonth'},
		$ob->{'monthnum'},
		$ob->{'year'},
		$ob->{'weekdaynum'},
		$ob->{'yearday'},
		$ob->{'dst'},
		$ob->{'epochsec'}
		]);
	
	%{$ob->{'formats'}} and 
		$rv->tie_ob->{'formats'} = {%{$ob->{'formats'}}};
	
	return $rv;
}
#
# clone
#========================================================================================


#========================================================================================
# format subs
# 
sub set_warnings {return $_[0]->tie_ob->{'warnings'} = $_[1]}
sub zero_hour_ampm {return $_[0]->tie_ob->{'zero_hour_ampm'} = $_[1]}

sub set_format {return $_[0]->tie_ob->set_format(@_[1..$#_])}

sub get_format {
	my ($self, $key) = @_;
	my $ob = $self->tie_ob;
	$key =~ s|\s||gs;
	$key = lc($key);
	return join('', @{$ob->{'formats'}->{$key}});
}

sub del_format {return delete $_[0]->{$_[1]}}
sub tie_ob{return tied(%{$_[0]})}
# 
# format subs
#========================================================================================


#========================================================================================
# next_month
# 
sub next_month {
	my ($self, $jumps) = @_;
	my ($target, $dom, $dim);
	my $month = $self->{'month num'};
	my $year = $self->{'year'};
	my $orgday = $self->{'dayofmonth'};
	
	# default $jumps
	defined($jumps) or $jumps = 1;
	$jumps or return;
	
	$target = $jumps;
	$target = abs($target);
	
	# jumping forward
	if ($jumps > 0) {
		foreach (1..$target) {
			# if end of year
			if ($month == 11) {
				$month = 0;
				$year++;
			}
			else
				{$month++}
		}
	}
	
	# jumping backward
	else {
		foreach (1..$target) {
			# if beginning of year
			if ($month == 0) {
				$month = 11;
				$year--;
			}
			else
				{$month--}
		}
	}
	
	$self->{'year'} = $year;
	$self->{'monthnum'} = $month;
	
	# adjust day back upward if necessary
	$dom = $self->{'dayofmonth'};
	$dim = $self->{'daysinmonth'};
	if ( ($orgday > $dom) && ($dom < $dim) )
		{$self->{'dayofmonth'} = ($dim < $orgday) ? $dim : $orgday}
}
# 
# next_month
#========================================================================================


#========================================================================================
# compare
# 
sub compare {
	my ($left, $right) = @_;
	ref($right) or $right = Date::EzDate->new($right);
	$left->{$overload} <=> $right->{$overload};
}
# 
# compare
#========================================================================================


#========================================================================================
# addition and subtraction
# 
sub addition {
	my ($self, $val) = @_;
	$self->{$overload} += $val;
	return $self;
}

sub subtraction {
	my ($self, $val) = @_;
	$self->{$overload} -= $val;
	return $self;
}
# 
# addition and subtraction
#========================================================================================



########################################################################################################
package Date::EzDate::Tie;
use strict;
use Carp 'croak', 'carp';
use Tie::Hash;
use Time::Local;
# use Debug::ShowStuff ':all';
use re 'taint';
use POSIX;

use vars qw(
	@ISA 
	%WeekDayNums 
	%MonthNums 
	@MonthDays 
	@MonthLong 
	@MonthShort 
	@WeekDayLong 
	@WeekDayLong 
	@WeekDayShort 
	@DayOfMonthRd
	%PCodes
	$pcode
	$epoch_offset
	@OrdWords $OrdWordsRx %OrdWordsNums
	@OrdNums $OrdNumsRx
	);

@ISA = 'Tie::StdHash';


# globals
@WeekDayShort = qw[Sun Mon Tue Wed Thu Fri Sat];
@WeekDayLong  = qw[Sunday Monday Tuesday Wednesday Thursday Friday Saturday];
@MonthShort   = qw[Jan Feb Mar Apr May Jun Jul Aug Sep Oct Nov Dec];
@MonthLong    = qw[January February March April May June July August September October November December];
@MonthDays    = qw[31 x 31 30 31 30 31 31 30 31 30 31];
@WeekDayNums{qw[sun mon tue wed thu fri sat]}=(0..6);
@MonthNums{qw[jan feb mar apr may jun jul aug sep oct nov dec]}=(0..11);


# ordinals
@OrdWords = qw[Zeroth First Second Third Fourth Fifth Sixth Seventh Eighth Ninth
	Tenth Eleventh Twelfth Thirteenth Fourteenth Fifteenth Sixteenth Seventeenth Eighteenth Ninteenth
	Twentieth Twentyfirst Twentysecond Twentythird Twentyfourth Twentyfifth Twentysixth Twentyseventh
	Twentyeighth Twentyninth Thirtieth Thirtyfirst];
$OrdWordsRx = '\b(' . join('|', @OrdWords[1..$#OrdWords]) . ')\b';
foreach my $i (1..$#OrdWords)
	{$OrdWordsNums{lc($OrdWords[$i])} = $i}
@OrdNums = qw[0th 1st 2nd 3rd 4th 5th 6th 7th 8th 9th
	10th 11th 12th 13th 14th 15th 16th 17th 18th 19th
	20th 21st 22nd 23rd 24th 25th 26th 27th
	28th 29th 30th 31st];

# percent code regex
$pcode = '^\%[\w\%]$';

%PCodes = qw[
	yearlong         year
	yearshort        yeartwodigits
	month            monthlong
	weekday          weekdayshort
	dayofyear        yearday
	dayofyearbase1   yeardaybase1
	%Y               year
	%y               yeartwodigits
	%a               weekdayshort
	%A               weekdaylong
	%d               dayofmonth
	%D               %m/%d/%y
	%H               hour
	%h               monthshort
	%b               ampmhournozero
	%B               hournozero
	%e               monthnumbase1nozero
	%f               dayofmonthnozero
	%j               yeardaybase1
	%k               ampmhour
	%m               monthnumbase1
	%M               min
	%P               ampmuc
	%p               ampmlc
	%s               epochsec
	%S               sec
	%w               weekdaynum
	%y               yeartwodigits
	%T               %H:%M:%S
	%n               newline
	%t               tab
	%%               percent
	];
$PCodes{'%c'} = '{weekdayshort} %h %d %H:%M:%S %Y';
$PCodes{'%r'} = '%k:%M:%S %P';


# constants
use constant t_60        => 60;
use constant t_60_60     => 3600;
use constant t_60_60_24  =>  86400;
use constant WARN_NONE   => Date::EzDate::WARN_NONE;
use constant WARN_STDERR => Date::EzDate::WARN_STDERR;
use constant WARN_CROAK  => Date::EzDate::WARN_CROAK;


#========================================================================================
# TIEHASH
# 
sub TIEHASH {
	my ($class, $time, %opts)=@_;
	my $self = bless ({}, $class);
	
	# set some non-date properties
	$self->{'zero_hour_ampm'} = defined($opts{'zero_hour_ampm'}) ? $opts{'zero_hour_ampm'} : 1;
	$self->{'formats'} = {};
	$self->{'settings'} = {'dst_kludge' => 1};
	
	# if clone
	if (ref($time))
		{@{$self}{@Date::EzDate::ltimefields, 'epochsec'}=@{$time}}
	
	else {
		# calculate and set properties of current time
		# set time from timefromfull
		$self->setfromtime(time());
		
		if (defined $time) {
			$time = $self->timefromfull($time);
			defined($time) or return undef;
			$self->setfromtime($time);
		}
	}
	
	return  $self;
}
# 
# TIEHASH
#========================================================================================



#========================================================================================
# setfromtime
# 
sub setfromtime {
	my ($self, $time) = @_;
	$self->{'epochsec'} = $time;
	
	@{$self}{@Date::EzDate::ltimefields}=localtime($time);
	$self->{'year'} += 1900;
}
# 
# setfromtime
#========================================================================================


#========================================================================================
# set_format
# 
sub set_format {
	my ($self, $name, $format) = @_;
	
	# normalize name
	$name =~ s|\s||g;
	$name =~ tr/A-Z/a-z/;
	
	$self->{'formats'}->{$name} = format_split($format);
}

sub format_split {
	my @rv = split(m/(\{[^\{\}]*\}|\%.)/, $_[0]);
	
	foreach my $el (@rv) {
		if ($el =~ m|^\{.*\}$|s)
			{normalize_key($el)}
	}
	
	return \@rv;
}
# 
# set_format
#========================================================================================


#========================================================================================
# warn
# 
sub warn {
	my $self = shift;
	my $level = defined($self->{'warnings'}) ? $self->{'warnings'} : $Date::EzDate::default_warning;
	
	$level or return undef;
	
	if ($level == WARN_STDERR) {
		carp 'WARNING: ', @_;
		return undef;
	}
	
	croak @_;
}
# 
# warn
#========================================================================================


#========================================================================================
# normalize_key
# 
sub normalize_key {
	$_[0] =~ s|\s||gs;
	$_[0] =~ tr/A-Z/a-z/ unless $_[0] =~ m|^\%\w$|;
	$_[0] =~ s|ordinal|ord|sg;
	
	$_[0] =~ s|hours|hour|sg;
	# $_[0] =~ s|days\b|day|sg;

	$_[0] =~ s|minute|min|sg;
	$_[0] =~ s|mins|min|sg;
	
	$_[0] =~ s|second|sec|sg;
	$_[0] =~ s|secs|sec|sg;
	
	$_[0] =~ s|number|num|sg;
}
# 
# normalize_key
#========================================================================================


#========================================================================================
# STORE
# 
sub STORE {
	my ($self, $key, $val) = @_;
	my $orgkey = $key;
	my $orgval = $val;
	
	# error checking
	if (! defined $val)
		{return $self->warn('Must send a defined value when setting a property of an EzDate object')}
	
	# if value contains {, assume they're assigning a format
	$val =~ m|[\{\%]| and return $self->set_format($key, $val);
	
	# clean a little
	normalize_key($key);
	
	# get key from aliases if necessary
	$key = $self->get_alias($key, 'strip_no_zero'=>1);

	
	# dayofmonth, weekdaynum, yearday
	if ($key =~ m/^(dayofmonth|weekdaynum|yearday)$/s) {
		# warn if setting day of month greater than month has days
		if ( 
			($key eq 'dayofmonth') && 
			($val > daysinmonth($self->{'monthnum'}, $self->{'year'}))
			) {
			$self->warn("setting day of month ($val) to higher than days in month (", daysinmonth($self->{'monthnum'}, $self->{'year'}), ')');
		}
		
		$self->setfromtime($self->{'epochsec'} - ($self->{$key} *  t_60_60_24) + ($val * t_60_60_24) );
	}
	
	elsif ($key eq 'sec')
		{$self->setfromtime($self->{'epochsec'} - $self->{'sec'} + $val)}
	
	elsif ($key eq 'min')
		{$self->setfromtime($self->{'epochsec'} - ($self->{'min'} * 60) + ($val * 60) )}
	
	elsif ($key eq 'minofday')
		{$self->setfromtime($self->{'epochsec'} - ($self->{'hour'} * t_60_60)  - ($self->{'min'} * 60) + ($val * 60) )}
	
	elsif ($key eq 'hour'){
		$val = timelocal($self->{'sec'}, $self->{'min'}, $val, $self->{'dayofmonth'}, $self->{'monthnum'}, $self->{'year'});
		$self->setfromtime($val);
	}
	
	# hour and minute
	elsif ( ($key eq 'clocktime') || ($key =~ m|^mil(itary)?time$|) ) {	
		my ($changed, $hour, $min, $sec) = $self->gettime($val);
		
		unless (defined $hour)
			{$hour = $self->{'hour'}}
		unless (defined $min)
			{$min = $self->{'min'}}
		unless (defined $sec)
			{$sec = $self->{'sec'}}
		
		$self->setfromtime
			(
			$self->{'epochsec'}
			
			- ($self->{'sec'})
			- ($self->{'min'} * 60)
			- ($self->{'hour'} * t_60_60)
			
			+ ($sec)
			+ ($min * 60)
			+ ($hour * t_60_60)
			);
	}
	
	elsif ($key eq 'ampmhour') {
		if ($self->{'hour'} >= 12)
				{$val += 12}
		$self->STORE('hour', $val);
	}
	
	elsif (
		($key eq 'ampm') || 
		($key eq 'ampmlc') || 
		($key eq 'ampmuc')
		) {
		my ($multiplier);
		
		if (length($val) == 1)
			{$val .= 'm'}
		$val = lc($val);
		
		# error checking
		unless ( ($val eq 'am') || ($val eq 'pm') )
			{return $self->warn('ampm may only be set to am or pm')}
		
		# if no change, we're done
		if ($self->{'hour'} < 12) {
			if ($val eq 'am') {return}
		}
		else {
			if ($val eq 'pm') {return}
		}
		
		if ($val eq 'am')
			{$multiplier = -1}
		else
			{$multiplier = 1}
		
		$self->setfromtime($self->{'epochsec'} + (12 * t_60_60 * $multiplier) );
	}
	
	elsif ($key eq 'dst')
		{return $self->warn('dst property is read-only')}
	
	elsif ($key eq 'epochsec')
		{$self->setfromtime($val)}
	
	elsif ($key eq 'epochmin')
		{$self->setfromtime($self->{'epochsec'} - ($self->getepochmin * 60) + ($val * 60) )}
	
	elsif ($key eq 'epochhour')
		{$self->setfromtime($self->{'epochsec'} - ($self->getepochhour * t_60_60) + ($val * t_60_60) )}
	
	elsif ($key eq 'epochday') {
		my ($oldhour, $oldepochsec, $oldmin);
		
		# kludge issues with DST
		if ($self->{'settings'}->{'dst_kludge'}) {
			$oldhour = $self->{'hour'};
			$oldmin = $self->{'min'};
			$oldepochsec = $self->{'epochsec'};
		}
		
		$self->setfromtime($self->{'epochsec'} - ($self->getepochday * t_60_60_24) + (int($val) * t_60_60_24) );
		
		# kludge issues with DST
		if (
			$self->{'settings'}->{'dst_kludge'} && 
			($oldhour != $self->{'hour'})
			) {
			
			# spring forward
			if (
				(($oldhour == 23) && ($self->{'hour'} == 0)) ||
				($oldhour == ($self->{'hour'} - 1) )
				)
				{$self->setfromtime($self->{'epochsec'} - t_60_60)}
				
			# fall back
			elsif (
				(($oldhour == 0) && ($self->{'hour'} == 23)) ||
				($oldhour == ($self->{'hour'} + 1) )
				)
				{$self->setfromtime($self->{'epochsec'} + t_60_60)}
			
			# else die
			else {
				die
					"Cannot implement epochday++.  Usually this is because\n",
					"you have exceeded the bounds that your installation of\n",
					"localtime can handle.";
			}
		}
	}
	
	# ordinals
	elsif ($key =~ m/dayofmonthord(word|num)?/) {
		# if numeric
		if ($val =~ s|^(\d+)\s*\w*$|$1|s)
			{$self->STORE('dayofmonth', $val)}
		
		# else word
		else {
			my $nval = $val;
			$nval =~ tr/A-Z/a-z/;
			$nval =~ s|\W||gs;
		
			# if no such ordinal exists
			unless ($nval = $OrdWordsNums{$nval})
				{return $self->warn("Invalid ordinal: $val")}
			
			$self->STORE('dayofmonth', $nval);
		}
	}
	
	elsif ($key eq 'year') {
		my ($maxday, $targetday);
		
		# if same year, nothing to do
		if ($self->{'year'} == $val)
			{return}
		
		# make sure day of month isn't greater than maximum day of target month
		$maxday = daysinmonth($self->{'monthnum'}, $val);
		
		if ($self->{'dayofmonth'} > $maxday) {
			$self->warn(
				"Changing the year sets day of month ($self->{'dayofmonth'}) to higher than days in month ($maxday); ", 
				"setting the day down to $maxday"
				);
			$targetday = $maxday;
		}
		else
			{$targetday = $self->{'dayofmonth'}}
		
		$val = timelocal($self->{'sec'}, $self->{'min'}, $self->{'hour'}, $targetday, $self->{'monthnum'}, $val);
		$self->setfromtime($val);
	}
	
	elsif ($key =~ m/^year(two|2)digit/) {
		$val =~ s|^.*(..)$|$1|;
		$self->STORE('year', substr($self->{'year'}, 0, 2) . zeropad($val));
	}
	
	elsif ($key =~ m/^monthnumbase(one|1)/)
		{$self->STORE('monthnum', $val - 1)}
	
	elsif ($key eq 'monthnum') {
		my ($i, $maxday, $targetday, $cepoch);
		
		# if same month, we're done
		if ($val == $self->{'monthnum'})
			{return}
		
		# make sure day of month isn't greater than maximum day of target month
		$maxday= daysinmonth($val, $self->{'year'});
		if ($self->{'dayofmonth'} > $maxday) {
			$self->warn(
				"Changing the month sets day of month ($self->{'dayofmonth'}) to higher than days in month ($maxday); ", 
				"setting the day down to $maxday"
				);
			$targetday = $maxday;
		}
		else
			{$targetday = $self->{'dayofmonth'}}
		
		# if we should increment or decrement
		$i = ($val > $self->{'monthnum'}) ? 1 : -1;
		
		$cepoch = $self->{'epochsec'};
		
		my $sanity = 1000;
		
		# loop until we get to this day in next or previous month
		while (1) {
			my ($newdaynum, $newmonthnum);
			$cepoch = $cepoch + (t_60_60_24 * $i);
			
			if ($sanity-- <= 0)
				{die 'INSANE'}
			
			($newdaynum, $newmonthnum) = (localtime($cepoch))[3,4];
			
			# if we have a match, set to new month
			if ( ($newdaynum == $targetday) && ($newmonthnum == $val) ) {
				$self->STORE('epochday', $self->getepochday($cepoch));
				return;
			}
		}
	}
	
	elsif ( ($key eq 'monthshort') || ($key eq 'monthlong') )
		{$self->STORE('monthnum', $MonthNums{lc(substr($val, 0, 3))})}
	
	elsif ( ($key eq 'weekdayshort') || ($key eq 'weekdaylong') )
		{$self->STORE('weekdaynum', $WeekDayNums{lc(substr($val, 0, 3))})}
	
	# year day
	elsif ($key =~ m/^yeardaybase(one|1)$/)
		{$self->STORE('yearday', $val - 1)}
	
	# default, full, dmy
	elsif ( ($key eq 'default') || ($key eq 'full') || ($key eq 'dmy') ){
			my (%opts);
			
			if ( $key eq 'dmy')
				{$opts{'dateonly'} = 1}
			
			$self->setfromtime($self->timefromfull($val, %opts));
		}
	
	else
		{return $self->warn("Do not understand key: $orgkey")}
}
# 
# STORE
#========================================================================================


#========================================================================================
# FETCH
# 
sub FETCH {
	my ($self, $key, %opts) = @_;
	my ($ampm, $ampmhour);
	my $orgkey = $key;
	
	
	# get key from aliases if necessary
	$key = $self->get_alias($key);
	
	
	#---------------------------------------------------------------------------------------------------
	# nested properties
	# 
	if ( (! ref $key) && ($key =~ m|[\{\%]|) && ($key !~ m|$pcode|o) )
		{$key = format_split($key)}
	
	if (ref $key) {
		my @rv = @$key;
		
		foreach my $el (@rv) {
			# if this is one of the format elements
			# then fetch the value of the given key
			if (
				($el =~ s|\{([^\}]+)\}|$1|) ||  # if it is enclosed in {}
				($el =~ m|$pcode|o)             # if it is a %x code
				) {
				$el =~ s|['"\s]||g;
				$el = $self->FETCH($el, normalized=>1);
			}
		}
		
		return join('', @rv);
	}
	#
	# nested properties
	#---------------------------------------------------------------------------------------------------
	
	
	# clean up key
	$opts{'normalized'} or normalize_key($key);
	
	
	# already or mostly calculated
	if (exists $self->{$key}) {
		if ($key =~ m/^(dayofmonth|monthnum|hour|min|sec)$/)
			{return zeropad($self->{$key})}
		
		return $self->{$key};
	}
	
	# nozero's
	if ($key =~ s/no(zero|0)//)
		{return $self->FETCH($key) + 0}
	
	# day of month ord
	if ($key =~ m|^dayofmonthord(word)?$|)
		{return $OrdWords[$self->{'dayofmonth'}]}
	if ($key eq 'dayofmonthordnum')
		{return $OrdNums[$self->{'dayofmonth'}]}
	
	# weekday
	if ($key =~ m/^(weekdayshort|dayofweek)$/)
		{return $WeekDayShort[$self->{'weekdaynum'}]}
	if ($key =~ m/^(weekdaylong|dayofweeklong)$/)
		{return $WeekDayLong[$self->{'weekdaynum'}]}
	
	# month
	if ($key eq 'monthshort')
		{return $MonthShort[$self->{'monthnum'}]}
	if ($key eq 'monthlong')
		{return $MonthLong[$self->{'monthnum'}]}
	if ($key =~ m/^monthnumbase(one|1)/)
		{return zeropad($self->{'monthnum'} + 1, 2)}
	
	if ($key =~ m/^yeardaybase(one|1)/)
		{return zeropad($self->{'yearday'} + 1, 3)}

	# year
	if ($key =~ m/^yeartwodigit/)
		{return substr($self->{'year'}, 2)}
	
	# epochs
	if ($key eq 'epochmin')
		{return $self->getepochmin}
	if ($key eq 'epochhour')
		{return $self->getepochhour}
	if ($key eq 'epochday')
		{return $self->getepochday}
	
	# leapyear
	if ($key =~ m/^(is)?leapyear/)
		{return isleapyear($self->{'year'})}
	
	# days in month
	if ($key eq 'daysinmonth')
		{return daysinmonth($self->{'monthnum'}, $self->{'year'}) }
	
	# DMY: eg 15JAN2001
	if ($key eq 'dmy')
		{return zeropad($self->{'dayofmonth'}, 2) . uc($MonthShort[$self->{'monthnum'}]) . $self->{'year'} }
	
	# full
	if (
		($key eq 'full') || 
		($key eq 'default')
		) {
		return 
			$WeekDayShort[$self->{'weekdaynum'}]   .  ' ' . 
			$MonthShort[$self->{'monthnum'}]       .  ' ' . 
			$self->{'dayofmonth'}                  .  ', ' . 
			$self->{'year'}                        .  ' ' .
			zeropad($self->{'hour'})               .  ':' . 
			zeropad($self->{'min'})                .  ':' . 
			zeropad($self->{'sec'});
	}
	
	# military time, aka "miltime"
	if ($key =~ m|^mil(itary)?time$|)
		{return zeropad($self->{'hour'}) . zeropad($self->{'min'}) }
	
	# minuteofday, aka minofday
	if ($key eq 'minofday') 
		{return $self->{'min'} + ($self->{'hour'} * 60) }
	
	# calculate ampm, which is needed in most results from here down
	$ampm = ($self->{'hour'} >= 12) ? 'pm' : 'am';
	
	# am/pm	
	if ( ($key eq 'ampm') || ($key eq 'ampmlc') )
		{return $ampm}
	
	# AM/PM	uppercase
	if ($key eq 'ampmuc') 
		{return uc($ampm)}
	
	# calculate ampmhour, which is needed from here down
	if ( ($self->{'hour'} == 0) || ($self->{'hour'} == 12) )
		{$ampmhour = 12}
	elsif ($self->{'hour'} > 12)
		{$ampmhour = $self->{'hour'} - 12}
	else
		{$ampmhour = $self->{'hour'}}
	
	# am/pm hour
	if ($key eq 'ampmhour')
		{return zeropad($ampmhour)}
	
	# hour and minute with ampm
	if (
		($key eq 'clocktime') || 
		($key eq 'clocktimestrict')
		) {
		my $minofday = $self->FETCH('minofday');
		
		if ($key eq 'clocktime') {
			if ($minofday == 0)
				{return 'midnight'}
			if ($minofday == 12 * t_60)
				{return 'noon'}
		}

		return 
			$self->FETCH('ampmhournozero') . 
			':' . zeropad($self->{'min'}) . ' ' . 
			$ampm;
	}
	
	# character codes
	$key eq 'newline' && return "\n";
	$key eq 'tab' && return "\t";
	$key eq 'leftbrace' && return '{';
	$key eq 'rightbrace' && return '}';
	$key eq 'percent' && return '%';
	
	# else we don't know what property is needed
	return $self->warn("do not know this format: $orgkey");
}
# 
# FETCH
#========================================================================================


#========================================================================================
sub DELETE {
	my ($self, $key) = @_;
	
	$key =~ s|\s||gs;
	$key = lc($key);
	
	return delete $self->{'formats'}->{$key};
}


sub del_format {return delete $_[0]->tie_ob->{'formats'}->{$_[1]}}


#========================================================================================
# isleapyear
# 
sub isleapyear {
	my ($year) = @_;
	
	return 1 if ( ($year % 4 == 0) && ( ($year % 100) || ($year % 400 == 0) ) );
	return 0;
}
# 
# isleapyear
#========================================================================================


#========================================================================================
# get_alias
# 
sub get_alias {
	my ($self, $key, %opts) = @_;
	
	# normalize
	unless ($key =~ m|[\{\%]|) {
		$key =~ s|\s||g;
		$key = lc($key);
		
		# strip "nozero" if that option was sent
		$opts{'strip_no_zero'} and $key =~ s|nozero||g;
	}
	
	# if this has an alias
	if (exists $PCodes{$key})
		{return $self->get_alias($PCodes{$key}, %opts)}
	
	# if this is a named format
	if (exists $self->{'formats'}->{$key})
		{return $self->{'formats'}->{$key}}
	
	return $key;
}
# 
# get_alias
#========================================================================================



#========================================================================================
# getepochday
# 
sub getepochday {
	my ($self, $epochsec) = @_;
	
	# $epoch_offset represents the number of seconds
	# into the epoch day that the actual epoch moment occurs
	defined($epochsec) or $epochsec = $self->{'epochsec'};
	
	# calculate $epoch_offset
	unless (defined $epoch_offset) {
		my %date;
		@date{@Date::EzDate::ltimefields} = localtime(0);
		$epoch_offset = 
			( ($date{'hour'} * t_60_60) + ($date{'min'} * 60) + $date{'sec'});
	}
	
	return floor( ($epochsec + $epoch_offset) / t_60_60_24);
}
# 
# getepochday
#========================================================================================

sub getepochhour {
	my ($self) = @_;
	return int($self->{'epochsec'} / t_60_60);
}

sub getepochmin {
	my ($self) = @_;
	return int($self->{'epochsec'} / 60);
}

#========================================================================================
# daysinmonth
# 
sub daysinmonth {
	my ($monthnum, $year) = @_;

	if ($monthnum != 1)
		{return $MonthDays[$monthnum]}
	if (isleapyear($year))
		{return 29}
	return 28;
}
# 
# daysinmonth
#========================================================================================



#========================================================================================
# timefromfull
# 
sub timefromfull {
	my ($self, $val, %opts) = @_;
	my ($hour, $min, $sec, $day, $month, $year);
	my $orgval = $val;
	
	# error checking
	if (! defined $val)
		{return $self->warn("did not get a time string")}
	
	# quick return: if they just put in an integer
	if ($val =~ m/^\d+$/)
		{return $val}
	
	# alias hour am/pm to hour:00 am/pm
	# $self->{'zero_hour_ampm'} and $val =~ s/(^|[^:\d])(\d+)\s*([ap]m)/$1$2:00:00 $3/gis;
	$self->{'zero_hour_ampm'} and $val =~ s/(^|[^:\d])(\d+)\s*([ap]m?\b)/$1$2:00:00 $3/gis;
	
	#println "\$val: $val";

	# special case: ##:##.#####
	# In some time formats, the hour, min, second is
	# followed by fractional seconds.  We don't handle those
	# fractions, so we'll just remove them.
	$val =~ s/(\d+\:\d+)\.[\d\-]+/$1/g;
	

	# Another special case: A.M. to AM and P.M. to PM
	$val =~ s/a\.m\b/am/gis;
	$val =~ s/p\.m\b/pm/gis;
	
	# normalize
	$val =~ tr/A-Z/a-z/;
	$val =~ s/[^\w:]/ /g;
	$val =~ s/\s*:\s*/:/g;
	
	# change ordinals to numbers
	$val =~ s|$OrdWordsRx|$OrdWordsNums{$1}|gis;
	$val =~ s/(\d)(th|rd|st|nd)\b/$1/gis;
	

	# noon to 12:00:00
	# midnight to 00:00:00
	$val =~ s/\bnoon\b/ 12:00:00 /gis;
	$val =~ s/\bmidnight\b/ 00:00:00 /gis;
	
	# normalize some more
	$val =~ s/(\d)([a-z])/$1 $2/g;
	$val =~ s/([a-z])(\d)/$1 $2/g;
	$val =~ s/\s+/ /g;
	$val =~ s/^\s*//;
	$val =~ s/\s*$//;

	
	# today, tomorrow, and yesterday
	if ( ($val eq 'today') || ($val eq 'now') )
		{return time()}
	if ($val eq 'tomorrow')
		{return time() + t_60_60_24}
	if ($val eq 'yesterday')
		{return time() - t_60_60_24}
	
	# normalize further
	$val =~ s/([a-z]{3})[a-z]+/$1/gs;
	
	# remove weekday
	$val =~ s/((sun)|(mon)|(tue)|(wed)|(thu)|(fri)|(sat))\s*//;
	$val =~ s/\s*$//;
	
	
	# attempt to get time
	unless ($opts{'dateonly'}) {
		($val, $hour, $min, $sec) = $self->gettime($val, 'skipjustdigits'=>1);
	}
	
	# attempt to get date
	unless ($opts{'timeonly'}) {
		if (length $val)
			{($val, $day, $month, $year) = getdate($val)}
	}
	
	# trim
	$val =~ s/^\s*//;
	
	# attempt to get time again
	unless ($opts{'dateonly'}) {
		if (length($val) && (! defined($hour)) )
			{($val, $hour, $min, $sec) = $self->gettime($val, 'skipjustdigits'=>1, 'croakonfail'=>1)}
	}
	
	if (defined($val) && length($val))
		{return $self->warn("Did not recognize date/time pattern ($val): $orgval")}

	# if we didn't get a day, hour, year, or month we didn't recognize the pattern
	unless (
		defined($hour)   || 
		defined($day)    ||
		defined($month)  ||
		defined($year)
		)
		{return undef}
	
	# default everything that isn't defined
	unless (defined $hour)
		{$hour = $self->{'hour'}}
	unless (defined $min)
		{$min = $self->{'min'}}
	unless (defined $sec)
		{$sec = $self->{'sec'}}
	
	unless (defined $month)
		{$month = $self->{'monthnum'}}
	unless (defined $year)
		{$year = $self->{'year'}}
	unless (defined $day)
		{$day = maxday($self->{'dayofmonth'}, $month, $year)}

	# set year to four digits
	if (length($year) == 2)
		{$year = substr($self->{'year'}, 0, 2) . $year}
	
	return timelocal($sec, $min, $hour, $day, $month, $year);
	
	# get date sub
	# attempt to get date
	# supported date formats
	# 14 Jan 2001
	# 14 JAN 01
	# 14JAN2001
	# Jan 14, 2001
	# Jan 14, 01
	# 01-14-01
	# 1-14-01
	# 1-7-01
	# 01-14-2001
	sub getdate {
		my ($val, $day, $month, $year) = @_;

		# 14 Jan 2001
		# 14 JAN 01
		# 14JAN2001   # will be normalized to have spaces
		if ($val =~ s/^(\d+) ([a-z]+) (\d+)//) {
			$day = $1;
			$month = $MonthNums{$2};
			$year = $3;
		}
	
		# Jan 14, 2001
		# Jan 14, 01
		elsif ($val =~ s/^([a-z]+) (\d+) (\d+)//) {
			$month = $MonthNums{$1};
			$day = $2;
			$year = $3;
		}
		
		# Jan 2001
		# Jan 01
		elsif ($val =~ s/^([a-z]+) (\d+)//) {
			$month = $MonthNums{$1};
			$year = $2;
		}
		
		# 2001-01-14
		elsif ($val =~ s/^(\d{4}) (\d+) (\d+)//) {
			$year  = $1;
			$month = $2 - 1;
			$day   = $3;
		}
		
		# 01-14-01
		# 1-14-01
		# 1-7-01
		# 01-14-2001
		elsif ($val =~ s/^(\d+) (\d+) (\d+)//) {
			$month = $1 - 1;
			$day = $2;
			$year = $3;
		}

		return ($val, $day, $month, $year);
	}

	sub ampmhour {
		my ($hour, $ampm)=@_;
		
		# if 12
		if ($hour == 12) {
			# if am, set to 0
			if ($ampm =~ m/^a/)
				{$hour = 0}
		}
		
		# else if pm, add 12 
		elsif ($ampm =~ m/^p/)
			{$hour += 12}
		return $hour;
	}
}
# 
# timefromfull
#========================================================================================



#========================================================================================
# gettime
# 
# supported time formats:
#   5pm
#   5:34 pm
#   17:34
#   17:34:13
#   5:34:13
#   5:34:13 pm
#   2330 (military time)
# 
sub gettime {
	my ($self, $str, %opts)= @_;
	my ($hour, $min, $sec);
	
	# clean up a little
	$str =~ s/^://;
	$str =~ s/:$//;
	$str =~ s/(\d)(am|pm)/$1 $2/;
	
	
	# 5:34:13 pm
	# 5:34:13 p
	if ($str =~ s/^(\d+):(\d+):(\d+) (a|p)(m|\b)\s*//) {

		$hour = ampmhour($1, $4);
		$min = $2;
		$sec = $3;
	}
	
	# 17:34:13
	elsif ($str =~ s/^(\d+):(\d+):(\d+)\s*//) {
		$hour = $1;
		$min = $2;
		$sec = $3;
	}
	
	# 5:34 pm
	elsif ($str =~ s/^(\d+):(\d+) (a|p)m?\s*//) {
		$hour = ampmhour($1, $3);
		$min = $2;
	}
	
	# 17:34
	elsif ($str =~ s/^(\d+):(\d+)\s*//) {
		$hour = $1;
		$min = $2;
	}
	
	# 5 pm
	elsif ($str =~ s/^(\d+) (a|p)m?\b\s*//)
		{$hour = ampmhour($1, $2)}
	
	# elsif just digits
	elsif ( (! $opts{'skipjustdigits'}) && ($str =~ m/^\d+$/) ) {
		$str = zeropad($str, 4);
		$hour = substr($str, 0, 2);
		$min = substr($str, 2, 2);
	}
	
	# else don't recognize format
	elsif ($opts{'croakonfail'})
		{return $self->warn("don't recognize time format: $str")}

	return ($str, $hour, $min, $sec);
}
# 
# gettime
#========================================================================================



#========================================================================================
# maxday
# 
# if the input day is too high for given months, 
# returns the highest possible day for that month,
# otherwise returns the input day
# 
sub maxday {
	my ($day, $month, $year) = @_;
	my $maxday = daysinmonth($month, $year);
	
	$day > $maxday and return $maxday;
	return $day;
}
# 
# maxday
#========================================================================================



#========================================================================================
# zeropad
# 
sub zeropad {
	my ($rv, $length) = @_;
	$length ||= 2;
	return ('0' x ($length - length($rv))) . $rv;
}
# 
# zeropad
#========================================================================================


#========================================================================================
# clone
# 
sub clone {
	my ($ob) = @_;
	
	return ref($ob)->TIEHASH([
		$ob->{'sec'},
		$ob->{'min'},
		$ob->{'hour'},
		$ob->{'dayofmonth'},
		$ob->{'monthnum'},
		$ob->{'year'},
		$ob->{'weekdaynum'},
		$ob->{'yearday'},
		$ob->{'dst'},
		$ob->{'epochsec'}
		]);
}
# 
# clone
#========================================================================================



# return true
1;
__END__

=head1 NAME

Date::EzDate - Date and time manipulation made easy


=head1 SYNOPSIS

An EzDate object represents a single point in time and exposes all properties of that 
point. EzDate has many features, here are a few:

 use Date::EzDate;
 my $mydate = Date::EzDate->new();

 # output some date information
 print $mydate, "\n";  # e.g. output:  Wed Apr 11, 2001 09:06:26 

 # go to next day
 $mydate->{'epochday'}++;

 # determine if the date is before some other date
 if ($mydate < 'June 21, 2003')
     {...}

 # output some other date and time information
 # e.g. output:  Thursday April 12, 2001 09:06 am
 print
	$mydate->{'weekday long'},        ' ',
	$mydate->{'month long'},          ' ',
	$mydate->{'day of month'},        ', ',
	$mydate->{'year'},                ' ',
	$mydate->{'ampm hour no zero'},   ':',
	$mydate->{'min'},                 ' ',
	$mydate->{'am pm'},               "\n";

 # go to Monday of same week, but be lazy and don't spell out 
 # the whole day or case it correctly
 $mydate->{'weekday long'} = 'MON';

 print $mydate, "\n";  # e.g. output:  Mon Apr 09, 2001 09:06:26

 # go to previous year
 $mydate->{'year'}--;

 print $mydate, "\n";  # e.g. output:  Sun Apr 09, 2000 09:06:26 

=head1 INSTALLATION

Date::EzDate can be installed with the usual routine:

	perl Makefile.PL
	make
	make test
	make install

You can also just copy EzDate.pm into the Date/ directory of one of your library trees.


=head1 DESCRIPTION

Date::EzDate was motivated by the simple fact that I hate dealing with date and time calculations,
so I put all of them into a single easy-to-use object. The main idea of EzDate is that the object 
represents a specific date and time.  A variety of properties tell you information about that date 
and time such as hour, minute, day of month, weekday, etc.  

The B<real> power of EzDate is that you can assign to (almost) any of those 
properties and EzDate will automatically rework the other properties to produce a new valid 
date with the property you just assigned.  Properties that can be kept the same with the 
new value aren't changed, while those that logically must change to accomodate the new 
value are recalculated.  For example, incrementing I<epochday> by one (i.e. moving the date forward 
one day) does not change the hour or minute but does change the day of week.

So, for example, suppose you want to get information about today, then get 
information about tomorrow.  That can be done using the I<epochday> property
which is used for day-granularity calculations.  Let's walk through the steps:

=over

=item Load the module and instantiate the object

 use Date::EzDate;
 my $mydate = Date::EzDate->new();  # the object defaults to the current date and time

=item output all the basic information

 # e.g. outputs:  11:11:40 Wed Apr 11, 2001
 print $mydate->{'full'}, "\n";

=item set to tomorrow

To move the date forward one day we simply increment the I<epochday> property (number of days 
since the epoch).   The time (i.e. hour:min:sec) of the object does not change.

 $mydate->{'epochday'}++;
 
 # outputs:  11:11:40 Thu Apr 12, 2001
 print $mydate->{'full'}, "\n";

=back

This demonstrates the basic concept: almost any of the properties can be set as well as read and EzDate will take care
of resetting all other properties as needed.

=head1 YESTERDAY and TOMORROW

In addition to initializing the EzDate object with either nothing (i.e. the current day)
or with a string representing a date/time, you can initialize the object with the strings
C<YESTERDAY> or C<TOMORROW>.  For example, the following code creates an EzDate object
with tomorrow's date:

  $date = Date::EzDate->new('tomorrow');

=head1 STRINGIFICATION

EzDate objects stringify to a full representation of the date.  So, for example, the following
code outputs a string like C<Tue Sep 3, 2002 14:01:02>:

	$date = Date::EzDate->new();
	print $date, "\n";

The object stringifies to its C<default> format, so if you want to change how it
stringifies simply change the C<default> format.  For example, the following 
code outputs a string like C<September 3, 2002>:

	$date->{'default'} = '{month long} {day of month no zero} {year}';
	print $date, "\n";

=head1 COMPARISON

There are two main ways to compare EzDate objects: by comparing the object directly using the numeric comparison operators,
or by comparing their properties.

=head2 Overloaded Numeric Comparison Operators

EzDate overloads the numeric comparison operators.  The C<epochday> properties of two EzDate objects can be compared 
using the C<==>, 
C<E<gt>>, 
C<E<gt>=>, 
C<E<lt>>, 
C<E<lt>=> , and
C<E<lt>=E<gt>>, 
operators.  For example, the following code creates
two EzDate objects, then determines if the first object is less than the second:

	$mybday = Date::EzDate->new();
	$yourbday = Date::EzDate->new('tomorrow');

	if ($mybday < $yourbday) {
		....
	}

Only one of the two items being compared needs be an EzDate object.  The other can be a string representation
of a date.  For example, the following code correctly determines if the given EzDate object is before
June 25, 2003:

	if ($date < 'June 25, 2003') {
		...
	}

By default, the comparison is done on the C<epochday> property, so two EzDate objects that have the same date
but different times will be considered the same.  If you want to compare based on some other property, set
$Date::EzDate::overload to the name of the property to compare.  For example, the following code sets 
the comparison property to C<epoch second>, meaning that two date/times are considered the same only if
they are identical down to the second:

	$date = Date::EzDate->new('January 3, 2001');

I<PLEASE NOTE>: $Date::EzDate::overload used to be named $Date::EzDate::compare.  I made a non-backwards
compatible change to "overload" because the same variable is now being used for non-comparison overloads
like addition and subtraction.


=head2 Comparing Properties

The other way to compare dates is to compare their properties.  For example, you can simple determine if two
dates are on the same day of week by using their C<day of week> properties:

	$date = Date::EzDate->new('January 3, 2001');
	$otherdate = Date::EzDate->new('January 10, 2001');
	
	if ($date->{'day of week'} eq $otherdate->{'day of week'}) {
		...
	}

=head1 OVERLOADED ADDITION AND SUBTRACTION

You can do basic addition and subtraction on EzDate objects to adjust the C<epoch day> property (or whatever property is
indicated by the C<$Date::EzDate::overload> variable). For example, to increment the day of the object, simply increment it
with C<++> like a number.  For example, the following code moves the day from Jan 31, 2003 to Feb 1, 2003:

  my $date = Date::EzDate->new('Jan 31, 2003');
  print $date, "\n";  # outputs Fri Jan 31, 2003 16:05:27
  $date++;
  println $date;      # outputs Sat Feb 1, 2003 16:05:27

You can also move by more than one day with + or +=.  These two commands do the same thing:

  $date = $date + 3;
  $date += 3;    

Subtraction works the same way.  All of these commands move the object one day backwards:

  $date = $date - 1;
  $date -= 1;
  $date--;


=head1 METHODS

=head2 new([I<date string>])

Currently, EzDate only accepts a single optional argument when instantiated.  You may pass in either 
a Perl time integer or a string formatted as DDMMMYYYY.  If you don't pass in any argument 
then the returned object represents the time and day at the moment it was created.

The following are valid ways to instantiate an EzDate object:

 # current date and time
 my $date = Date::EzDate->new();
 
 # a specific date and time
 my $date = Date::EzDate->new('Jan 31, 2001');
 
 # a date in DDMMMYYYY format
 my $date = Date::EzDate->new('14JAN2003');
 
 # a little forgiveness is built in (notice oddly place comma)
 my $date = Date::EzDate->new('14 January, 2003');
 
 # epoch second (23:27:39, Tue Apr 10, 2001 if you're curious) 
 my $date = Date::EzDate->new(986959659);
 
 # yesterday
 my $date = Date::EzDate->new('yesterday');
 
 # tomorrow
 my $date = Date::EzDate->new('tomorrow');

=head2 $mydate->set_format($name, $format)

C<set_format> allows you to specify a custom format for use later on.  
For example, suppose you want a format of the form I<Monday, June 10, 2002>.
You can specify that format using C<set_format> like this:

  $date->set_format('myformat', '{weekday long}, {month long} {day of month}, {year}');
  print $date->{'myformat'}, "\n";

You can also create a custom format by simply assigning the format to its name.  
If EzDate sees a C<{> in the value being assigned, it knows that you are
assigning a format, not a date. The set_format line above could be written like this:
  
  $date->{'myformat'} = '{weekday long}, {month long} {day of month}, {year}';

Note that it's not necessary to store a custom format if you're only going to use it
once.  If you wanted the format above, but just once, you could output it like this:

  print $date->{'{weekday long}, {month long} {day of month}, {year}'};

To delete a custom format, C<$mydate->del_format($name)>. To get the format string itself, 
use C<$mydate->get_format($name)>.  

If you use the same custom format in a lot of different places in your project, you might
find it easier to create your own customer super-class of Date::EzDate so that you can 
set the custom formats in one place.  See "Super-classing Date::EzDate" below.

=head2 $mydate->clone()

This method returns an EzDate object exactly like the object it was called from.  C<clone> is much 
cheaper than creating a new EzDate object and then setting the new object to have the same properties 
as another EzDate object.


=head2 $mydate->set_warnings($warning_level)

When EzDate receives invalid instructions, by default it outputs a warning and continues.  For
example, if you use a time/date format that EzDate doesn't recognize, it outputs a warning to 
STDERR and ens the attempt to set the date/time.  There are two other ways that EzDate could
handle the error: it could ignore the error completely, or it could end the entire program.

You can set which error handling you prefer with the C<set_warnings> method.  The first and only
argument indicates how to handle errors.  There are three possible values:

	0	Do not handle error in any way
	1	Output error to STDERR (default)
	2	Output to STDERR and exit program

So, for example, the following code sets the warnings to level 2:

  $date->set_warnings(0);

You can set the global default warning level by setting $Date::EzDate::default_warning.  For 
example, the following code sets the global default level to 2:

  $Date::EzDate::Tie::default_warning = 2;

=head2 $mydate->next_month([integer])

EzDate lacks an C<epochmonth> month property (because months aren't all the same length) 
so it needed a way to say "same day, next month".  Calling C<next_month> w/o any argument 
moves the object to the same day in the next month. If the day doesn't exist in the next 
month, such as if you move from Jan 31 to Feb, then the date is moved back to the last 
day of the next month.

The only argument, which defaults to 1, allows you to move backward or forward any number 
of months. For example, the following command moves the date forward two months:

  $mydate->next_month(2);

This command moves the date backward three months:

  $mydate->next_month(-3);

C<next_month()> handles year boundaries without problem.  Calling C<next_month()> for a date in 
December moves the date to January of the next year.

=head2 $mydate->zero_hour_ampm(1|0)

In general, EzDate operates on the principal that only date/time properties that are explicitly
changed are changed.  However, this rule was confusing people in one manner,
so I changed the default behavior.  If you set the hour using the format C<hour am|pm> (e.g.
C<4 am> without specifying the minute or second, then EzDate assumes you meant to 
set the minute and second to 0.  So, the following string sets the object to exactly
4:00:00 pm:

  $date = Date::EzDate->new('4 pm');

If you would prefer the old behavior where the time would be set to whatever the current minute and second are, then
call C<zero_hour_ampm> with an argument of zero:

  $date->zero_hour_ampm(0);

You can also pass C<zero_hour_ampm> as an initial argument for C<new>:

  $date = Date::EzDate->new('January 31, 2002 1 am', zero_hour_ampm=>0);

=head2 after_create

C<after_create> is intended for use when you are super-classing EzDate.  By default,
C<after_create> does nothing.  See "Super-classing Date::EzDate" below for more details.

=head1 PROPERTIES

This section lists the properties of an EzDate object.

I<Properties are case and space insensitive>.  Properties can be in upper or lower case, and you
can put spaces anywhere to make them more readable.  For example, the following properties are 
all the same:

	weekdaylong
	WEEKDAYLONG
	WeekDay Long
	Wee Kdaylong  # makes no sense, but hey, it's your code

Also, certain words can always be abbreviated.  

	minute  ==  min
	second  ==  sec
	number  ==  num
	ordinal ==  num

So, for example, the following two properties are the same:

	$mydate->{'minute of day'};
	$mydate->{'min of day'};


=head2 Basic properties

All of these properties are both readable and writable.  Where there might be some confusion 
about what happens if you assign to the property more detail is given.

=over

=item hour

Hour in 24 hour clock, 00 to 23.  Two digits, with a leading zero where necessary.

=item ampm hour

Hour in twelve hour clock, 0 to 12.  Two digits, with a leading zero where necessary.

=item ampm

I<am> or I<pm> as appropriate.  Returns lowercase.  If you set this property the object will adjust to the
same day and same hour but in I<am> or I<pm> as you set.

=item ampm uc, ampm lc

C<ampm uc> returns I<AM> or I<PM> uppercased.  C<ampm lc> returns I<am> or I<pm> lowercased.  


=item min, minute

Minute, 00 to 59.  Two digits, with a leading zero where necessary.

=item sec, second

Second, 00 to 59.  Two digits, with a leading zero where necessary.

=item weekday number

Number of the weekday.  This number is zero-based, so Sunday is 0, Monday is 1, etc. 
If you assign to this property the object will reset the date to the assigned
weekday of the same week.  So, for example, if the object represents 
Saturday Apr 14, 2001, and you assign 1 (Monday) to I<weekdaynum>:

 $mydate->{'weekday number'} = 1;

Then the object will adjust to Monday Apr 9, 2001.

=item weekday short

First three letters of the weekday.  I<Sun>, I<Mon>, I<Tue>, etc.  If you assign 
to this property the object will adjust to that day in the same week.  When you assign 
to this property EzDate actually only pays attention to the first three letters and 
ignores case, so I<SUNDAY> would a valid assignment.

=item weekday long

Full name of the weekday.  If you assign to this property the object will adjust to the 
day in the same week.  When you assign to this property EzDate actually only pays attention 
to the first three letters and ignores case, so I<SUN> would a valid assignment.

=item day of month

The day of the month.  If you assign to this property the object adjusts to the day in the 
same month.

=item day of month ordinal word, day of month ordinal number

The day of month expressed as either an ordinal word (e.g. "Third") or as an ordinal number
(e.g. "3rd").

=item month number

Zero-based number of the month.  January is 0, February is 1, etc. If you assign to this 
property the object will adjust to the same month-day in the assigned month.  If the 
current day is greater than allowed in the assigned month then the day will adjust to 
the maximum day of the assigned month.  So, for example, if the object is set to 
31 Dec 2001 and you assign the month to February (1):

  $mydate->{'month number'} = 1;

Then I<day of month> will be set to 28.

=item month number base 1

1 based number of the month for those of us who are used to thinking of January as 1, 
February as 2, etc.  Can be assigned to.

=item month short

First three letters of the month.  Can be assigned to.  Case insensitive in the assignment, 
so "JANUARY" would be a valid assignment.

=item month long

Full name of the month.  Can be assigned to.  In the assignment, EzDate only 
pays attention to the first three letters and ignores case.

=item year

Year of the date the object represents.

=item year two digits

The last two digits of the year.  If you assign to this property, EzDate assumes you mean to 
use the same first two digits.  Therefore, if the current date of the object is 1994 and you assign 
'12' then the year will be 1912... quite possibly not what you intended.  

=item day of year

Zero-based Number of days into the year of the date.  C<yearday> does the same thing.

=item day of year base1

One-based number of days into the year of the date.  C<yeardaybase1> does the same thing.

=item full

A full string representation of the date, e.g. C<04:48:01 pm, Tue Apr 10, 2001>.  
You can assign just about any common date and/or time format to this property.

I<Please take the previous statement as a challenge.>  I've aggressively tried to find
formats that EzDate can't understand.  When I've found one, I've modified the code to 
accomodate it.  If you have some reasonably unambiguous date format that EzDate is unable 
to parse correctly, please send it to me.  I<-Miko>

When assigning a full date/time string, you can use 'noon' and 'midnight' to indicate
specific times.  So, for example, this string indicates July 25, 2003 and noon:

	$mydate = Date::EzDate->new('July 23 2003 noon');
	print $mydate->{'full'}; # outputs Wed Jul 23, 2003 12:00:00


=item dmy

The day, month and year representation of the date, e.g. C<03JUN2004>.

=item military time, miltime

The time formatted as HHMM on a 24 hour clock.  For example, 2:20 PM is 1420.

=item clocktime

The time formatted as HH::MM AM/PM.

=item minute of day

How many minutes since midnight.  Useful for doing math with times in a day.

=back


=head2 Epoch properties

The following properties allow you to do date calculations at different granularities. All of these properties are 
both readable and writable.

=over

=item epoch second

The basic Perl epoch integer.

=item epoch hour

How many hours since the epoch.  

=item epoch minute

How many minutes since the epoch.  

=item epoch day

How many days since the epoch.

=back


=head2 Read-only properties

The following properties are read-only and will crash if you try to assign to them.


=over

=item is leap year

True if the year is a leap year. The "is" part is optional.

=item days in month

How many days in the month.

=back

=head1 CUSTOM FORMATS

You'll probably often want to retrieve more than one piece of information about a date/time at once.  You could,
of course, do this by getting each property individually and concatenating them together.  For example, you might 
want to get the date in the format I<Monday, June 10, 2002>.  You could build that string like this:
    
  $str = 
    $date->{'weekday long'} . ', ' . 
    $date->{'month long'} . ' ' . 
    $date->{'day of month'} . ', ' . 
    $date->{'year'};

That's a lot of typing, however, and it's difficult to tell from the code what the final string will
look like.  To make life EZ, EzDate allows you embed several date properties in a single call.  Just surround
each property with braces:

  $str = $date->{'{weekday long}, {month long} {day of month}, {year}'};

=head2 Storing custom formats

EzDate allows you to store your custom date formats for repeated calls.  This comes in handy for 
formats that are needed in several places throughout a project.  For example, suppose you want all 
your dates in the format I<Monday, June 10, 2002>. Of course, you could output them using a 
format string like in the example above, but even that will get tiring if you need to output the 
same format in several places.  Much easier would be to set the format once.  To do so, just call the 
C<set_format> method with the name of the format and the format itself:

  $date->set_format('myformat', '{weekday long}, {month long} {day of month}, {year}');
  print $date->{'myformat'}, "\n";

You can also create a custom format by simply assigning the format to its name.  
If EzDate sees a C<{> in the value being assigned, it knows that you are
assigning a format, not a date. The set_format line above could be written like this:

  $date->{'myformat'} = '{weekday long}, {month long} {day of month}, {year}';

=head2 Un*x-style date formatting

To make the Unix types happy you can format your dates using standard Un*x date codes.  The format string 
must contain at least one % or EzDate won't know it's a format string. For example, you could output a
date like this:

  print $mydate->{'%h %d, %Y %k:%M %p'}, "\n";

which would give you something like this:

  Oct 31, 2001 02:43 pm

Following is a list of codes.  C<*> indicates that the code acts differently than 
standard Unix codes.  C<x> indicates that the code does not exists in standard Unix 
codes.

  %a   weekday, short                               Mon
  %A   weekday, long                                Monday
  %b * hour, 12 hour format, no leading zero        2
  %B * hour, 24 hour format, no leading zero        2
  %c   full date                                    Mon Aug 10 14:40:38
  %d   numeric day of the month                     10
  %D   date as month/date/year                      08/10/98
  %e x numeric month, 1 to 12, no leading zero      8
  %f x numeric day of month, no leading zero        3
  %h   short month                                  Aug
  %H   hour 00 to 23                                14
  %j   day of the year, 001 to 366                  222
  %k   hour, 12 hour format                         14
  %m   numeric month, 01 to 12                      08
  %M   minutes                                      40
  %n   newline
  %P x AM/PM                                        PM
  %p * am/pm                                        pm
  %r   hour:minute:second AM/PM                     02:40:38 PM
  %s   number of seconds since start of 1970        902774438
  %S   seconds                                      38
  %t   tab
  %T   hour:minute:second (24 hour format)          14:40:38
  %w   numeric day of the week, 0 to 6, Sun is 0    1
  %y   last two digits of the year                  98
  %Y   four digit year                              1998
  %%   percent sign                                 %

=head1 EXTENDING

If you plan on using the same custom formats in several different places in your project, you
might find it easier to super-class EzDate so that your formats are loaded automatically
whenever an object is created.

To super-class EzDate, it is actually necessary to super-class I<two> classes:
Date::EzDate and Date::EzDate::Tie.  For example, suppose you want to create a class
called MyDateClass.  To do that, create a file called MyDateClass.pm, store it in the root
of one of the directories in your @INC path.  Then put both MyDateClass and 
MyDateClass::Tie packages in that file.  The following code can be used as a working 
template for super-classing EzDate.  Notice that we override the C<after_create()>
method in order to add a custom format.  C<after_create()> is called by the 
C<new> method after the new object has been created but before it is returned. 

  package MyDateClass;
  use strict;
  use Date::EzDate;
  use vars qw(@ISA);
  @ISA = ('Date::EzDate');
  
  # override after_create
  sub after_create {
    my ($self) = @_;
    $self->set_format('myformat', '{weekdaylong}, {monthlong} {dayofmonth}, {year}');
  }
  
  ##############################################################
  package MyDateClass::Tie;
  use strict;
  use vars qw(@ISA);
  @ISA = ('Date::EzDate::Tie');
  
  # return true
  1;

You can then load your class with code like this:

  use MyDateClass;
  my ($date, $str);
  
  $date = MyDateClass->new();
  print $date->{'myformat'}, "\n";

EzDate is really two packages in one: the public object, and the private tied hash (which
is where all the date info is stored).   If you want to add a public method, add it in the 
main class (e.g. MyDateClass, not MyDateClass::Tie).  Usually in those situations you'll 
need to use the private tied hash object (i.e. the object used internally by the tying 
mechanism).  To get to that tied object, used the tied method, like this:

  sub my_method {
	my ($self) = @_;
	my $ob = tied(%{$self});
    
    # do stuff with $self and $ob
  }

=head1 LIMITATIONS, KNOWN/SUSPECTED BUGS

The routine for setting the year has an off-by-one problem which is kludgly fixed but 
which I haven't been able to properly solve.

EzDate is entirely based on the C<localtime()> and C<timelocal()> functions, so it inherits their limitations.
On my computer that means it can't handle dates before Jan 1, 1902 or after Dec 31, 2037.  Your mileage may vary.

=head1 TO DO

The following list itemizes features I'd like to add to EzDate.  

=over 

=item Time zone properties

The current version does not address time zone issues.  Frankly, I haven't been able to 
figure out how best to deal with them. I'd like a system where the object knows what time 
zone it's in and if it's daylight savings time.  Changing to another time zone changes 
the other properties such that the object is in the same moment in time in the new time 
zone as it was in the old time zone.  For example, if the object represents 5pm in the 
Eastern Time Zone (e.g. where New York City is) and its time zone is changed to Pacific 
Time (e.g. where Los Angeles is) then the object would have a time of 2pm.

=item Assignment based on format

Right now the formatted string feature is read-only.  It might be useful if the date could be assigned 
based on a format.  So, for example, you could set the date as Nov 1, 2001 like this:

  $mydate->{'%h %d %Y'} = 'Nov 1 2001';

This would come in handy when dealing with weirdly formatted dates.  However, EzDate is already quite robust 
about handling weirdly formatted dates, so this feature is not as pressingly needed as it might seem.

=item Next weekday

I'd like a function for moving the date forward (or backward) to the next (previous) day of a week.  

=item Time interval object

An EzDate object represents a point in time.  I'd also like to have an object that represents
an interval of time.  For example, an interval object could represent "2 days, 3 hours, 18 seconds".
An object like that could then be used for calculating the difference between two dates.

I'm currently working on this feature.

=item Greater range of available dates

Currently EzDate inherits the limitations of localtime, which generally means it can't handle
dates before about 1902 or after about 2037.  I'd like to stretch EzDate so it can handle a greater
range of dates.  Ideally, it should handle dates from the Big Bang to the Big Crunch, but let's
start with recorded human history.

=back

=head1 TERMS AND CONDITIONS

Copyright (c) 2001-2003 by Miko O'Sullivan.  All rights reserved.  This program is 
free software; you can redistribute it and/or modify it under the same terms 
as Perl itself. This software comes with B<NO WARRANTY> of any kind.

=head1 AUTHORS

Miko O'Sullivan
F<miko@idocs.com>

DST patch submitted by Greg Estep.

=head1 VERSION

=over

=item Version 0.90    November 1, 2001

Initial release

=item Version 0.91    December 10, 2001

UI enhancements


=item Version 0.92    January  15, 2002

Fixed some bugs

=item Version 0.93    February 11, 2002

Fixed some more bugs

=item Version 1.00    July 5, 2002

Fixed a bug in next_month.

Added a lotta functionality:

- Space insensitive property names

- Custom formats using braced property names

- Stored custom formats

- More supportive of super-classing

- All that and yet actually decreased the volume of code

- Decided this sucker's ready for 1.00 release

Also made a few minor not-so-backward-compatible changes:

- Got rid of the C<printabledate> and C<printabletime> properties, which
  were just relics from an early project that used EzDate.

- Changed C<nextmonth> to C<next_month> to stay compatible with other 
  methods that were added and will be added.

=item Version 1.01    Aug 14, 2002

- Fixed bug that clones do not return formats

- Tightened up the code a little

=item Version 1.02    Sep 03, 2002

- Added ability to set a format by just assigning it to a key

- Added warnings to situations where the IM in DWIM isn't always clear.

- Added stringification of EzDate object

- Added overloaded comparison operators

- Made not-backward-compatible change to the C<full> format.

- Improved efficiency of custom formats

=item Version 1.04    Sep 03, 2002

- Added ordinals

- Added "noon" and "midnight" keywords.

=item Version 1.05    Dec 11, 2002

- Added format yyyy-mm-dd

- Added feature that if Date::EzDate->new() is called with an unrecognized format, then
	undef is returned.  This allows you to check formats for validity.

- Fixed off-by-one problem that occurred when, for example, moving Jan 1, 2003 back one year to 2002


=item Version 1.06    Mar 11, 2003

- Non-backwards compatible change: changed $compare global to $overload.

- Non-backwards compatible change: EzDate objects now stringify to the "default" format instead of the "full" format.

- Added overloading of addition and subtraction.

- Added recognition of the following time format, which is used by PostGreSql: 2003-02-13 12:35:49.480975-05

- Fixed bug in which days of DST changeover produced off-by-one problem when setting hours.

- Fixed bug in which the epochday value for dates before the epoch are off-by-one.


=item Version 1.07    May 21, 2003

- Implemented fix for DST problem.  Used patch submitted by Greg Estep.

=item Version 1.08    June 10, 2003

- Changed test.pl: removed test that incorrectly relied on the host
  having a specific epoch.  No change to the module itself.

=back



=cut
