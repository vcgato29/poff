package List;
use Data::Dumper;
use Mrt::Carrier;
use Form;
use strict;
@List::ISA = ('Mrt::Carrier');

sub new {
	my $classname = shift;
	my $this      = {};
	bless($this, $classname);

	$this->{table_name} = shift;
	$this->{g}          = shift;
	$this->{cache}      = ();

	return $this;
}

sub set_restriction_form {
	my $this = shift;
	$this->{restriction_form} = shift;
}

sub set_query {
	my $this = shift;
	$this->{query} = shift;
}

sub set_printable       { my $this = shift; $this->{printable}       = shift; }
sub set_rank            { my $this = shift; $this->{rank}            = shift; }
sub set_process_row_sub { my $this = shift; $this->{process_row_sub} = shift; }
sub set_search_form     { my $this = shift; $this->{search_form}     = shift; }
sub set_field_sub       { my $this = shift; $this->{add_fields_sub}  = shift; }
sub out                 { my $this = shift; return $this->{out}; }
sub set_handler_name    { my $this = shift; $this->{handler_name}    = shift; }
sub set_width           { my $this = shift; $this->{width}           = shift; }
sub add_column { my $this = shift; push @{ $this->{columns} }, [@_]; }

sub set_list_limit {
	my $this = shift;
	$this->{g}->conf('list_page_size') = shift;
	die 'query should be set before call to set_list_limit'
	  unless ($this->{query});
	$this->{query}->set_list_limit(3);
}

sub _make_title_string {
	my $this      = shift;
	my $start_row = ($this->{g}->param("start_pos") || 0);
	my $s         = $start_row + 1;
	my $e         = $s + $this->{g}->conf('list_page_size') - 1;
	my $c         = $this->_get_count();
	$e = $e < $c ? $e : $c;
	$s = 0 unless ($c);
	my $title_string = "&nbsp;Showing $s - $e of $c";
}

sub _get_colspan {
	my $this = shift;
	return (scalar @{ $this->{columns} }) * 2;
}

sub _get_title_values {
	my $this    = shift;
	my @columns = @{ $this->{columns} };
	my $h_ref   = {};
	while (@columns) {
		my $col = shift @columns;
		$h_ref->{ $col->[0] } = $col->[1];
	}

	$h_ref->{button_row} = '';

	return $h_ref;
}

sub _make_row {
	my $this    = shift;
	my $h_ref   = shift;
	my $style   = shift;
	my @columns = @{ $this->{columns} };
	my $retval;
	while (@columns) {
		my $col   = shift @columns;
		my $value = $h_ref->{$col->[0]};
		my $width = $col->[2];
		if ((scalar @columns) == 0) {
			$width = '';
			$value =
			    '<div style="float: right">'
			  . $h_ref->{button_row}
			  . '</div>'
			  . $value;
		}

		$retval .=
		  $this->{g}->tmpl('list.row_col', { value => $value, width => $width });
		$retval .= $this->{g}->tmpl('list.col_separator', {})
		  unless ((scalar @columns) == 0);    # not to last one
	}

	my $h_ref2 = {};
	$h_ref2->{style} = $style;
	$h_ref2->{cols}  = $retval;
	return $this->{g}->tmpl('list.data_row', $h_ref2);
}

sub as_html {
	my $this = shift;
	my $retval;

	return $this->{out}
	  if ($this->{out});    # handle params put something into $this->{out}

	my $start_pos = $this->{g}->param('start_pos');
	my $iter      = $this->{query}->fetch_query($start_pos, 
	  							$this->{g}->conf('list_page_size'));
	# member query object makses db call and returns Mrt::Iterator

	my $count = 0;
	my $template;
	my $rows = '';
	
	while ($iter->has_next()) {
		my $h_ref = $iter->next();
		$h_ref->{count_on_page} = $count++;
		$this->process_row($h_ref);  # subclasses make links of them and such
		my $style = ($count % 2 == 0) ? 'evenListRow' : 'oddListRow';
		$rows .= $this->_make_row($h_ref, $style);
	}

	if ($count == 0) {
		$rows .=
		  $this->{g}->tmpl('list.message_row', { msg => 'Andmed puuduvad' });
	} else {
		$rows = $this->_make_row($this->_get_title_values(), 'listTitle') . $rows;
	}

	my $h;
	$h->{width}        = $this->{width};
	$h->{colspan}      = $this->_get_colspan();
	$h->{title}        = $this->_make_title_string();
	$h->{add_new_link} =
	  $this->{g}->tmpl('list.add_new_link', { link => $this->_new_link() });
	$h->{rows}   = $rows;
	$h->{footer} = $this->_make_footer();

	if ($this->{restriction_form}) {

		# if restrictions apply pos will be wrong
		$this->{restriction_form}->set_carry_fields($this->get_carry_fields());
		$h->{restriction_form} = $this->{restriction_form}->as_html();
	}

	#$retval = $this->_make_search_table() if ($this->{search_form});
	$retval .= $this->{g}->tmpl('list.list_table', $h);

	return $retval . $this->_make_print_links();
}

