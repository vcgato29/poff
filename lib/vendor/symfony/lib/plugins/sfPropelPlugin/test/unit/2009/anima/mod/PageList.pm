package PageList;
use strict;
use warnings;
use Data::Dumper;
use List;
use funcs;
@PageList::ISA = qw(List);

sub handle_params {
	my $this = shift;

	if ($this->_get_list_cmd() eq 'save_page'){
		$this->_cmd_save_page();
		$this->{out} = $this->as_html();
		return;
	}
	elsif ($this->_get_list_cmd() eq 'edit_page'){
		$this->_cmd_edit_page();
		return;
	}

	$this->SUPER::handle_params();
}

sub _cmd_save_page {
	my $this = shift;
	my $id = $this->{g}->param('id');
	my $content = $this->{g}->param('editorContent');
	my $qs = sprintf "update %s_content set content = ? where %s_id = ?",
								$this->{table_name}, $this->{table_name};
	
	$this->{g}->execute($qs, $content, $id);
}


sub _cmd_edit_page {
	my $this = shift;
	my $id = $this->{g}->param('id');

	my $qs = pref 'select content from %ppage_content where %ppage_id = ?';
	my $sth = $this->{g}->execute($qs, $id);
	
	my $h_ref = {};
	$h_ref->{'content'} = $sth->fetchrow_array() || '';
	$h_ref->{'id'} = $id;
	$h_ref->{'hiddens'} = $this->_make_hiddens();
	
	$h_ref->{'config_url'} = $this->{g}->conf('fck_conf');
	$h_ref->{'cancel_url'} = $this->_add_base_path('ListCmd=cancel');
	
#	my $sctipt = $this->{g}->conf('script');
#	$h_ref->{'config_url'} = $this->_add_base_path(
#		$this->{g}->conf('fck_conf')."?", {remove=>['handler']});
#	$h_ref->{'cancel_url'} = $this->_add_base_path('ListCmd=cancel');
	
	$this->{g}->add_conf_entries($h_ref);
	
	print $this->{g}->tmpl('editor.html', $h_ref);
	exit;
}

sub _cmd_delete {
	my $this = shift;
	my $id = shift;
	$this->SUPER::_cmd_delete($id);
	# clear cache after db change
	undef $this->{out};
	$this->{g}->remove('menu_tree');
}

sub _cmd_add {
	my $this = shift;
	my $inserted_id = $this->SUPER::_cmd_add();
	$this->{query}->new_page($inserted_id);
   # clear cache after db change
	$this->{g}->remove('menu_tree');
	undef $this->{out};
	return $inserted_id;
}

sub process_row {
	my $this = shift;
	my $h_ref = shift;
	my $id = $h_ref->{id};
	my $name = $h_ref->{name};
	
	$this->SUPER::process_row($h_ref);
	
#	my $url = $this->{g}->ustate("id=$id");
#	my $link = qq~<a href="$url">$name</a>~;
	$name = sprintf('&nbsp;&nbsp;&nbsp;' x $h_ref->{level} ) . $name;
#	
#	if ($h_ref->{frontpage}) {
#		$name = '<span class="linkBlue">' . $name . '</span>';
#	} elsif ($h_ref->{hidden}) {
#		$name = '<span class="linkGray">' . $name . '</span>';
#	}
#	
	$h_ref->{name} = $name;
}

1;