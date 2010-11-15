##############################################################################
package List;
use Form;

my %fields = (
   table_name => undef,
	tmpl =>undef,
	query =>undef,
	titles =>undef,
	base_path => undef,
	buttons => undef,
	count => undef,  # how many rows is there
	start => undef,  # from where to show list
	handler => undef,# module_name who handles querys. for appending to param strings
	out => undef,    # output string
	param => undef,  # CGI object for parameters
	dbh => undef     # database handle
);

sub new {
   my $classname = shift;
	my $this  = {%fields};
   bless($this, $classname);
   $this->{table_name} = shift;
   $this->{tmpl} = new Tmpl(); # contains template object
   return $this;
}

sub out{	my $this= shift; 	return $this->{out};	}
sub set_param{	my $this= shift; 	$this->{param} = shift;	}
sub set_base_path{	my $this= shift; 	$this->{base_path} = shift;	}
sub set_dbh{	my $this= shift; 	$this->{dbh} = shift;	}

sub _add_padding{
	my $this = shift;
	my $ref = shift;
	my $level = shift;
	$$ref = "&nbsp;&nbsp;&nbsp;" x $level . $$ref
}

sub _make_title_string{
	my $this = shift;
	my $start_row = $this->{param}->param("start") + 0;
	my $s = $start_row+1;
	my $e = $s + $main::CONFIG{list_limit}-1;
	my $c = $this->_get_count();
	$e = $e<$c?$e:$c;
	my $title_string = "&nbsp;Showing $s - $e of $c";
}

sub as_html{
	my $this = shift;
	my $retval;	
	
	my $start_row = $this->{param}->param("start" ) + 0;
	
	$retval .= $this->{tmpl}->get_tmpl('title_row', @{$this->{titles}} ); # add title row
	
	my $sth = $this->{query}->fetch_query($start_row); # member query object makses db call and returns db handle
	
	my $count=1; my $template;
	while (my @values = $sth->fetchrow_array()){
		$this->process_row(\@values); # subclasses make links on them and such
		if ($count++ % 2){ $template = 'odd_row'	}else{ $template = 'even_row' }
		$retval .= $this->{tmpl}->get_tmpl($template, @values );	
	}
	$retval .= $this->_make_footer();	# add footer
	$retval = $this->{tmpl}->get_tmpl('list_table', $retval , $this->new_link(), $this->_make_title_string);
	
	return $retval;
}

sub _make_footer{
	my $this = shift;
	my $count_field = $this->{table_name}.'_count';
	my $count = $main::Q->param($count_field);
	my $start = $main::Q->param('start');
	
	my $start_pos = $start - 8 * $main::CONFIG{list_limit};
	$start_pos = 0 if ($start_pos<0);
	my $end_pos = $start_pos + 16*$main::CONFIG{list_limit};
	
	
	$count = $this->_get_count unless ($count);
	
	my $links;
	my $handler = $this->handler();
	$links = "... " if ($start_pos>0);
	for (my $c=$start_pos;$c<$end_pos and $c<$count ;$c+=$main::CONFIG{list_limit}){
		$links .= '<a href="';
		$links .= $this->add_base_path("start=$c&$handler");
		$links .= '">';
		$links .= $c+1;
		$links .= "</a>&nbsp;";
	}
	$links .= "..." if ($end_pos+$main::CONFIG{list_limit}<$count);
	
	return $this->{tmpl}->get_tmpl('footer_row', $links);	# add footer
}

sub _get_count{
	my $this = shift;
	return $this->{count} if (defined $this->{count});
	
	$this->{count} = $this->{query}->count_query();
	return $this->{count};
}

sub set_buttons{
	my $this = shift;
	$this->{buttons} = shift;
}

sub _get_buttons{
	my $this = shift;
	my $id = shift;	
	my $pos = shift;
	my $retval;
	my $handler = $this->handler();
	
	my $start = $this->{param}->param('start');
	$start = "&start=$start" if (defined $start);
	
	my $del_link = $this->add_base_path("$handler&cmd=del&id=$id$start");
	my $del_link = qq~javascript:confirm_and_go('kustutada','$del_link');~;
	
	if ($this->{buttons} =~ /m/){$retval.=$this->{tmpl}->get_tmpl('button_edit', $this->add_base_path("$handler&cmd=edit_form&id=$id$start"));}
	if ($this->{buttons} =~ /ü/ and $pos !~ /f/){$retval.=$this->{tmpl}->get_tmpl('button_up', $this->add_base_path("$handler&cmd=up&id=$id$start"));}
	if ($this->{buttons} =~ /ü/ and $pos =~ /f/){$retval.=$this->{tmpl}->get_tmpl('button_up_dis');}
	if ($this->{buttons} =~ /a/ and $pos !~ /l/){$retval.=$this->{tmpl}->get_tmpl('button_down', $this->add_base_path("$handler&cmd=down&id=$id$start"));}
	if ($this->{buttons} =~ /a/ and $pos =~ /l/){$retval.=$this->{tmpl}->get_tmpl('button_down_dis');}
	if ($this->{buttons} =~ /k/){$retval.=$this->{tmpl}->get_tmpl('button_del', $del_link);}
	return $retval;
}

sub handler{ 
	my $this = shift;
	my $handler_name = $this->handler_name();
	return "handler=$handler_name"; 
}