sub _make_print_links {
	my $this = shift;
	return '' unless ($this->{printable});
	my $retval = '';
	my $link   = $this->_add_base_path("driver=rtf&ListCmd=printList");
	$retval .= qq~<br>&nbsp;<a href="$link">salvesta rtf</a> | ~;
	$link = $this->_add_base_path("driver=pdf&ListCmd=printList");
	$retval .= qq~<a href="$link">salvesta pdf</a><br><br>~;
	return $retval;
}

sub _make_page_select_link {
	my $this = shift;
	my $c    = shift;

	if ($this->{search_form}) {
		return "javascript:document.search_form.start.
							value=$c;document.search_form.submit()";
	} else {
		return $this->_add_base_path("start_pos=$c");
	}
}

sub _make_footer {
	my $this        = shift;
	my $count_field = $this->{table_name} . '_count';
	my $count       = $this->{g}->param($count_field);
	my $start_pos   = ($this->{g}->param('start_pos') || 0);

	$start_pos = $start_pos - 8 * $this->{g}->conf('list_page_size');
	$start_pos = 0 if ($start_pos < 0);
	my $end_pos = $start_pos + 16 * $this->{g}->conf('list_page_size');

	$count = $this->_get_count() unless ($count);

	my $links;
	$links = "... " if ($start_pos > 0);
	for (
		my $c = $start_pos ;
		$c < $end_pos and $c < $count ;
		$c += $this->{g}->conf('list_page_size')
	  )
	{
		$links .= '<a href="';
		$links .= $this->_make_page_select_link($c);
		$links .= '">';
		$links .= $c + 1;
		$links .= "</a>&nbsp;";
	}

	$links .= "..." if ($end_pos + $this->{g}->conf('list_page_size') < $count);

	return $links;
}

sub reset_cache {
	my $this = shift;
	$this->{cache} = ();
}

sub _get_count {
	my $this = shift;
	return $this->{cache}->{count} ||= $this->{query}->count_query();
}

sub set_commands {
	my $this = shift;
	$this->{commands} = [@_];
}

sub _make_buttons {
	my $this   = shift;
	my $h_ref  = shift;
	my $retval = '';
	my $id     = $h_ref->{id};

#	my $fl = '';
#	if ($this->{rank}) {    # to disable up/down button
#		$fl = "f" if ($h_ref->{rank} eq "1");
#		$fl .= "l" if ($h_ref->{rank} eq $this->_get_count());
#	}

	for my $cmd (@{ $this->{commands} }) {
		$retval .= $this->_get_button($cmd, $id);
	}

	$h_ref->{button_row} = $retval;

	return;
}

