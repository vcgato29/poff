package Form;
use Field;

my %fields = (
   table_name => undef,
   form_name => undef,
   fields => undef,     # contains field objects or its derivations
   record_id => undef,  # which record to show (form is for one db row)
	tmpl =>undef,
	rank => undef,
	hiddens => undef     # for forms hidden fields
);

sub new {
   my $classname = shift;
	my $this  = {%fields};
   bless($this, $classname);
   $this->{table_name} = shift;
   my $form_name = shift;
   $form_name = $form_name?$form_name:$this->{table_name};
   $this->{form_name} = $form_name;
   $this->{tmpl} = new Tmpl(); # contains template object
   return $this;
}

sub set_record_id{ 	my $this = shift; 	$this->{record_id} = shift; }
sub set_hiddens { 	my $this = shift;  push @{$this->{hiddens}}, @_; }

sub make_hiddens{
	my $this = shift;
	my @keys = @{$this->{hiddens}};
	my $retval;

	foreach $param_name (@keys){
		my $val = $main::Q->param($param_name);
		$retval .= qq~<input type=hidden name=$param_name value=$val>\n~;
	}
	return $retval;
}

sub make_cancel_url{
	my $this = shift;
	my @keys = @{$this->{hiddens}};
	my $retval = "?";
	my $c = 0;
	
	foreach $param_name (@keys){
		$retval .= "&" if ($c++);
		my $val = $main::Q->param($param_name);
		$retval .= qq~$param_name=$val~;
	}
	return $retval;
}

sub add_field{
	my $this = shift;
	my $f = shift;
	push @{$this->{fields}}, $f;
}

sub as_html{
	my $this = shift;
	my $fields_html;
	foreach $field (@{$this->{fields}}){
		$fields_html .= $this->_field_html_row($field);
	}
	$this->_get_form_template(\$fields_html);
}

sub _field_html_row{ # subclasses need to overide it
	my $this = shift;
	my $f = shift;		# to make editable fields
	return $f->as_html_row();
}

sub _get_form_template{
	my $this = shift;
	my $fields = shift;
	return $this->{tmpl}->get_tmpl('table',$$fields);
}

sub save_form(){
	my $this = shift;	
	
	my $p = $main::Q->Vars; # nii saab cgi-st parmeetrid modifitseerimata kätte ka zero delimined stringi

	foreach $field (@{$this->{fields}}){
		my $value = $p->{$field->get_fname};
		
		main::text_to_html(\$value) if (not $field->is_html());
		$value = $main::DBH->quote($value);

		$value =~ s/&lt;/</ig;
		$value =~ s/&gt;/>/ig;
		$value =~ s/&nbsp;/ /ig;
		$value =~ s/&quot;/"/ig;

		$value =~ s/(?<!\\)"/\\"/g; # escape quotes (server version don't escape them but local does for some reason)
											 #	\\" fools this
		$value =~ s/^'//; # DBH->quote($value); puts quotes around also
		$value =~ s/'$//;
		
		$field->set_value($value , 1); # ,1 means value comes from form
	}
	
	my $qs = $this->_make_qs();
	my $sth = $main::DBH->prepare($qs) || die $dbh->errstr;
	$sth->execute() || die $sth->errstr;	
	return $main::DBH->{'mysql_insertid'};
}


sub _make_qs{
	my $this = shift;	
	return $this->make_add_query();
}

sub load_form(){
	my $this = shift;
	
	my $qs = $this->make_get_query();
	my $sth = $main::DBH->prepare($qs) || die $dbh->errstr;
	$sth->execute() || die $sth->errstr;
	
	while (my @values = $sth->fetchrow_array()){
		@values = map { s/\\%/%/g; main::html_to_text($_); } @values;
		foreach $field (@{$this->{fields}}){
			$field->set_value(shift @values);
		}
	}
}