sub handler_name{die 'abstract called - handler_name';} # abstract
sub process_row{die 'abstract called - process_row';} # abstract
sub rank{ return '';}

sub new_link{
	my $this = shift;
	my $handler_name = $this->handler_name();
	return $this->add_base_path("handler=$handler_name&cmd=add_form");
}

sub add_base_path{
	my $this = shift;
	my $params = shift;
	if ($this->{base_path} eq ''){
		return "?".$params;
	}else {
		return $this->{base_path}."&$params";
	}
}

sub set_titles{ # array for title row texts
	my $this = shift;
	push @{$this->{titles}}, @_;	
}

sub set_query{
	my $this = shift;
	$this->{query} = shift;
}

sub cmd_add{
	my $this = shift;
	my $form = new AddForm($this->table_name());
	
	$form->set_rank($this->rank());
	$this->add_fields($form);
	my $inserted_id = $form->save_form();
	$this->{out} = $this->as_html();
	return $inserted_id;
}

sub cmd_delete{
	my $this = shift;
	my $id = shift;
	$this->{query}->delete_query($id);
	$this->{out} = $this->as_html();
}

sub handle_params{
	my $this = shift;

	if ($this->{param}->param('cmd') eq 'add_form'){
		my $form = new AddForm($this->table_name);
		$form->set_hiddens(qw/lang handler st start/);
		$this->add_fields($form);
		$this->{out} = $form->as_html();
		return;
	}
	elsif ($this->{param}->param('cmd') eq 'edit_form'){
		my $form = new UpdateForm($this->table_name);
		$form->set_hiddens(qw/lang handler st start/);
		$this->add_fields($form);
		$form->set_record_id($this->{param}->param('id'));
		$form->load_form();
		$this->{out} = $form->as_html();
		return;
	}
	elsif ($this->{param}->param('cmd') eq 'add'){
		$this->cmd_add();
		return;
	}
	elsif ($this->{param}->param('cmd') eq 'update'){
		my $form = new UpdateForm($this->table_name);
		$this->add_fields($form);
		$form->set_record_id($this->{param}->param('id'));
		$form->save_form();
		$this->{out} = $this->as_html();
		return;
	}
	elsif ($this->{param}->param('cmd') eq 'del'){
		$this->cmd_delete($this->{param}->param('id'));
		return;
	}
	elsif ($this->{param}->param('cmd') eq 'up'){
		$this->{query}->up_query($this->{param}->param('id'));
		$this->{out} = $this->as_html();
		return;
	}
	elsif ($this->{param}->param('cmd') eq 'down'){
		$this->{query}->down_query($this->{param}->param('id'));
		$this->{out} = $this->as_html();
		return;
	}else{
		$this->{out} = $this->as_html();
		return;
	}
}

##############################################################################

package PageList;
@ISA = qw( List );
use Tree1;

sub table_name{ return "page"; }
sub handler_name{ return "PageList"; }
sub rank{ return "rank"; }

sub _get_buttons{
	my $this = shift;
	my $id = shift;	
	my $retval;
	my $pos = shift;
	if ($this->{buttons} =~ /l/){$retval.=$this->{tmpl}->get_tmpl('button_edit_page', $this->add_base_path("todo=edit_page&id=$id$start"));}
	$retval .= $this->SUPER::_get_buttons($id,$pos);
	return $retval;
}

sub cmd_add{
	my $this = shift;
	my $inserted_id = $this->SUPER::cmd_add();
	&main::new_page($inserted_id);
	return $inserted_id;
}

sub cmd_delete{
	my $this = shift;
	my $id = shift;
	$this->SUPER::cmd_delete($id);
	&main::del_page($id);
}

sub add_fields{
	my $this = shift;
	my $form = shift;
	my $f = new Field('nimi', 'name');
	$form->add_field($f);
	$f = new Field('laius', 'width');
	$form->add_field($f);
	$f = new Field('kõrgus', 'height');
	$form->add_field($f);
	$f = new SelectField('vanem', 'parent_id');
	my $list = $this->_make_menu_list($this->{param}->param('id'));
	$f->set_list($list);
	$form->add_field($f);
	
	$f = new SelectField('viitab', 'points_to');
	$list = $this->_make_menu_list();
	$f->set_list($list);
	$form->add_field($f);

	$f = new SelectField('moodul', 'module');
	$list = main::module_list();
	$f->set_list($list);
	$form->add_field($f);

	$f = new CheckField('nähtamatu', 'hidden');
	$form->add_field($f);
	$f = new CheckField('uus aken', 'new_win');
	$form->add_field($f);
	
	my $func = sub { # if we set some page to be frontpage then no other should be marked as fronpage
		my $value_ref = shift;
		my $from_form = shift;	
		if ($from_form and $$value_ref eq '1'){
			my $lang_id = $main::LANG;
			$this->{dbh}->do(qq~UPDATE page SET frontpage=0 WHERE lang_id=$lang_id~)  || die $this->{dbh}->errstr;		
		}	
	};

	$f = new CheckField('avaleht', 'frontpage');
	$f->set_set_value_trigger($func);
	$form->add_field($f);
	
	$f = new HiddenField('', 'lang_id');
	$f->set_value($main::LANG);
	$form->add_field($f);
}

