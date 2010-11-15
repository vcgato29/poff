package Field;
#use strict;
use Mrt::Tmpl;

sub new {
	my $classname = shift;
	my $this  = {};
	bless($this, $classname);
	
	$this->{title} = shift;
   $this->{db_fname} = shift;
   
	$this->{prefix} = '';
	$this->{dont_save} = 0;
	$this->{dont_load} = 0;
   
   return $this;
}

sub get_db_fname {	my $this = shift; 	return $this->{db_fname};}
sub get_fname {	my $this = shift; 	return $this->{prefix}."_".$this->{db_fname};}
sub get_value { my $this = shift; 	return $this->{value}; }
sub is_read_only{ my $this = shift; 	return $this->{read_only}; }
sub is_file { my $this = shift; 	return $this->{file}; }
sub is_html { return 0; }
sub is_pass { return 0; }

sub is_dont_save { my $this = shift; return $this->{dont_save}; }
sub dont_save { my $this = shift; $this->{dont_save} = 1; }

sub is_dont_load { my $this = shift; return $this->{dont_load}; }
sub dont_load { my $this = shift; $this->{dont_load} = 1; }

#sub set_default_value{ 	my $this = shift; $this->{default_value} = shift; }
sub set_property{ 	my $this = shift; $this->{property} = shift;}
sub set_set_value_trigger{ my $this = shift; $this->{set_value_trigger} = shift;}
sub set_prefix { 	my $this = shift; $this->{prefix} = shift;}
sub set_read_only { 	my $this = shift; $this->{read_only} = shift;}
sub set_global { 	my $this = shift; $this->{g} = shift;}
sub set_form_name { 	my $this = shift; $this->{form_name} = shift;}

sub set_value {
	my $this = shift;
	my $value = shift;
	my $from_form = shift; # is it form form or db
	
	$this->{set_value_trigger}->(\$value , $from_form) if (defined $this->{set_value_trigger});
	$this->{value} = $value;
}

sub as_html_row {
	my $this = shift;
	return $this->{g}->tmpl('field_row',$this->{title}, $this->{value});
}

sub get_control_template {
	return "form.text_box";	
}

sub as_edit_html_row {
	my $this = shift;
	my $tmpl = $this->get_control_template();
	my $h_ref = {};
	$h_ref->{name} = $this->{prefix}."_".$this->{db_fname};
	$h_ref->{value} = $this->{value};
	$h_ref->{property} = $this->{property};
	
	
	my $text_box = $this->{g}->tmpl($tmpl, $h_ref);
	
	return $this->{g}->tmpl('form.edit_field_row', {label=>$this->{title}, control=>$text_box});
}

#####################################################################################
package DateTimeField;
@DateTimeField::ISA = qw( Field );

sub set_value {
	my $this = shift;
	my $value = shift;
	my $from_form = shift;

	if ($value !~ /\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}/){	
		$value = $this->_to_mysql_date($value);		
	}else{
		$value = $this->_to_showable_date($value);
	}
	$this->{value} = $value;
}

sub _to_showable_date {
	my $this = shift;
	my $date = shift;
	$date = DateFuncs::to_date_obj($date);
	return DateFuncs::format_datetime('dd.mm.yyyy hour:min', $date);
}

sub _to_mysql_date {
	my $this = shift;
	my $date = shift;
	$date =~ m/(\d{2})\.(\d{2})\.(\d{4}) (\d{2}):(\d{2})/;

	$date = Date::EzDate->new();
	eval {
		$date->{'year'} = $3;
		$date->{'month number'} = $2 - 1;
		$date->{'day of month'} = $1;
		
		$date->{'hour'} = $4;
		$date->{'min'} = $5;	
	};

	return "2006-01-01 00:00:00" if ($@);
	
	return DateFuncs::to_mysql_date($date);
}

#####################################################################################
package DateTimeSelectField;
@DateTimeSelectField::ISA = qw( Field );

# added fields:
# list, hour_list, min_list

