package ListRestrictionForm;
use strict;
use warnings;
use Data::Dumper;
use Form;
use Mrt::Carrier;

@ListRestrictionForm::ISA = qw(Form Mrt::Carrier);

sub new {
   my $classname = shift;
	my $this  = {};
   bless($this, $classname);
   $this->{g} = shift;
   $this->{form_width} = '300'; # default value
   return $this;
}

sub set_width {
	my $this = shift;
	my $width = shift;
	$this->{form_width} = $width;
}

sub add_field {
	my $this = shift;
	my $f = $_[0];
	my $operator = $_[1];
	$f->set_prefix('search');
	$this->SUPER::add_field(@_);
	# fields could have operators like 'LIKE' or default '='
	# put them into hash. filed name serves as key
	$this->{operators}->{$f->get_db_fname()} = $operator if ($operator);
}

# sub get_sql {
# 	my $this = shift;
# 	my $restrictions = '';
# 	foreach my $field (@{$this->{fields}}) {
# 		my $name_in_form = $field->get_fname();
# 		my $name_in_db = $field->get_db_fname();
# 		my $value = $G->param($name_in_form);
# 		
# 		next unless ($value);
# 		
# 		# default operator is '='
# 		my $operator = $this->{operators}->{$name_in_db} || '=';
# 		
# 		if ($operator =~ m/(%?)LIKE(%?)/ig) {
# 			$value = $1 . $value . $2;
# 			$operator = 'LIKE';
# 		}
# 		
# 		$restrictions .= 'and ' . $name_in_db . ' ' . $operator . ' \'' . $value . '\'';
# 	}

# 	return $restrictions;
# }

sub as_html {
	my $this = shift;
	
	$this->_populate_fields();
	
	my $fields_html;
	foreach my $field (@{$this->{fields}}) {
		$fields_html .= $this->_field_html_row($field);
	}
	
	my $h;
	$h->{rows} = $fields_html;
	$h->{width} = $this->{form_width} || $ListRestrictionForm::FORM_W;
	$h->{hiddens} = $this->_make_hiddens({remove=>['pos', 'search_name', 'search_mail']});
	$h->{action} = $this->_add_base_path();
	return $this->{g}->tmpl('restriction_form', $h);
}

sub _populate_fields {
	my $this = shift;
	foreach my $field (@{$this->{fields}}) {
		my $name_in_form = $field->get_fname();
		my $value = $this->{g}->param($name_in_form);
		$field->set_value($value, 1); # 1 - from form
	}
}

1;