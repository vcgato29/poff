use strict;
use warnings;
use Date::EzDate;
use DateFuncs;
our $G;

sub add_news_fields {
	my $form = shift;
	my $f;
	
	$f = new Field('pealkiri', 'title');
	$form->add_field($f);
	
	my $date = DateFuncs::to_date_obj(time());
	$f = new HiddenField('', 'date');
	$f->set_value(DateFuncs::to_mysql_date($date)); # initalize to current time. will be overwritten later
	$form->add_field($f);
	
	$f = new HiddenField('', 'year');
	$f->set_value('2009'); # year is meant for showing only this year's news on front page
	$form->add_field($f);
	
	$f = new WysiwygField('tekst', 'text');
	$form->add_field($f);

	$f = new HiddenField('', 'lang_id');
	$f->set_value($G->param('lang'));
	$form->add_field($f);
}

sub add_page_fields {
	my $form = shift;
	my ($f, $list); 
	
	$f = Field->new('nimi', 'name');
	$form->add_field($f);
	my $func = sub {
		my $h_ref = shift;	
		if ($h_ref->{command} eq 'add') {
			return unless $G->param('_parent_id'); # we want NULL instead of 0
			$G->execute(pref 'update %ppage set parent_id = ? 
							 where %ppage_id = ?',
				$G->param('_parent_id'), $h_ref->{id});
		} elsif ($h_ref->{command} eq 'update') {
			my $q = PageQuery->new(pref '%ppage', $G);
			$q->set_new_parent($G->param('id'), $G->param('_parent_id'));		
		}
	};

	$f = SelectField->new('vanem', 'parent_id');
	$f->dont_save();
	$list = _make_menu_list($G->param('id'));
	$f->set_list($list);
	$form->add_field($f);
	$form->set_on_submit($func);
	
	$f = new HiddenField('', 'lang_id');
	$f->set_value(lang());
	$form->add_field($f);
}

sub _add_padding {
	my $ref = shift;
	my $level = shift;
	$$ref = "&nbsp;&nbsp;&nbsp;" x $level . $$ref
}

1