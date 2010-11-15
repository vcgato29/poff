function newWinFs(url, props) { //v2.0
		var w = screen.width - 7;
		var h = screen.height - 60;
		props = 'width='+w+',height='+h +',' +props;
		aa = window.open( url ,'',props);
		aa.moveTo(0, 0);
}

function new_win(url, w,h , props) { //v2.0
		props = 'width='+w+',height='+h +',' +props;
		aa = window.open( url ,'',props);
	//	aa.moveTo(screen.width/2-200,screen.height/2-150);
}

function display_menu(){
	i=document.getElementById('main_menu');
   i.style.display = '';
}

function goTo(url){
	document.location.href=url;
}

function confirm_and_go(msg, url) {
	var flag = confirm(msg);
	if (flag == true) {
		document.location=url
	}
}

function upload_win(theURL,winName,features) { //v2.0
	var props = 'width='+400+',height='+120;
	aa = window.open(theURL,'aaa',props);
	//aa.moveTo(screen.width/2-200,screen.height/2-150);
}

function set_letter(letter) { //v2.0
	document.film_search_form.film_search_letter.value=letter;
	document.film_search_form.film_count.value = '';
	document.film_search_form.film_start.value = '';
	document.film_search_form.submit();
}

function set_film_start(start,count) { //v2.0
	document.film_search_form.film_start.value=start;
	document.film_search_form.film_count.value=count;
	document.film_search_form.submit();
}

function calc_addition (field_name, val){
	var old_val;	
	var new_val;
	old_val = eval ('document.forms[1].' + field_name + '_old.value');
	val = parseInt(val);
	old_val = parseInt(old_val);
	new_val = old_val + val;
	new_val = ".value='" + new_val + "'";
	eval ('document.forms[1].' + field_name + new_val );
	return;
}