sub _make_menu_list{ # makes array of arrays (id, padded name) for listbox
							# for selecting parent
	my $this = shift;
	my $current_id = shift;
	
	my $values;
	
	my $sth = $this->{query}->fetch_query(0); # member query object makes db call and returns db handle
															# startrow is allways 0 - we don't page tree	
	my $tree = new Tree1; # make tree of all rows
	while (my @values = $sth->fetchrow_array()){ 
		$tree->add_node($values[0],$values[1],\@values); # id, parent_id, whole thing
	}
	
	my @ids = @{$tree->get_ordered_ids({no_descendants=>$current_id})}; # ids in new order

	while (@ids){
		my $id = shift @ids;
		my $row = $tree->get_value($id); # get values of current id
		my @slice = @$row[0,2]; # id , name
		$this->_add_padding(\@slice[1],$tree->get_level($id)); # add padding to name(\@slice[1]) according to level
		push @$values, \@slice;
	}
	unshift @$values, [(0,'')]; # root level parent
	return $values;
}

sub as_html{
	my $this = shift;
	my $retval;	
	
	$retval .= $this->{tmpl}->get_tmpl('title_row', @{$this->{titles}} ); # add title row
	my $sth = $this->{query}->fetch_query(0); # member query object makes db call and returns db handle
															# startrow is allways 0 - we don't page tree	
	my $tree = new Tree1; # make tree of all rows
	while (my @values = $sth->fetchrow_array()){ 
		$tree->add_node($values[0],$values[1],\@values); # id, parent_id, whole thing
	}
	
	my @ids = @{$tree->get_ordered_ids()}; # ids in new order
	my $count=1; my $template;

	while (@ids){
		my $id = shift @ids;
		my $values = $tree->get_value($id); # pop values of current id
		
		$this->process_row($values,$tree); # subclasses make links on them and such
		
		splice @$values,1,1; # remove parent_id field
		$this->_add_padding(\@$values[1],$tree->get_level($id)); # add padding according to level
		
		if ($count++ % 2){ $template = 'odd_row'	}else{ $template = 'even_row' }
		$retval .= $this->{tmpl}->get_tmpl($template, @$values );
	}

	$retval .= $this->_make_footer();	# add footer

	$retval = $this->{tmpl}->get_tmpl('list_table', $retval , $this->new_link(), $this->_make_title_string);
	return $retval;
}

sub process_row{
	my $this = shift;	
	my $array_ref = shift;
	my $tree = shift;
	my $id = shift @$array_ref; # remove id
	my $page_name = splice @$array_ref,1,1; # remove page_name
	
	my ($pos,$class,$nw);

	if (@$array_ref[4] == 1){ # @$array_ref[6] is hidden flag (2 are shifted)
		$class = ' class="gray" ';
	}
	if (@$array_ref[5] == 1){ # @$array_ref[7] is hidden flag (2 are shifted)
		$nw = '(NW)';
	}
	
	my $url = $this->add_base_path("todo=view_page&id=$id");
	my $link = qq~<a href="$url" $class>$page_name $nw</a>~;
	$class = '';
	
	$pos = "f" if  ($tree->is_first($id));
	$pos .= "l" if  ($tree->is_last($id));
	
	if (@$array_ref[6] == 1){ # @$array_ref[8] is dir flag (2 are shifted)
		$link = $page_name;
	}
	
	splice @$array_ref,1,0,$link; # put link to page_name postition
	unshift @$array_ref, $this->_get_buttons($id,$pos); # make buttons of it and put it back
}

##############################################################################

package FilmList;
@ISA = qw( List );
use Tree1;

sub table_name{ return "film"; }
sub handler_name{ return "FilmList"; }
sub rank{ return ; }