sub make_get_query{  # makes update query from array of field objects	
	my $this = shift;
	my $qs = "SELECT ";
	my $f = 0;
	my $fields;
	
	foreach $field (@{$this->{fields}}){
		if ($f++) { $fields .= ", "}; # no , for firstone
		$fields .= $field->get_db_fname();
	}
	$qs .= "$fields FROM ".$this->{table_name};
	$qs .= " WHERE ". $this->{table_name} . "_id='" . $this->{record_id}."'";
	return $qs;
}

sub make_add_query{  # makes update query from array of field objects
	my $this = shift;
	my $qs = "INSERT INTO ".$this->{table_name};
	my $f = 0;
	my ($fields,$values) = (' (',' VALUES (');
	
	foreach $field (@{$this->{fields}}){
		if ($f++) { $fields .= ", "; $values .= ", ";};
		$fields .= $field->get_db_fname();
		$values .= '"'.$field->get_value().'"';
	}
 	
 	$fields .= ')';$values .= ')';
	return $qs.$fields.$values;
}

sub make_update_query{  # makes update query from array of field objects	
	my $this = shift;
	my $qs = "UPDATE ".$this->{table_name}." SET ";
	my $f = 0;

	foreach $field (@{$this->{fields}}){
		next if ($field->is_file() and ($field->get_value() eq "/" or $field->get_value() eq "")); # we don't update file fields when they are empty
		next if ($field->is_pass() and $field->get_value() eq "");
		if ($f++) { $qs .= ", "};
		$qs .= $field->get_db_fname()."=";
		$qs .= '"'.$field->get_value().'"';
	}
 	$qs .= " WHERE ". $this->{table_name} . "_id='" . $main::Q->param(id)."'";
	return $qs;
}

sub set_rank{
	my $this = shift;
	$this->{rank} = shift;	
}

# package Form end

package AddForm;
@ISA = qw( Form );

sub _get_form_template{
	my $this = shift;
	my $fields = shift;
	
	my $button = $this->{tmpl}->get_tmpl('cancel',$this->make_cancel_url());
	$button .= $this->{tmpl}->get_tmpl('button','Lisa',$this->{form_name},'add');
	
	return $this->{tmpl}->get_tmpl('form',
												$this->{form_name},
												$$fields,
												$button,
												'', # id
												$this->make_hiddens()
											);
}

sub _get_max_order_nr{
	my $this = shift;
	
	my $qs = "SELECT MAX(".$this->{rank}.") FROM ". $this->{table_name};
	my $sth = $main::DBH->prepare($qs) || die $dbh->errstr;
	$sth->execute() || die $sth->errstr;	
	return $sth->fetchrow_array(); # get max order nr
}

sub make_add_query{  # makes update query from array of field objects	
	my $this = shift;

	return $this->SUPER::make_add_query() unless ($this->{rank}); # table not ordered
	
	my $max = $this->_get_max_order_nr();
	my $pseudo = new Field('', $this->{rank});  # make field for super class method
	$pseudo->set_value($max+1);					  # which makes insert string out of it
	$this->add_field($pseudo);
	my $qs = $this->SUPER::make_add_query();
	pop @{$this->{fields}}; # remove pseudo
	return $qs;
}

sub _field_html_row{
	my $this = shift;
	my $f = shift;
	return $f->as_edit_html_row();
}

package UpdateForm;
@ISA = qw( Form );

sub _get_form_template{
	my $this = shift;
	my $fields = shift;
	
	my $button = $this->{tmpl}->get_tmpl('cancel',$this->make_cancel_url());
	$button .= $this->{tmpl}->get_tmpl('button','Update',$this->{form_name},'update');
	
	return $this->{tmpl}->get_tmpl('form',
												$this->{form_name},
												$$fields,
												$button,
												$this->{record_id},
												$this->make_hiddens(),
												$main::Q->param(start)  # where to list should return
											)
}

sub _make_qs{
	my $this = shift;	
	return $this->make_update_query();
}

sub _field_html_row{
	my $this = shift;
	my $f = shift;
	return if ($f->is_read_only());
	return $f->as_edit_html_row();
}

1;