package Form;
use Field;
use Data::Dumper;
use Mrt::Util;
use Mrt::Carrier;
use funcs;
use strict;
our @ISA = qw(Mrt::Carrier);

sub new {
   my $classname = shift;
	my $this  = {};
   bless($this, $classname);
   
   $this->{table_name} = shift;
   $this->{g} = shift;
   $this->{button} = 'add';
   
   return $this;
}

sub set_button { my $this = shift; $this->{button} = shift; }
sub set_params { my $this = shift; $this->{params} = shift; }
sub set_record_id { my $this = shift; $this->{record_id} = shift; }
sub set_rank { my $this = shift; $this->{rank} = shift; }
sub set_on_submit { my $this = shift; $this->{on_submit_sub} = shift; }

sub get_record_id{ my $this = shift; return $this->{record_id}; }

sub add_field {
	my $this = shift;
	my $f = shift;
	$f->set_global($this->{g});
	$f->set_form_name($this->{table_name});
	push @{$this->{fields}}, $f;
}

sub as_html {
	my $this = shift;
	my $fields_html;
	foreach my $field (@{$this->{fields}}) {
		$fields_html .= $this->_field_html_row($field);
	}
	
	$this->_get_form_template(\$fields_html);
}

sub _field_html_row {
	my $this = shift;
	my $f = shift;
	return if ($f->is_read_only());
	return $f->as_edit_html_row();
}

sub _get_submit_button {
	my $this = shift;
	my $h_ref = {};
	
	$h_ref->{form_name} = $this->{table_name};
	$h_ref->{cmd} = $this->{button} eq 'add' ? 'add' : 'update';
	$h_ref->{label} = $this->{button} eq 'add' ? 'Lisa' : 'Update';

	return $this->{g}->tmpl('form.button',$h_ref);
}

sub _get_cancel_button {
	my $this = shift;
	return $this->{g}->tmpl('form.cancel',{ href=>$this->_add_base_path('FormCmd=cancel')});
}

sub _get_form_template {
	my $this = shift;
	my $fields = shift;
	
	my $buttons = $this->_get_cancel_button();
	$buttons .= $this->_get_submit_button();
	
	my $h;
	$h->{name} = $this->{table_name};
	$h->{record_id_name} = 'id';
	$h->{record_id_value} = $this->{record_id};
	$h->{rows} = $$fields;
	$h->{buttons} = $buttons;
	$h->{hiddens} = $this->_make_hiddens();
	my @tokens = split /\//, $0;
	$h->{action} = pop @tokens;
	
	return $this->{g}->tmpl('form.form',$h);
}

sub update_form(){
	my $this = shift;
	$this->save_form(1);
}

sub _param {
	my $this = shift;
	my $field_name = shift;
	return $this->{params}->{$field_name} if ($this->{params});
	return $this->{g}->param($field_name);
}

# returns insertion id
sub save_form {
	my $this = shift;	
	my $is_update = shift;
	
	foreach my $field (@{$this->{fields}}){
		my $value = $this->_param($field->get_fname);
		Mrt::Util::text_to_html(\$value) unless ($field->is_html());		
		$field->set_value($value , 1); # ,1 means value comes from form
	}

	my $h_ref = {};
	if ($is_update){
		$this->_do_update_query($this->_param('id'));
		$h_ref->{id} = $this->_param('id');
		$h_ref->{command} = 'update';
	} else {
		$h_ref->{id} = $this->_do_add_query();
		$h_ref->{command} = 'add';
	}

	$this->{on_submit_sub}->($h_ref) if ($this->{on_submit_sub});

	return $h_ref->{id};
}

sub load_form() {
	my $this = shift;
	my $qs = $this->_make_get_query();
	my $sth = $this->{g}->execute($qs);
	
	my @values = $sth->fetchrow_array();
	foreach my $field (@{$this->{fields}}){
		if ($field->is_dont_load()){
			$field->set_value('');
			next;
		};
		my $value = shift @values;
		$value = '' if (! defined $value);
		Mrt::Util::html_to_text(\$value) unless $field->is_html();
		$field->set_value( $value );
	}
}

sub _make_get_query { # makes update query from array of field objects	
	my $this = shift;
	my $qs = "SELECT ";
	my $f = 0;
	my $fields;
	
	foreach my $field (@{$this->{fields}}){
		next if ($field->is_dont_load());
		if ($f++) { $fields .= ", "}; # no , for firstone
		$fields .= $field->get_db_fname();
	}
	$qs .= "$fields FROM ".$this->{table_name};
	$qs .= " WHERE ". $this->{table_name} . "_id='" . $this->{record_id} . "'";
	return $qs;
}

sub _do_add_query { # makes add query from array of field objects
	my $this = shift;

	if ($this->{rank}) {
		my $max = $this->_get_max_order_nr();
		my $pseudo = new Field('', $this->{rank});  # make field for super class method
		$pseudo->set_value($max+1);					  # which makes insert string out of it
		$this->add_field($pseudo);
	}

	my $f = 0;
	my ($fields, $values) = (' (',' VALUES (');
	my @field_names = ();
	my @field_values = ();
	
	foreach my $field (@{$this->{fields}}){
		next if ($field->is_dont_save());
		push @field_names, $field->get_db_fname();
		push @field_values, $field->get_value();
	}

	my $qs = sprintf 'INSERT INTO %s (%s) VALUES (%s)',
					$this->{table_name},
					(join ", ", @field_names),
					(join ", ", map { '?' } @field_values);

	if ($this->{rank}){
		pop @{$this->{fields}}; # remove pseudo	
	}

	$this->{g}->execute($qs, @field_values);
	return $this->{g}->insert_id();
}

sub _do_update_query {  # makes update query from array of field objects	
	my $this = shift;
	my $id = shift;
	my @field_names = ();
	my @field_values = ();
	
	foreach my $field (@{$this->{fields}}){
		next if ($field->is_file() and ($field->get_value() eq "/" or $field->get_value() eq "")); # we don't update file fields when they are empty
		next if ($field->is_pass() and $field->get_value() eq "");
		next if ($field->is_dont_save());
		push @field_names, $field->get_db_fname();
		push @field_values, $field->get_value();
	}

	my $qs = sprintf 'UPDATE %s SET %s where %s = ?',
					$this->{table_name},
					(join ", ", map { $_ . '= ?' } @field_names),
					$this->{table_name} . '_id';

	$this->{g}->execute($qs, @field_values, $id);
}

sub _get_max_order_nr{
	my $this = shift;	
	my $qs = "SELECT MAX(".$this->{rank}.") FROM ". $this->{table_name};
	$qs = $qs;
	my $sth = $this->{g}->execute($qs);
	return $sth->fetchrow_array(); # get max order nr
}

1;