sub add_fields{
	my $this = shift;
	my $form = shift; my $f;

	$f = new Field('nimi(est)', 'name_est');
	$form->add_field($f);
	$f = new Field('nimi(eng)', 'name_eng');
	$form->add_field($f);
	$f = new Field('nimi(rus)', 'name_rus');
	$form->add_field($f);
	$f = new Field('nimi(originaal)', 'name_orig');
	$form->add_field($f);
	
	$f = new AreaField('kirjeldus(est)', 'disc_est');
	$form->add_field($f);
	$f = new AreaField('kirjeldus(eng)', 'disc_eng');
	$form->add_field($f);
	$f = new AreaField('kirjeldus(rus)', 'disc_rus');
	$form->add_field($f);

	############################################################
	
	$f = new Field('kestvus', 'duration');
	$form->add_field($f);
	$f = new Field('aasta', 'year');
	$form->add_field($f);	
	
	############################################################
	# get program list
	my $list = new ProgramList('program');
	my $q = new ProgramQuery($this->{dbh},'program','rank');
	$q->set_lang($main::LANG);
	$list->set_query($q);
	$list->set_dbh($this->{dbh});
	
	my $prog_array = $list->_make_menu_list();
	############################################################
	
	$f = new SelectField('programm 1', 'prog_id_1');
	$f->set_list($prog_array);
	$form->add_field($f);
	
	$f = new SelectField('programm 2', 'prog_id_2');
	$f->set_list($prog_array);
	$form->add_field($f);
	
	############################################################
	# state fields
	my $state_array = main::get_list_form_db('state');
	
	$f = new SelectField('riik 1', 'state_id_1');
	$f->set_list($state_array);
	$form->add_field($f);
	
	$f = new SelectField('riik 2', 'state_id_2');
	$f->set_list($state_array);
	$form->add_field($f);
	
	$f = new SelectField('riik 3', 'state_id_3');
	$f->set_list($state_array);
	$form->add_field($f);
	
	$f = new SelectField('riik 4', 'state_id_4');
	$f->set_list($state_array);
	$form->add_field($f);
	
	$f = new SelectField('riik 5', 'state_id_5');
	$f->set_list($state_array);
	$form->add_field($f);
	
	############################################################
	# director fields
	my $director_array = main::get_list_form_db('director');
	
	$f = new SelectField('Režisöör 1', 'director_id_1');
	$f->set_list($director_array);
	$form->add_field($f);
	
	$f = new SelectField('Režisöör 2', 'director_id_2');
	$f->set_list($director_array);
	$form->add_field($f);
	
	$f = new SelectField('Režisöör 3', 'director_id_3');
	$f->set_list($director_array);
	$form->add_field($f);
	
	############################################################
	# picture
	
	$f = new FileField('pilt', 'picture_id');
	$f->set_pic(1);
	$f->set_catalog_id(88888);
	my $field_name = $f->get_fname();

	my $func = sub {
		my $value = shift;
		my $from_form = shift;
		if ($from_form and $main::Q->param($field_name)){ # executed only on form upload not when value is fetched form db
			my $file_name = main::upload( $field_name , 88888);
			if ($file_name){
				$main::DBH->do(qq~INSERT INTO upload (filename,catalog_id) VALUES ('$file_name','88888')~)  || die $main::DBH->errstr;	
				my $inserted_id = $main::DBH->{'mysql_insertid'};
				$$value = $inserted_id;
			}
		}else{
			my $qs = qq~SELECT filename, catalog_id FROM upload WHERE upload_id='$$value'~;
			my $sth = $main::DBH->prepare($qs) || die $dbh->errstr;	
			$sth->execute() || die $sth->errstr;
			my ($fn,$dir) = $sth->fetchrow_array();
			$$value = "$dir/$fn";
		}
	};
	
	$f->set_set_value_trigger($func);
	$form->add_field($f);
	

	############################################################
	# subtitles
	
	$f = new Field('subtiitrid(est)', 'subtitles_est');
	$form->add_field($f);
	$f = new Field('subtiitrid(eng)', 'subtitles_eng');
	$form->add_field($f);
	$f = new Field('subtiitrid(rus)', 'subtitles_rus');
	$form->add_field($f);
	
	############################################################
	# language
	
	$f = new Field('keel(est)', 'lang_est');
	$form->add_field($f);
	$f = new Field('keel(eng)', 'lang_eng');
	$form->add_field($f);
	$f = new Field('keel(rus)', 'lang_rus');
	$form->add_field($f);
	
	############################################################
	
	$f = new Field('stsenarist', 'scenario');
	$form->add_field($f);
	$f = new Field('operaator', 'cameraman');
	$form->add_field($f);
	$f = new AreaField('osatäitjad', 'cast');
	$form->add_field($f);

	$f = new Field('produtsent', 'producer');
	$form->add_field($f);
	$f = new Field('levitaja', 'distributor');
	$form->add_field($f);
	$f = new AreaField('festivalid ja auhinnad', 'price');
	$form->add_field($f);
	
	$f = new Field('koduleht', 'link');
	$form->add_field($f);


	############################################################
	
	$f = new AdditionField('vaatajaid', 'viewers');
	$form->add_field($f);

	$f = new AdditionField('hääletajaid', 'voters');
	$form->add_field($f);

	$f = new AdditionField('skoor', 'score');
	$form->add_field($f);
}

sub process_row{
	my $this = shift;	
	my $array_ref = shift;
	my $id = shift @$array_ref; # remove id
	unshift @$array_ref, $this->_get_buttons($id); # make buttons of it and put it back
}

##############################################################################

package TimetableList;
@ISA = qw( List );

sub table_name{ return "timetable"; }
sub handler_name{ return "TimetableList"; }
sub rank{ return; }

sub add_fields{
	my $this = shift;
	my $form = shift;
	my $f;
	
	$f = new DateTimeSelectField('aeg', 'date');
	$list = main::make_dates_array();
	$f->set_list($list);
	$form->add_field($f);
	
	$f = new SelectField('kino', 'cinema_id');
	$list = main::get_list_form_db('cinema');
	$f->set_list($list);
	$form->add_field($f);
	
	$f = new SelectField('film', 'film_id');
	$list = main::get_list_form_db('film');
	$f->set_list($list);
	$form->add_field($f);

	$f = new AreaField('kirjeldus(est)', 'disc_est');
	$form->add_field($f);
	$f = new AreaField('kirjeldus(eng)', 'disc_eng');
	$form->add_field($f);
	$f = new AreaField('kirjeldus(rus)', 'disc_rus');
	$form->add_field($f);
	
	$f = new AreaField('lisa kirjeldus(est)', 'disc2_est');
	$form->add_field($f);
	$f = new AreaField('lisa kirjeldus(eng)', 'disc2_eng');
	$form->add_field($f);
	$f = new AreaField('lisa kirjeldus(rus)', 'disc2_rus');
	$form->add_field($f);

	$f = new Field('pileti link', 'ticket_link');
	$form->add_field($f);
}