sub as_edit_html_row {
	my $this = shift;
	my $opts;
	
	my ($epoch,$hour,$min) = main::get_epoch_hour_min($this->{value}) if ($this->{value});
	
	my $sel = '';
	for (my $i = 0;$i<scalar @{$this->{list}};$i++){
		my $val = @{$this->{list}}[$i]->[0];
		my $name = @{$this->{list}}[$i]->[1];
		$sel = 'selected' if (@{$this->{list}}[$i]->[0] eq $epoch);
		$opts .= qq~<option value="$val" $sel>$name</option>\n~;
		$sel = '';
	}
	
	my $select_box = $this->{g}->tmpl('form.day_select_box',
						$this->{prefix}."_".$this->{db_fname},
						$opts);

	$this->make_hour_list;
	$this->make_min_list;
	
	$sel = $opts = '';
	for (my $i = 0;$i<scalar @{$this->{hour_list}};$i++){
		my $val = @{$this->{hour_list}}[$i]->[0];
		my $name = @{$this->{hour_list}}[$i]->[1];
		$sel = 'selected' if (@{$this->{hour_list}}[$i]->[0] eq $hour);
		$opts .= qq~<option value="$val" $sel>$name</option>\n~;
		$sel = '';
	}
	
	$select_box .= "-".$this->{g}->tmpl('form.time_select_box',
						$this->{prefix}."_".$this->{db_fname},
						$opts);

	$sel = $opts = '';
	for (my $i = 0;$i<scalar @{$this->{min_list}};$i++){
		my $val = @{$this->{min_list}}[$i]->[0];
		my $name = @{$this->{min_list}}[$i]->[1];
		$sel = 'selected' if (@{$this->{min_list}}[$i]->[0] eq $min);
		$opts .= qq~<option value="$val" $sel>$name</option>\n~;
		$sel = '';
	}
	
	$select_box .= ":".$this->{g}->tmpl('form.time_select_box',
						$this->{prefix}."_".$this->{db_fname},
						$opts);
	
	my $h_ref = {label=>$this->{title},	control=>$select_box};
	return $this->{g}->tmpl('form.edit_field_row', $h_ref);
}

sub set_value {
	my $this = shift;
	my $value = shift;
	my $from_form = shift;

	if ($value !~ /\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}/){	
		
		die 'param returns array instead of \\0 sting';
		
		my ($epoch,$hour,$min) = split /\0/, $value;
		my $date = new Date::Handler({ date => $epoch });
		my $delta = new Date::Handler::Delta([0,0,0,$hour,$min,0]); # make delta from time	
		$date += $delta;
		$this->{value} = main::to_mysql_date($date);	
		return;
	}
	$this->{value} = $value;
}

sub make_hour_list{
	my $this = shift;
	for (my $a=0;$a<24;$a++){
		my $b = sprintf ("%.2d" ,$a);
		push @{$this->{hour_list}} , [$b,$b];
	}
}

sub make_min_list{
	my $this = shift;
	for (my $a=0;$a<60;$a+=15){
		my $b = sprintf ("%.2d" ,$a);
		push @{$this->{min_list}} , [$b,$b];	
	}
	push @{$this->{min_list}} , [59,59];
}

sub set_list{ my $this = shift; $this->{list} = shift; }

#####################################################################################
package SelectField;
@SelectField::ISA = qw( Field );

# added fields:
# list, onChange

sub as_edit_html_row {
	my $this = shift;
	my $opts;
	
	my $sel = '';
	for (my $i = 0;$i<scalar @{$this->{list}};$i++){
		my $val = @{$this->{list}}[$i]->[0];
		my $name = @{$this->{list}}[$i]->[1];
		$sel = 'selected' if (@{$this->{list}}[$i]->[0] eq $this->{value});
		$opts .= qq~<option value="$val" $sel>$name</option>\n~;
		$sel = '';
	}
	
	my $select_box = $this->{g}->tmpl('form.select_box',
						$this->{prefix}."_".$this->{db_fname},
						$opts);

	my $h_ref = {label=>$this->{title}, control=>$select_box};
	return $this->{g}->tmpl('form.edit_field_row', $h_ref);
}

sub as_control {
	my $this = shift;
	my $opts;
	
	my $sel = '';
	for (my $i = 0;$i<scalar @{$this->{list}};$i++){
		my $val = @{$this->{list}}[$i]->[0];
		my $name = @{$this->{list}}[$i]->[1];
		$sel = 'selected' if (@{$this->{list}}[$i]->[0] eq $this->{value});
		$opts .= qq~<option value="$val" $sel>$name</option>\n~;
		$sel = '';
	}

	my $select_box = $this->{g}->tmpl('form.select_box', $this->{db_fname}, $opts, $this->{onChange},$this->{rows});
}

