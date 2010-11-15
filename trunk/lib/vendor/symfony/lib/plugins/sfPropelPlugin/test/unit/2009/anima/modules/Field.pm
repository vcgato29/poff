#####################################################################################
package Field;
use Tmpl;

my %fields = (
   title => undef,
   prefix => undef,
   db_fname => undef,
   value => undef,
	read_only => undef, # not editable in update form
	tmpl =>undef, # Tmpl.pm 
	set_value_trigger =>undef, # function to call on set_value
	file => undef, # 1 when file field
	pass => undef # 1 when pass field
)
;

sub new{
   my $classname = shift;
	my $this  = {%fields};
   bless($this, $classname);
	$this->{title} = shift;
   $this->{db_fname} = shift;
   $this->{tmpl} = new Tmpl(); # contains template object
   return $this;
}

sub get_db_fname{	my $this = shift; 	return $this->{db_fname};}
sub get_fname{	my $this = shift; 	return $this->{prefix}."_".$this->{db_fname};}
sub get_value{ my $this = shift; 	return $this->{value}; }
sub is_read_only{ my $this = shift; 	return $this->{read_only}; }
sub is_file{ my $this = shift; 	return $this->{file}; }
sub is_html{ return 0; }
sub is_pass{ return 0; }

sub set_set_value_trigger{ my $this = shift; $this->{set_value_trigger} = shift;}
sub set_prefix{ 	my $this = shift; $this->{prefix} = shift;}
sub set_value{ 	my $this = shift; $this->{value} = shift;}
sub set_read_only{ 	my $this = shift; $this->{read_only} = shift;}

sub set_value{
	my $this = shift;
	my $value = shift;
	my $from_form = shift; # is it form form or db
	$this->{set_value_trigger}->(\$value , $from_form) if (defined $this->{set_value_trigger});
	$this->{value} = $value;
}

sub as_html_row {
	my $this = shift;
	return $this->{tmpl}->get_tmpl('field_row',$this->{title}, $this->{value});
}

sub get_control_template{
	return "text_box";	
}

sub as_edit_html_row {
	my $this = shift;
	my $tmpl = $this->get_control_template();
	my $text_box = $this->{tmpl}->get_tmpl($tmpl,
						$this->{prefix}."_".$this->{db_fname},
						$this->{value}	);
	return $this->{tmpl}->get_tmpl('edit_field_row', $this->{title},	$text_box	);
}

#####################################################################################
package DateTimeSelectField;
@ISA = qw( Field );

# added fields:
# list, hour_list, min_list

sub as_edit_html_row{
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
	
	my $select_box = $this->{tmpl}->get_tmpl('day_select_box',
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
	
	$select_box .= "-".$this->{tmpl}->get_tmpl('time_select_box',
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
	
	$select_box .= ":".$this->{tmpl}->get_tmpl('time_select_box',
						$this->{prefix}."_".$this->{db_fname},
						$opts);
	
	return $this->{tmpl}->get_tmpl('edit_field_row', $this->{title},	$select_box	);
}

sub set_value{
	my $this = shift;
	my $value = shift;
	my $from_form = shift;
	
	if ($value !~ /\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}/){	
		my ($epoch,$hour,$min) = split /\\0/, $value;
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
}

sub set_list{ my $this = shift; $this->{list} = shift; }

#####################################################################################
package SelectField;
@ISA = qw( Field );

# added fields:
# list, onChange

sub as_edit_html_row{
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
	
	my $select_box = $this->{tmpl}->get_tmpl('select_box',
						$this->{prefix}."_".$this->{db_fname},
						$opts);

	return $this->{tmpl}->get_tmpl('edit_field_row', $this->{title},	$select_box	);
}

sub as_control{
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
	
	my $select_box = $this->{tmpl}->get_tmpl('select_box', $this->{db_fname}, $opts, $this->{onChange});
}

sub set_list{ my $this = shift; $this->{list} = shift; }
sub set_onChange{ my $this = shift; $this->{onChange} = shift; }

#####################################################################################
package CheckField;
@ISA = qw( Field );

sub as_edit_html_row {
	my $this = shift;
	my $opts;
	
	my $checked = 'checked' if ($this->{value} eq '1');
	
	my $check_box = $this->{tmpl}->get_tmpl('check_box',
						$this->{prefix}."_".$this->{db_fname},
						$checked	);

	return $this->{tmpl}->get_tmpl('edit_field_row', $this->{title},	$check_box	);
}

#####################################################################################
package HiddenField;
@ISA = qw( Field );

sub as_edit_html_row {
	my $this = shift;
	my $retval;
	my $value = $this->{value};
	my $name = $this->{prefix}."_".$this->{db_fname};
	return qq~<input type=hidden name=$name value="$value">~;
};

#####################################################################################
package AdditionField;
@ISA = qw( Field );

sub as_edit_html_row {
	my $this = shift;
	my $retval;
	my $name = $this->{prefix}."_".$this->{db_fname};
	my $boxes = $this->{tmpl}->get_tmpl('num_add_boxes',$name,$this->{value});
	return $this->{tmpl}->get_tmpl('edit_field_row', $this->{title},	$boxes	);
};

#####################################################################################
package AreaField;
@ISA = qw( Field );

sub get_control_template{
	return "text_area";	
}

sub as_edit_html_row {
	my $this = shift;
	my $tmpl = $this->get_control_template();
	my $text_box = $this->{tmpl}->get_tmpl($tmpl,
						$this->{prefix}."_".$this->{db_fname},
						$this->{value}	);
	return $this->{tmpl}->get_tmpl('edit_field_row', $this->{title},	$text_box	);
}

#####################################################################################
package WysiwygField;
@ISA = qw( Field );

sub is_html{ return 1; }

sub as_edit_html_row {
	my $this = shift;
	my $text_box = $this->{tmpl}->get_tmpl('wysiwyg_box',
						$this->{prefix}."_".$this->{db_fname},
						$this->{value},'news');
	return $this->{tmpl}->get_tmpl('edit_field_row', $this->{title},	$text_box);
}

#####################################################################################
package NewsAreaField;
@ISA = qw( AreaField );

sub get_control_template{
	return "news_text_area";	
}

#####################################################################################
package PassField;
@ISA = qw( Field );

sub is_pass{ return 1; }

sub get_control_template{
	return "pass_box";
}

#####################################################################################
package FileField;
@ISA = qw( Field );

# added fields:
# pic, catalog_id

sub set_pic{ my $this = shift; $this->{pic} = shift;}
sub set_file{ my $this = shift; $this->{file} = shift;}
sub set_catalog_id{ 	my $this = shift; $this->{catalog_id} = shift;}
sub is_pic{	my $this = shift; return $this->{pic};}
sub is_file{ return 1;}

sub as_edit_html_row{
	my $this = shift;
	my $file_box = $this->{tmpl}->get_tmpl('file_box',
						$this->{prefix}."_".$this->{db_fname});
	
	if ($this->is_pic){
		my $value = $this->{value};
		$file_box	.= qq~<img src="upload/$value">~ if ($value);
	}
	
	return $this->{tmpl}->get_tmpl('edit_field_row', $this->{title}, $file_box );
	
}

1;