sub process_row{
	my $this = shift;	
	my $array_ref = shift;
	my $id = shift @$array_ref; # remove id
	my $date = shift @$array_ref;
	#2005-11-23 22:45:00
	$date =~ s/^\d{4}-//;
	$date =~ s/:\d{2}$//;
	$date =~ s/^(\d{2})-(\d{2}) /$2.$1 /;
	
	unshift @$array_ref, $date;
	unshift @$array_ref, $this->_get_buttons($id); # make buttons of it and put it back
}

##############################################################################

package CinemaList;
@ISA = qw( List );

sub table_name{ return "cinema"; }
sub handler_name{ return "CinemaList"; }
sub rank {return 'rank';} 

sub add_fields{
	my $this = shift;
	my $form = shift;
	my $f;
	
	$f = new Field('nimi(est)', 'name_est');
	$form->add_field($f);
	
	$f = new Field('nimi(eng)', 'name_eng');
	$form->add_field($f);
	
	$f = new Field('nimi(rus)', 'name_rus');
	$form->add_field($f);
	
	$f = new AreaField('kirjeldus(est)', 'disc_est');
	$form->add_field($f);
	$f = new AreaField('kirjeldus(eng)', 'disc_eng');
	$form->add_field($f);
	$f = new AreaField('kirjeldus(rus)', 'disc_rus');
	$form->add_field($f);

	$f = new SelectField('linn', 'town_id');
	my $list = main::get_list_form_db('town');;
	$f->set_list($list);
	$form->add_field($f);
}

sub process_row{
	my $this = shift;	
	my $array_ref = shift;
	my $id = shift @$array_ref; # remove id
	my $pos;
	
	$pos = "f" if  (@$array_ref[4] eq "1"); # rank is at pos 5
	$pos .= "l" if  (@$array_ref[4] eq $this->_get_count());
	
	unshift @$array_ref, $this->_get_buttons($id,$pos); # make buttons of it and put it back
}

##############################################################################

##############################################################################

package MaillistList;
@ISA = qw( List );

sub table_name{ return "mail_list"; }
sub handler_name{ return "MaillistList"; }
sub rank {return ;} 

sub add_fields{
	my $this = shift;
	my $form = shift;
	my $f;
	
	$f = new Field('nimi', 'name');
	$form->add_field($f);
	
	$f = new Field('e-mail', 'mail');
	$form->add_field($f);
	
	$f = new Field('telefon', 'tel');
	$form->add_field($f);
	
	$f = new Field('elukutse', 'position');
	$form->add_field($f);
	$f = new Field('sugu', 'sex');
	$form->add_field($f);
	$f = new Field('sünniaasta', 'birthyear');
	$form->add_field($f);

	$f = new AreaField('haridus', 'education');
	$form->add_field($f);
}

sub process_row{
	my $this = shift;	
	my $array_ref = shift;
	my $id = shift @$array_ref; # remove id
	unshift @$array_ref, $this->_get_buttons($id); # make buttons of it and put it back
}

##############################################################################


package TownList;
@ISA = qw( List );

sub table_name{ return "town"; }
sub handler_name{ return "TownList"; }
sub rank {return 'rank';} 

sub add_fields{
	my $this = shift;
	my $form = shift;
	my $f;
	
	$f = new Field('nimi(est)', 'name_est');
	$form->add_field($f);
	
	$f = new Field('nimi(eng)', 'name_eng');
	$form->add_field($f);
	
	$f = new Field('nimi(rus)', 'name_rus');
	$form->add_field($f);

}

sub process_row{
	my $this = shift;	
	my $array_ref = shift;
	my $id = shift @$array_ref; # remove id
	my $pos;
	
	$pos = "f" if  (@$array_ref[3] eq "1"); # rank is at pos 5
	$pos .= "l" if  (@$array_ref[3] eq $this->_get_count());
	
	unshift @$array_ref, $this->_get_buttons($id,$pos); # make buttons of it and put it back
}

##############################################################################

package StateList;
@ISA = qw( List );

sub table_name{ return "state"; }
sub handler_name{ return "StateList"; }
sub rank{ return; }

sub add_fields{
	my $this = shift;
	my $form = shift;
	my $f;
	
	$f = new Field('nimetus(est)', 'name_est');
	$form->add_field($f);
	$f = new Field('nimetus(eng)', 'name_eng');
	$form->add_field($f);
	$f = new Field('nimetus(rus)', 'name_rus');
	$form->add_field($f);	
	$f = new Field('nimetus(orig)', 'name_ori');
	$form->add_field($f);	
}

sub process_row{
	my $this = shift;	
	my $array_ref = shift;
	my $id = shift @$array_ref; # remove id
	my $pos;
	
	$pos = "f" if  (@$array_ref[4] eq "1"); # rank is at pos 5
	$pos .= "l" if  (@$array_ref[4] eq $this->_get_count());
	
	unshift @$array_ref, $this->_get_buttons($id,$pos); # make buttons of it and put it back
}

##############################################################################

package DirectorList;
@ISA = qw( List );

sub table_name{ return "director"; }
sub handler_name{ return "DirectorList"; }
sub rank{ return; }