sub set_size{ my $this = shift; $this->{rows} = shift; }
sub set_list{ my $this = shift; $this->{list} = shift; }
sub set_onChange{ my $this = shift; $this->{onChange} = shift; }

#####################################################################################
package CheckField;
@CheckField::ISA = qw( Field );

sub set_cheked_value {
	my $this = shift;
	$this->{cheked_value} = shift;
}

sub as_edit_html_row {
	my $this = shift;
	my $opts;
	
	my $checked = 'checked' if ($this->{value});
	
	my $checked_value = $this->{cheked_value} ? $this->{cheked_value} : 1;
	
	my $check_box = $this->{g}->tmpl('form.check_box',
						$this->{prefix}."_".$this->{db_fname},
						$checked, $checked_value);

	my $h_ref = {label=>$this->{title}, control=>$check_box};
	return $this->{g}->tmpl('form.edit_field_row', $h_ref	);
}

#####################################################################################
package HiddenField;
@HiddenField::ISA = qw( Field );

sub as_edit_html_row {
	my $this = shift;
	my $retval;
	my $value = $this->{value};
	my $name = $this->{prefix}."_".$this->{db_fname};
	return qq~<input type=hidden name=$name value="$value">~;
};

#####################################################################################
package AdditionField;
@AdditionField::ISA = qw( Field );

sub as_edit_html_row {
	my $this = shift;
	my $retval;
	my $name = $this->{prefix}."_".$this->{db_fname};
	my $boxes = $this->{g}->tmpl('num_add_boxes',$name,$this->{value});
	return $this->{g}->tmpl('edit_field_row', $this->{title},	$boxes	);
};

#####################################################################################
package AreaField;
@AreaField::ISA = qw( Field );

sub get_control_template{
	return "form.text_area";	
}

sub as_edit_html_row {
	my $this = shift;
	my $tmpl = $this->get_control_template();
	
	my $h_ref = {name=>$this->{prefix}."_".$this->{db_fname},	
					value => $this->{value}};
	
	my $text_box = $this->{g}->tmpl($tmpl, $h_ref);

	$h_ref = {label=>$this->{title},	control=>$text_box};
	return $this->{g}->tmpl('form.edit_field_row', $h_ref);
}

#####################################################################################
package WysiwygField;
use Data::Dumper;
@WysiwygField::ISA = qw( Field );

sub is_html{ return 1; }

sub as_edit_html_row {
	my $this = shift;
	my $tmpl = $this->get_control_template();
	my $h_ref = {};
	
	$h_ref->{name} = $this->{prefix}."_".$this->{db_fname};
	$h_ref->{value} = $this->{value};
	$h_ref->{property} = $this->{property};
	$h_ref->{form_name} = 'anima_news_2006';
	$h_ref->{base_url} = $this->{g}->conf('base_url');
	
	my $text_box = $this->{g}->tmpl('form.wysiwyg_box', $h_ref);
	return $this->{g}->tmpl('form.edit_field_row', {label=>$this->{title}, control=>$text_box});
}
#####################################################################################
package NewsAreaField;
@NewsAreaField::ISA = qw( AreaField );

sub get_control_template{
	return "news_text_area";	
}

#####################################################################################
package PassField;
@PassField::ISA = qw( Field );

sub is_pass{ return 1; }

sub get_control_template {
	return "form.pass_box";
}

#####################################################################################
package FileField;
@FileField::ISA = qw( Field );

# added fields:
# pic, catalog_id

sub set_pic { my $this = shift; $this->{pic} = shift;}
sub set_file { my $this = shift; $this->{file} = shift;}
sub set_catalog_id { 	my $this = shift; $this->{catalog_id} = shift;}
sub is_pic {	my $this = shift; return $this->{pic};}
sub is_file { return 1;}

sub as_edit_html_row{
	my $this = shift;
	my $file_box = $this->{g}->tmpl('form.file_box',
						$this->{prefix}."_".$this->{db_fname});
	
	
	if ($this->is_pic){
		my $value = $this->{value};
		my $url = $this->{g}->conf('upload_url') . "$value";
		$file_box	.= qq~<img src="$url">~ if ($value);
	}
	
	my $h_ref = {label=>$this->{title},	control=>$file_box};
	return $this->{g}->tmpl('form.edit_field_row', $h_ref);	
}

#####################################################################################

1;