sub _get_button {
	my $this    = shift;
	my $cmd     = shift || '';
	my $id      = shift;
	my $disable = shift;

	my %commands = (
		follow   => { img => 'bttn_follow.gif',     title => 'Sisu' },
		upload   => { img => 'bttn_upload.gif',     title => 'Lae &uuml;les' },
		edit      => { img => 'bttn_edit.gif',      title => 'Muuda' },
		edit_page => { img => 'bttn_edit_page.gif', title => 'Muuda sisu' },
		up   => { img => 'bttn_up.gif',   title => 'Liiguta 1 v�rra �les' },
		down => { img => 'bttn_down.gif', title => 'Liiguta 1 v�rra alla' },
		del  => { img => 'bttn_del.gif',  title => 'Kustuta', conf => 1 }
	);

	my $start = $this->{g}->param('start_pos');
	my $link = '';
	$link = $this->_add_base_path("ListCmd=$cmd&id=$id&start_pos=$start");
	
	if ($cmd eq 'upload') {
		my $url = $this->_add_base_path(
			"todo=upload_page&id=$id",	{remove=>['handler']});
		$link = "javascript:upload_win('$url')";
	}
	
	if (exists $commands{$cmd}->{conf}) {
		$link = qq~javascript:confirm_and_go('kustutada','$link');~;
	}
	
	my $img   = $commands{$cmd}->{img};
	my $title = $commands{$cmd}->{title};
	my $h_ref = { link => $link, img => $img, title => $title };

	return $this->{g}->tmpl('list.button_command', $h_ref);
}

sub _new_link {
	my $this = shift;
	return $this->_add_base_path("ListCmd=add_form");
}

sub set_titles {    # array for title row texts
	my $this = shift;
	push @{ $this->{titles} }, @_;
}

sub _cmd_add {
	my $this = shift;
	my $form = Form->new($this->{table_name}, $this->{g});
	$form->set_rank($this->{rank});
	$this->{add_fields_sub}->($form);
	my $inserted_id = $form->save_form();
	$form->set_carry_fields($this->{hiddens});
	$this->{out} = $this->as_html();
	return $inserted_id;
}

sub _cmd_delete {
	my $this = shift;
	my $id   = shift;
	$this->{query}->delete_query($id);
	$this->{out} = $this->as_html();
}

sub _get_id_field {
	my $this = shift;
	return $this->{table_name} . "_id";
}

sub _get_list_cmd {
	my $this = shift;
	if (defined $this->{hiddens}->{'ListCmd'}) {
		return $this->{hiddens}->{'ListCmd'};
	} else {
		return $this->{g}->param('ListCmd');
	}
}

sub handle_params {
	my $this = shift;
	
	$this->_get_list_cmd();
	
	if ($this->_get_list_cmd() eq 'add_form') {    
		my $form = new Form($this->{table_name}, $this->{g});
		$form->set_carry_fields($this->get_carry_fields());
		$this->{add_fields_sub}->($form);
		$this->{out} = $form->as_html();
		return;
	} elsif ($this->_get_list_cmd() eq 'edit') {
		my $form = new Form($this->{table_name}, $this->{g});
		$form->set_carry_fields($this->get_carry_fields());
		$this->{add_fields_sub}->($form);
		$form->set_record_id($this->{g}->param('id'));
		$form->set_button('update');
		$form->load_form();
		$this->{out} = $form->as_html();
		return;

	} elsif ($this->{g}->param('ListCmd') eq 'printList') {
		$this->_cmd_print();
		return;

	} elsif ($this->{g}->param('FormCmd') eq 'update') {
		my $form = Form->new($this->{table_name}, $this->{g});
		$this->{add_fields_sub}->($form);
		$form->set_carry_fields($this->{hiddens});
		$form->set_record_id($this->{g}->param('id'));
		$form->update_form();
		$this->{g}->remove('menu_tree');
		$this->{out} = $this->as_html();
		return;
	} elsif ($this->{g}->param('FormCmd') eq 'add') {
		$this->_cmd_add();
		return;
	} elsif ($this->_get_list_cmd() eq 'del') {
		$this->_cmd_delete($this->{g}->param('id'));
		return;
	} elsif ($this->_get_list_cmd() eq 'up') {
		$this->{query}->up_query($this->{g}->param('id'));
		$this->{out} = $this->as_html();
		return;
	} elsif ($this->_get_list_cmd() eq 'down') {
		$this->{query}->down_query($this->{g}->param('id'));
		$this->{out} = $this->as_html();
		return;
	}
}

sub process_row {
	my $this  = shift;
	my $h_ref = shift;

	if ($this->{process_row_sub}) {
		$this->{process_row_sub}->($h_ref);    # do additional processing
	}

	$h_ref->{buttons} =
	  $this->_make_buttons($h_ref);    # make buttons of it and put it back
}

##############################################################################
# end of package List;
##############################################################################

1;