sub add_fields{
	my $this = shift;
	my $form = shift;
	my $f;
	
	$f = new Field('nimi(est)', 'name_est');
	$form->add_field($f);
	$f = new Field('nimi(eng)', 'name_eng');
	$form->add_field($f);
	$f = new Field('nimi(rus)', 'name_rus');
	$form->add_field($f);	
	$f = new AreaField('filmograafia(est)', 'filmo_est');
	$form->add_field($f);	
	$f = new AreaField('filmograafia(eng)', 'filmo_eng');
	$form->add_field($f);	
	$f = new AreaField('filmograafia(rus)', 'filmo_rus');
	$form->add_field($f);	
	$f = new AreaField('biograafia(est)', 'bio_est');
	$form->add_field($f);	
	$f = new AreaField('biograafia(eng)', 'bio_eng');
	$form->add_field($f);	
	$f = new AreaField('biograafia(rus)', 'bio_rus');
	$form->add_field($f);	

	$f = new FileField('pilt', 'upload_id');
	$f->set_pic(1);
	my $field_name = $f->get_fname();

	my $func = sub { # if we set some page to be frontpage then no other should be marked as fronpage
		my $value = shift;
		my $from_form = shift;
		if ($from_form and $main::Q->param($field_name)){ # executed only on form upload not when value is fetched form db
			my $file_name = main::upload( $field_name , 77777);
			if ($file_name){
				$main::DBH->do(qq~INSERT INTO upload (filename,catalog_id) VALUES ('$file_name','77777')~)  || die $main::DBH->errstr;
				my $inserted_id = $main::DBH->{'mysql_insertid'};
				$$value = $inserted_id;
			}
		}else{
			my $qs = qq~SELECT CONCAT(catalog_id,'/', filename) FROM upload WHERE upload_id='$$value'~;
			my $sth = $main::DBH->prepare($qs) || die $dbh->errstr;	
			$sth->execute() || die $sth->errstr;
			$$value = $sth->fetchrow_array();
		}
	};
	
	$f->set_set_value_trigger($func);
	$form->add_field($f);

}

sub process_row{
	my $this = shift;	
	my $array_ref = shift;
	my $id = shift @$array_ref; # remove id
	unshift @$array_ref, $this->_get_buttons($id); # make buttons of it and put it back
}
##############################################################################

package GaleryList;
@ISA = qw( List );

sub table_name{ return "galery"; }
sub handler_name{ return "GaleryList"; }
sub rank{ return; }

sub add_fields{
	my $this = shift;
	my $form = shift;
	my $f;
	
	$f = new Field('pealkiri(est)', 'title_est');
	$form->add_field($f);	
	$f = new Field('pealkiri(eng)', 'title_eng');
	$form->add_field($f);	
	$f = new Field('pealkiri(rus)', 'title_rus');
	$form->add_field($f);
	
	$f = new AreaField('kirjeldus(est)', 'disc_est');
	$form->add_field($f);	
	$f = new AreaField('kirjeldus(eng)', 'disc_eng');
	$form->add_field($f);	
	$f = new AreaField('kirjeldus(rus)', 'disc_rus');
	$form->add_field($f);

	$f = new FileField('pilt', 'upload_id');
	$f->set_pic(1);
	my $field_name = $f->get_fname();

	my $func = sub { # if we set some page to be frontpage then no other should be marked as fronpage
		my $value = shift;
		my $from_form = shift;
		if ($from_form and $main::Q->param($field_name)){ # executed only on form upload not when value is fetched form db
			my $file_name = main::upload( $field_name , 66666);
			if ($file_name){
				my $file_name = main::make_thumb($file_name);
				$main::DBH->do(qq~INSERT INTO upload (filename,catalog_id) VALUES ('$file_name','66666')~)  || die $main::DBH->errstr;
				my $inserted_id = $main::DBH->{'mysql_insertid'};
				$$value = $inserted_id;
			}
		}else{
			my $qs = qq~SELECT CONCAT(catalog_id,'/', filename) FROM upload WHERE upload_id='$$value'~;
			my $sth = $main::DBH->prepare($qs) || die $dbh->errstr;	
			$sth->execute() || die $sth->errstr;
			$$value = $sth->fetchrow_array();
		}
	};
	
	$f->set_set_value_trigger($func);
	$form->add_field($f);
}

sub process_row{
	my $this = shift;	
	my $array_ref = shift;
	my $id = shift @$array_ref; # remove id
	unshift @$array_ref, $this->_get_buttons($id); # make buttons of it and put it back
}


##############################################################################

package UserList;
@ISA = qw( List );

sub table_name{ return "user"; }
sub handler_name{ return "UserList"; }
sub rank{ return; }

sub add_fields{
	my $this = shift;
	my $form = shift;
	my $f;
	
	$f = new Field('kasutaja', 'username');
	$form->add_field($f);
	
	$f = new PassField('salasõna', 'password');
	my $field_name = $f->get_fname();

	my $func = sub {
		my $value = shift;
		my $from_form = shift;
		if ($from_form and $main::Q->param($field_name)){ # executed only on form upload not when value is fetched form db
			$$value = crypt $$value, 'salt';
		}else{
			$$value = "";
		}
	};

	$f->set_set_value_trigger($func);
	$form->add_field($f);
}

sub process_row{
	my $this = shift;	
	my $array_ref = shift;
	my $tree = shift;
	my $id = shift @$array_ref; # remove id
	
	unshift @$array_ref, $this->_get_buttons($id); # make buttons of it and put it back
}


##############################################################################

package ImageList;
@ISA = qw( List );

sub table_name{ return "catalog"; }
sub handler_name{ return "ImageList"; }
sub rank{ return; }

