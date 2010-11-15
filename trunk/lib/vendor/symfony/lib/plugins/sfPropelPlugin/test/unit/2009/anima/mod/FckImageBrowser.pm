package FckImageBrowser;
use strict;
use warnings;
use FileManager;
use Data::Dumper;
use Mrt::Carrier;
use Mrt::Iterator;

@FckImageBrowser::ISA = qw(Mrt::Carrier);

sub new {
	my $classname = shift;
	my $this  = {};
	bless($this, $classname);
   
	$this->{g} = shift;
	
	return $this;
}

sub handle_params {
	my $this = shift;
	my $cmd = $this->{g}->param('todo');
	
	my $fm = $this->_get_filemanager();
	if ($cmd eq 'uploadImage') {
		$fm->upload('uploadImage', $this->{g}->param('cat_select'));
	}
	if ($cmd eq 'del_img') {
		$fm->delete_file($this->{g}->param('cat_select'), $this->{g}->param('name'));
	}
	if ($cmd eq 'del_folder') {
		my $name = $this->{g}->param('name');
		return if ($name eq '.'); # don't delete root|default dir
		$fm->rename_file('.', $name, '.' . scalar time . $name); # myDir -> .1185023589myDir
	}
	if ($cmd eq 'new_folder') {
		my $new_name = $fm->new_folder('.', $this->{g}->param('name'));
		my $url = $this->_add_base_path("cat_select=$new_name");
		print "<script>window.location='$url';</script>";
		exit;
	}
	if ($cmd eq 'quick_upload') {
		my $dir = '.';
		my $file_name = $fm->upload('NewFile', $dir);
		my $url = $this->{g}->conf('upload_url'). '/images/' . $dir . '/' . $file_name;
		print qq~<script>window.parent.SetUrl('$url');</script>~;
		exit;
	}

}

sub _get_filemanager {
	my $this = shift;
	my $root_path = $this->{g}->conf('upload_dir'). '/images';
	return new FileManager($this->{g}, $root_path);
}

sub as_html {
	my $this = shift;
	my $file = shift;
	
	my $h_ref = {};
	my $selected_cat = $this->{g}->param('cat_select') || '.';
	my @files = $this->_get_filemanager()->get_file_list($selected_cat);

	$h_ref->{image_table} = $this->_make_images_table(\@files, $selected_cat);
	
	$h_ref->{new_folder_url} = $this->_add_base_path("todo=new_folder");
	$h_ref->{del_folder_url} = $this->_add_base_path("todo=del_folder&name=$selected_cat");
	
	
	my @catalogs = grep { m/^[^.]/ } $this->_get_filemanager()->get_folder_list();
	$h_ref->{cat_select} = $this->_make_catalog_select(\@catalogs, $selected_cat);
	
	$h_ref->{hiddens} = $this->_make_hiddens();
	
	print $this->{g}->tmpl('browse_image.html', $h_ref);
	exit;
}

sub _get_default_catalog_id {
	my $this = shift;
	my $catalogs_ref = shift;
	for my $key (keys %$catalogs_ref) {
		return $catalogs_ref->{$key}->[0] if ($catalogs_ref->{$key}->[2] eq 1);
	}
	
	return '';
}

sub _get_catalog_id_list {
	my $this = shift;
	my $catalogs_ref = shift;
	return join ", ", map {'"' . $_ . '"' } keys %$catalogs_ref;
}

sub _make_images_table {
	my $this = shift;
	my $a_ref = shift;
	my $current_cat = shift;
	
	my $rows = ''; my $cnt = 0;
	for my $file_name (@$a_ref) {
		my $image_url = $this->{g}->conf('upload_url') . "/images/$current_cat/" . $file_name;
		my $del_url = $this->_add_base_path("todo=del_img&cat_select=$current_cat&name=$file_name");
		my $del_button = $this->{g}->tmpl('fck.del_image_link', {url=>$del_url});
		my $image_link = $this->{g}->tmpl('fck.select_image_link', {image_url=>$image_url, filename=>$file_name});
		my $style = ($cnt++ % 2 == 0) ? 'evenListRow' : 'oddListRow';
		$rows .= $this->{g}->tmpl('fck.image_trtd', {link=>$image_link, del_button=>$del_button, style=>$style});
	}
	
	return $this->{g}->tmpl('fck.table', {rows=>$rows});
}

sub _make_catalog_select {
	my $this = shift;
	my $a_ref = shift;
	my $selected_cat = shift;

	my $opts = '<option value=".">default</option>';
	foreach my $cat_name (@$a_ref) {
		my $sel_prop = ($selected_cat eq $cat_name) ? "selected='1'" : '';
		$opts .= qq~<option value="$cat_name" $sel_prop>$cat_name</option>\n~
	}
	return qq~<select name="cat_select" onChange="this.form.todo.value='change_cat'; this.form.submit();">$opts</select>~;
}

1;