sub add_fields{
	my $this = shift;
	my $form = shift;
	my $f;
	
	$f = new Field('nimi', 'name');
	$form->add_field($f);

	$f = new HiddenField('', 'image');
	$f->set_value(1);
	$form->add_field($f);

	my $func = sub {
		my $value_ref = shift;
		my $from_form = shift;
		if ($from_form and $$value_ref eq '1'){ # need to be triggered only if active is set to 1
			$this->{dbh}->do(qq~UPDATE catalog SET active=0 WHERE image=1~)  || die $this->{dbh}->errstr;		
		}	
	};

	$f = new CheckField('aktiivne', 'active');
	$f->set_set_value_trigger($func);
	$form->add_field($f);

}

sub cmd_add{
	my $this = shift;
	my $inserted_id = $this->SUPER::cmd_add();
	&main::make_dir($inserted_id);
	return $inserted_id;
}

sub process_row{
	my $this = shift;	
	my $array_ref = shift;
	my $tree = shift;
	my $id = shift @$array_ref; # remove id
	
	my $name = shift @$array_ref; # remove name
	
	unshift @$array_ref,qq~<a href="upload/$id/" target=_blank>$name</a>~;
	
	unshift @$array_ref, $this->_get_buttons($id); # make buttons of it and put it back
}

sub _get_buttons{
	my $this = shift;
	my $id = shift;	
	my $retval;
	my $pos = shift;
	
	my $url = $this->add_base_path("todo=upload_page&id=$id$start");
	$url = "javascript:upload_win('$url')";
	if ($this->{buttons} =~ /u/){$retval.=$this->{tmpl}->get_tmpl('button_upload', $url);}
	$retval .= $this->SUPER::_get_buttons($id,$pos);
	return $retval;
}

##############################################################################

package BannerList;
@ISA = qw( List );

sub table_name{ return "banner"; }
sub handler_name{ return "BannerList"; }
sub rank{ return; }

sub cmd_delete{
	my $this = shift;
	my $id = shift;
	&main::del_banner($id);
	$this->SUPER::cmd_delete($id);
}

sub add_fields{
	my $this = shift;
	my $form = shift;
	my $f;

	$f = new FileField('banner', 'filename');
	$f->set_pic(1);
	$f->set_file(1);
	
	my $field_name = $f->get_fname();

	my $func = sub {
		my $value = shift;
		my $from_form = shift;
		if ($from_form and $main::Q->param($field_name)){ # executed only on form upload not when value is fetched form db
			my $file_name = main::upload( $field_name , 99999);
			if ($file_name){
				$$value = $file_name;
			}
		}else{
			my $qs = qq~SELECT catalog_id FROM banner WHERE filename='$$value'~;
			my $sth = $main::DBH->prepare($qs) || die $dbh->errstr;	
			$sth->execute() || die $sth->errstr;
			my $dir = $sth->fetchrow_array();
			$$value = "$dir/$$value";
		}
	};

	$f->set_set_value_trigger($func);
	$form->add_field($f);
	
	$f = new HiddenField('', 'catalog_id');
	$f->set_value(99999);
	$form->add_field($f);
	
	$f = new CheckField('suur', 'big');
	$form->add_field($f);
	my $big_field_name = $f->get_fname();

	my $func = sub { # if we set some banner to be active then no other (of same size) should be marked as active
		my $value_ref = shift;
		my $from_form = shift;
		if ($from_form and $$value_ref eq '1'){ # need to be triggered only if active is set to 1
			my $big_value = $this->{param}->param($big_field_name) + 0; # this makes closure of it
			$this->{dbh}->do(qq~UPDATE banner SET active=0 WHERE big=$big_value~)  || die $this->{dbh}->errstr;		
		}	
	};

	$f = new CheckField('aktiivne', 'active');
	$f->set_set_value_trigger($func);
	$form->add_field($f);

	$f = new CheckField('uus&nbsp;aken', 'new_win');
	$form->add_field($f);


	$f = new Field('kirjeldus', 'disc');
	$form->add_field($f);

	$f = new Field('url', 'url');
	$form->add_field($f);
}

sub process_row{
	my $this = shift;	
	my $array_ref = shift;
	my $tree = shift;
	my $id = shift @$array_ref; # remove id
	unshift @$array_ref, $this->_get_buttons($id); # make buttons of it and put it back
}

##############################################################################

package FileList;
@ISA = qw( List );

sub table_name{ return "catalog"; }
sub handler_name{ return "FileList"; }
sub rank{ return; }

sub add_fields{
	my $this = shift;
	my $form = shift;
	my $f;
	
	$f = new Field('nimi', 'name');
	$form->add_field($f);
	$f = new HiddenField('', 'image');
	$f->set_value(0);
	$form->add_field($f);
}

sub cmd_add{
	my $this = shift;
	my $inserted_id = $this->SUPER::cmd_add();
	&main::make_dir($inserted_id);
	return $inserted_id;
}

sub process_row{
	my $this = shift;
	my $array_ref = shift;
	my $tree = shift;
	my $id = shift @$array_ref; # remove id
	
	my $name = shift @$array_ref; # remove name
	unshift @$array_ref,qq~<a href="upload/$id/" target=_blank>$name</a>~;
	unshift @$array_ref, $this->_get_buttons($id); # make buttons of it and put it back
}

sub _get_buttons{
	my $this = shift;
	my $id = shift;	
	my $retval;
	my $pos = shift;
	
	my $url = $this->add_base_path("todo=upload_page&id=$id$start");
	$url = "javascript:upload_win('$url')";
	if ($this->{buttons} =~ /u/){$retval.=$this->{tmpl}->get_tmpl('button_upload', $url);}
	$retval .= $this->SUPER::_get_buttons($id,$pos);
	return $retval;
}

##############################################################################

package ProgramList;
@ISA = qw( List );

sub table_name{ return "program"; }
sub handler_name{ return "ProgramList"; }
sub rank{ return "rank"; }

sub add_fields{
	my $this = shift;
	my $form = shift;
	my $f;
	
	$f = new Field('nimi(est)', 'name_est');
	$form->add_field($f);
	$f = new Field('nimi(eng)', 'name_eng');
	$form->add_field($f);
	$f = new Field('nimi(rus)', 'name_rus');
	$form->add_field($f);	
	$f = new AreaField('kirjeldus(est)', 'disc_est');
	$form->add_field($f);	
	$f = new AreaField('kirjeldus(eng)', 'disc_eng');
	$form->add_field($f);	
	$f = new AreaField('kirjeldus(rus)', 'disc_rus');
	$form->add_field($f);	

	$f = new SelectField('vanem', 'parent_id');
	$f->set_read_only(1);
	my $list = $this->_make_menu_list($this->{param}->param('id'));
	$f->set_list($list);
	$form->add_field($f);
}

sub _make_menu_list{ # makes array of arrays (id, padded name) for listbox
							# for selecting parent
	my $this = shift;
	my $current_id = shift;
	
	my $values;
	
	my $sth = $this->{query}->fetch_query(0); # member query object makes db call and returns db handle
															# startrow is allways 0 - we don't page tree	
	my $tree = new Tree1; # make tree of all rows
	while (my @values = $sth->fetchrow_array()){ 
		$tree->add_node($values[0],$values[7],\@values); # id, parent_id, whole thing
	}
	
	my @ids = @{$tree->get_ordered_ids({no_descendants=>$current_id})}; # ids in new order

	while (@ids){
		my $id = shift @ids;
		my $row = $tree->get_value($id); # get values of current id
		my @slice = @$row[0,1]; # id , name
		$this->_add_padding(\@slice[1],$tree->get_level($id)); # add padding to name(\@slice[1]) according to level
		push @$values, \@slice;
	}
	unshift @$values, [(0,'')]; # root level parent
	return $values;
}

sub as_html{
	my $this = shift;
	my $retval;	
	
	$retval .= $this->{tmpl}->get_tmpl('title_row', @{$this->{titles}} ); # add title row
	my $sth = $this->{query}->fetch_query(0); # member query object makes db call and returns db handle
															# startrow is allways 0 - we don't page tree	
	my $tree = new Tree1; # make tree of all rows
	while (my @values = $sth->fetchrow_array()){ 
		$tree->add_node($values[0],$values[7],\@values); # id, parent_id, whole thing
	}
	
	my @ids = @{$tree->get_ordered_ids()}; # ids in new order
	my $count=1; my $template;

	while (@ids){
		my $id = shift @ids;
		my $values = $tree->get_value($id); # pop values of current id
		
		$this->process_row($values,$tree); # subclasses make links on them and such
		
		$this->_add_padding(\@$values[1],$tree->get_level($id)); # add padding according to level
		
		if ($count++ % 2){ $template = 'odd_row'	}else{ $template = 'even_row' }
		$retval .= $this->{tmpl}->get_tmpl($template, @$values );
	}
	$retval .= $this->_make_footer();	# add footer
	
	$retval = $this->{tmpl}->get_tmpl('list_table', $retval , $this->new_link(), $this->_make_title_string);
	return $retval;
}

sub process_row{
	my $this = shift;	
	my $array_ref = shift;
	my $tree = shift;
	my $id = shift @$array_ref; # remove id
	my $pos;
	
	$pos = "f" if  ($tree->is_first($id));
	$pos .= "l" if  ($tree->is_last($id));
		
	unshift @$array_ref, $this->_get_buttons($id,$pos); # make buttons of it and put it back
}

##############################################################################

package NewsList;
@ISA = qw( List );

sub table_name{ return "anima_news_2006"; }
sub handler_name{ return "NewsList"; }

sub add_fields{
	my $this = shift;
	my $form = shift;
	my $f;
	
	$f = new Field('pealkiri', 'title');
	$form->add_field($f);
	
	$f = new HiddenField('', 'date');
	$f->set_value(main::to_mysql_date(time())); # initalize to current time. will be overwritten later
	$form->add_field($f);
	
	$f = new HiddenField('', 'year');
	$f->set_value('2007'); # year is meant for showing only this year's news on front page
	$form->add_field($f);
	
	$f = new AreaField('tekst', 'text');
	$form->add_field($f);

	$f = new HiddenField('', 'lang_id');
	$f->set_value($main::LANG);
	$form->add_field($f);
}

sub process_row{
	my $this = shift;	
	my $array_ref = shift;
	my $tree = shift;
	my $id = shift @$array_ref; # remove id
	my $date = shift @$array_ref; # remove date
	
	$date =~ s/(\d{4})-(\d{2})-(\d{2})[\d: ]{9}/$3.$2.$1/;	
	unshift @$array_ref,$date;
	unshift @$array_ref, $this->_get_buttons($id); # make buttons of it and put it back
}


1;