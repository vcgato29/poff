<?php

include("inc/tmpl.inc");
include("inc/funcs.inc");
include("inc/dblayer.php");
header("Content-type: text/html; charset=utf-8");

global $T; $T = new Template('inc/menu.tmpls');

#show_input();
get_content();

function get_news($id=0){
	$id += 0; # called with ''
	$SQL = new FC_SQL;
	$t = new Template("inc/news.tmpls");

	if (in('l') == 'eng') {$rest = 'where lang_id = 2'; }else $rest = 'where lang_id = 1';

	$qs = "SELECT title, text FROM anima_news_2006 $rest AND anima_news_2006_id=$id";
	$SQL->query($qs);

	$SQL->next_record();

	$list = get_news_list();
	return $t->get('news_content', array($SQL->f(0),$SQL->f(1),$list));
}

function get_news_list($front=0,$abbr=0) {

	$SQL = new FC_SQL;
	$t = new Template("inc/news.tmpls");

	if (in('l') == 'eng') {$rest = 'where lang_id = 2'; }else $rest = 'where lang_id = 1';

	if ($front) {
		$limit = 'LIMIT 6';
	}

	#$rest .= ' and year = \'2008\' '; // frontpage shows news only for the current year
	$rest .= ' and date > \'2009-01-01\' ';


	$qs = "SELECT anima_news_2006_id, date, title, text FROM anima_news_2006 $rest ORDER BY anima_news_2006_id DESC $limit";
	$SQL->query($qs);

	while($SQL->next_record()){
		$content .= make_news_abbr($SQL->f(0),$SQL->f(1),$SQL->f(2),$SQL->f(3),$abbr);
	}

	return $content;
}

function format_date($mysql_date) {
	// $content = '2008-07-03 18:02:40';
	preg_match("/(\d{4})-(\d{2})-(\d{2}).{9}/", $mysql_date, $matches, PREG_OFFSET_CAPTURE);
	// 03.07.2008
	return $matches[3][0] .'.'. $matches[2][0] .'.'. $matches[1][0];
}

function make_news_abbr($id,$date,$title,$c,$abbr){
	$date = format_date($date);
	$title = "$date<b> $title</b>";
	if ($abbr) $title .= "<br><br>";

	if ($abbr){
		$content = substr($c, 0, 140);
		preg_match("/(.*) /", $content, $matches, PREG_OFFSET_CAPTURE);
		$content = $matches[0][0];
		$content = preg_replace("/ $/", "", $content);
		$content = preg_replace("/,$/", "", $content);
		$content = preg_replace("/:$/", "", $content);
		$link = "...";
	}

	$link_name = "loe edasi";
	if (in('l') == 'eng') {
		$link_name = "read on";
		$lang = "&l=eng";
	}
	$link .= " <a href=\"?p=news&id=$id$lang\">$link_name &raquo;</a><br><br>";

	return $title.$content.$link;
}

function get_dyn_content($id) {
	$SQL = new FC_SQL;
	$qs = "SELECT content FROM anima09_page p
				LEFT JOIN anima09_page_content c 
					ON p.anima09_page_id = c.anima09_page_id
	 			WHERE p.anima09_page_id = $id";
	$SQL->query($qs);
	$SQL->next_record();

	return $SQL->f(0);
}

function get_content() {
	global $content;
	$file = 'pages/' . in('p');

	if ($id = in('dyn')) {
		$content = get_dyn_content($id);
		return;	
	}

	if (in('l')=='eng') $file .= '_e';
	$file .= '.html';

	if (in('p')=='news'){
		$content = get_news(in('id')); return;
	}

	if (! in('p')){
		$t = new Template("inc/news.tmpls");
		$c = get_news_list(1,0); // avalehele kolm uudist koos kstga
		if (in('l') == 'eng') {$tmpl = 'news_e'; }else $tmpl = 'news';;
		$content = $t->get($tmpl, array($c));
		return;
	}


	if (file_exists($file)){
		$content = implode ("\n", file ($file));
		list ($savi, $content, $savi) = split ("<delimiter>", $content);
	}else{
		if (in('l')=='eng') $content = 'Coming soon...'; else  $content = 'Valmimas...';
	}

}

if (in('l')=='eng'){
	$links_names1 = array('history','regulations',' ticket&nbsp;sales','friends','contact');
	$links_names2 = array('COMPETITION PROGRAMME','SPECIAL PROGRAMMES');
	$links1 = array('?b=1&dyn=33&l=eng','?b=1&dyn=34&l=eng','?b=1&dyn=35&l=eng','?b=1&l=eng&dyn=36','?b=1&dyn=37&l=eng');
	$links3 = array('?b=6&dyn=62&l=eng','?b=6&dyn=63&l=eng','?b=6&dyn=64&l=eng','?b=6&dyn=65&l=eng','?b=6&dyn=66&l=eng','?b=6&dyn=79&l=eng');
	$links2 = array('?b=2&p=prog_comp&l=eng','?b=2&p=prog_comp&l=eng');
	// $links2 = array('javascript://','javascript://');

}else{
	$links_names1 = array('ajalugu','reeglid','piletim&uuml;&uuml;k','s&otilde;brad', 'kontakt');
	$links_names2 = array('V&Otilde;ISTLUSPROGRAMM','ERIPROGRAMMID');
	$links1 = array('?b=1&dyn=16','?b=1&dyn=17','?b=1&dyn=18','?b=1&dyn=19','?b=1&dyn=20');
	$links3 = array('?b=6&dyn=21','?b=6&dyn=22','?b=6&dyn=23','?b=6&dyn=24','?b=6&dyn=25','?b=6&dyn=78');
	//$links2 = array('javascript://','javascript://');
	$links2 = array('?b=2&p=prog_comp','?b=2&p=prog_comp');
}

	$over = array('clearInterval(document.inter);show(4,1)','clearInterval(document.inter);show(3,1)');
	#$over = array('','clearInterval(document.inter);show(3,1)');
	$links_names3 = array('2003','2004','2005','2006','2007','2008');


$sm1 =  make_submenu($links_names1,$links1,0,'s2',30);
$sm1 .=  make_submenu($links_names2,$links2,1,'s3',90,$over,$out);
$sm1 .=  make_submenu($links_names3,$links3,2,'s4',579);


#print "<plaintext>";
$progs_menu = make_progs_menu();
$comp_progs_menu = make_comp_progs_menu();

#print $progs_menu;
#exit;


function make_submenu($names,$links,$c,$prefix,$w,$over=array(),$out=array()){
	global $T;
	global $CELL_IDS;

	for ($a=0; $a<count($names);$a++){
		$CELL_IDS[] = '"'.$prefix.$a.'"';
		if ($a) $cells .= $T->get('sub_menu_cell_separator', array());
		$tpl = _is_archive_link($links[$a]) ? 'sub_menu_cell_nw' : 'sub_menu_cell';
		$cells .= $T->get('sub_menu_cell', array($prefix.$a,$names[$a],$links[$a],$over[$a],$out[$a]));
	}
	return $T->get('sub_menu',array($c,$w,$cells));
}

function _is_archive_link($link) {
	return (preg_match("/p=a_\\d{4}/", $link));
}

function add_lang($str) {
	return eng() ? "$str&l=eng" : "$str";	
}

function eng() {
	return (in('l') == 'eng');
}

function make_progs_menu(){
	
	if (eng()){
		$rows = array(
			array(0, 39, 'OPENING SCREENING: THE BUG TRAINER',40,'BEST OF INTERNATIONAL STUDENT ANIMATION I'),
			array(15, 41, 'BEST OF INTERNATIONAL STUDENT ANIMATION II', 42, 'NEW AND FANCY ESTONIAN ANIMATION!'),
			array(150, 43, 'NEW ESTONIAN STUDENT ANIMATION AND MUSIC VIDEOS'),
			array(110, 44, 'FOCUS ON CONTEMPORARY TURKISH ANIMATION', 45, 'KAFKA IN ANIMATION'),
			array(0, 46, 'GIANLUIGI TOCCAFONDO&rsquo;S RETROSPECTIVE',47, 'ANIMATED DOCUMENTARY: THE KINGS OF TIME'),
			array(30, 48, 'ANIMATED FEATURE: JOURNEY TO SATURN', 49, 'ANIMATED FEATURE: IDIOTS AND ANGELS')
			);
	}else{
		$rows = array(
			array(0, 51, 'AVASEANSS: PUTUKATREENER',52,'RAHVUSVAHELISE TUDENGIANIMA PAREMIK I'),
			array(30, 53, 'RAHVUSVAHELISE TUDENGIANIMA PAREMIK II', 54, 'UUS JA UHKE EESTI ANIMA!'),
			array(70, 55, 'UUS EESTI TUDENGIANIMA JA MUUSIKAVIDEOD'),
			array(10, 56, 'KAASAEGNE T&Uuml;RGI ANIMATSIOON FOOKUSES', 57, 'KAFKA ANIMATSIOONIS'),
			array(100, 58, 'GIANLUIGI TOCCAFONDO RETROSPEKTIIV',59, 'ANIMEERITUD DOKUMENTAALFILM: AJA MEISTRID'),
			array(0, 60, 'T&Auml;ISPIKK ANIMAFILM: REIS SATURNILE', 61, 'T&Auml;ISPIKK ANIMAFILM: IDIOODID JA INGLID')
			);
	}

	global $T;
	global $CELL_IDS;

	foreach ($rows as $each) {
		$indentation = array_shift($each);
		$tds = '';
		while (count($each)) {
			break; // TODO enable disable special programme
			$id = array_shift($each);
			$ident = 's5' . $id;
			$CELL_IDS[] = '"'. $ident .'"';
			$name = array_shift($each);
			$link = add_lang("?b=2&dyn=$id");
			$tds .= $T->get('sub_menu_cell', array($ident, $name, $link));
			if (count($each)) $tds .= $T->get('sub_menu_cell_separator');
		}
		
		$pre = "<td width=\"$indentation\"></td>";
		$trs .= '<table height="25" style="top: 235px; position: relative; margin-bottom:1px" border=0 cellspacing=0 cellpadding=0><tr>'.$pre.$tds."</tr></table>\n";
		$tds = '';
	}
	
	return $T->get('special_programm', array($trs));
}

function make_comp_progs_menu(){
	if (eng()){
		$links_names5 = array('COMPETITION PROGRAMME I','COMPETITION PROGRAMME II','COMPETITION PROGRAMME III','COMPETITION PROGRAMME IV');
		$ids = array(69,70,71,72);
	} else {
		$links_names5 = array('V&Otilde;ISTLUSPROGRAMM I','V&Otilde;ISTLUSPROGRAMM II','V&Otilde;ISTLUSPROGRAMM III','V&Otilde;ISTLUSPROGRAMM IV');
		$ids = array(74,75,76,77);
	}

	$links = array();
	foreach ($ids as $id) {
		$lang = (eng()) ? "&l=eng" : "";
		array_push($links, "?b=2&dyn=$id$lang");
	}

	global $T;
	global $CELL_IDS;
	$widths = array(0,200,40);

	$count = 1;
	while ($item = array_shift($links_names5)){
		break; // TODO - to enable/disable programs
		
		if ($count != 1 and $count != 4 and $count != 7) $cells .= $T->get('sub_menu_cell_separator', array());
		$id = 's6'; $id .= $count-1;
		$CELL_IDS[] = '"'.$id.'"';

		$cells .= $T->get('sub_menu_cell', array($id,$item,$links[$count-1]));
		if (!($count % 3)){
			$pre = '<td width="'.array_shift($widths).'">&nbsp;</td>';
			$rows .= '<table height="25" style="top: 235px; position: relative;margin-bottom:1px" border=0 cellspacing=0 cellpadding=0><tr>'.$pre.$cells."</tr></table>\n";
			$cells = '';
		}
		$count++;
	}
	$pre = '<td width="'.array_shift($widths).'">&nbsp;</td>';
	$rows .= '<table height="25" style="top: 235px; position: relative" border=0 cellspacing=0 cellpadding=0><tr>'.$pre.$cells."</tr></table>\n";
	return $T->get('comp_programm', array($rows));
}

?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<SCRIPT src="js/main.js" type=text/javascript></SCRIPT>
<link rel="stylesheet" href="css/styles_main.css" type="text/css">
<script language="JavaScript">
<!--
<!--
function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);


document.rowNames = new Array("row_0","row_1","row_2","row_3","row_4");
document.rowObjects = new Array();
document.subLinkObjects = new Array();
document.subLinkNames = new Array('s10','s11','s12','s13','s14','s15','s16',<?php  print implode(',',$CELL_IDS )?>);
document.inter;

function init(){

	rowNames = document.rowNames;
	rowObjects = document.rowObjects;
	subLinkObjects = document.subLinkObjects;
	subLinkNames = document.subLinkNames;

	for(i=0; i<rowNames.length; i++){
		identity = document.getElementById(rowNames[i]);
		document.rowObjects[i] = identity;
	}

	for(i=0; i<subLinkNames.length; i++){
		identity = document.getElementById(subLinkNames[i]);
		document.subLinkObjects[i] = identity;
	}

	identity = document.getElementById('mm');
	identity.style.display = '';
}

function show(num,num2){

	rowObjects = document.rowObjects;
	for(i=0; i<rowObjects.length; i++){
		if (num2 != undefined && i==num2){

		}else{
			rowObjects[i].style.display = 'none';
		}
	}

	rowObjects[num].style.display = '';
	clearInterval(document.inter);
}

function cS(num,s){
	o = document.subLinkObjects;
	n = document.subLinkNames;

	for(i=0; i<n.length; i++){
		if (n[i] == num){
			o[i].className=s;
		}
	}
}

function setHideInt(num,num2){
	eval ("document.inter = setInterval('hide(" + num + ',' +num2+ ")',200)");
}

function hide(num,num2){
	document.rowObjects[num].style.display = 'none';

	if (num2 != undefined) {
		document.rowObjects[num2].style.display = 'none';
	}

	clearInterval(document.inter);
}

// -->

function blink (elId) {
  var html = '';
  if (document.all)
    html += 'var el = document.all.' + elId + ';';
  else if (document.getElementById)
    html += 'var el = document.getElementById("' + elId + '");';
  html += 
    'el.style.visibility = ' + 
    'el.style.visibility == "hidden" ? "visible" : "hidden"';
  if (document.all || document.getElementById)
    setInterval(html, 500)
}
function initBlink () {
  blink('aText');
  blink('a2ndText');
}

function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}
//-->
</script>

<?php

function header_img() {
	// return '09_temp_header.jpg';
	$b = in('b') + 0; 
	$b = 0;
	$b = 'b'. $b;
	if (in('l')=='eng') $b .= 'e';
	return $b . '.png';
}

?>


<style type="text/css">
<!--
.tegelane {  background-image: url(img/<?php print header_img() ?>); background-repeat: no-repeat;}
-->
</style>
</head>

<body bgcolor="#FFFFFF" text="#000000" topmargin="0" background="img/bg.png" onLoad="init();">
<table width="100%" border="0" cellspacing="0" cellpadding="0" height="100%">
	<tr>
		<td height="5"></td>
	</tr>
	<tr>
		<td align="center" valign="top">
			<table width="100" border="0" cellspacing="0" cellpadding="1" bgcolor="000" height="100%">
				<tr>
					<td>
						<table width="100%" border="0" cellspacing="0" cellpadding="5" height="100%">
							<tr>
								<td bgcolor="ffffff" valign="top">
									<table width="748" border="0" class="" cellspacing="0" cellpadding="0" height="100%">
										<tr>
											<td height="212" valign="top" class="tegelane">
												<div style="position:absolute">
												<table width="749" border="0" cellspacing="0" cellpadding="0" style="top: 235px; position: relative">
													<?php print $sm1 ?>
													<tr>
														<td height=0 valign="top"></td>
													</tr>
												</table>
												<?php print $progs_menu; print $comp_progs_menu ?>
											</div>
											</td>
										</tr>
										<tr>
											<td bgcolor="#eed119" height="24" valign="top">
												<?php if (in('l')=='eng'){include "inc/menu_e.inc"; }
															else {include "inc/menu.inc";} ?>
											</td>
										</tr>
										<tr>
											<td height="15"></td>
										</tr>
										<tr>
											<td style="padding-left:20;padding-right:20;padding-top:4" class=content valign="top">
												<?php print $content ?>
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td align="center" valign="top" height="5"></td>
	</tr>
</table>

<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
try {
var pageTracker = _gat._getTracker("UA-8361561-2");
pageTracker._trackPageview();
} catch(err) {}</script>
<div style="display: none">prg. mart kalmo</div>
</body>
</html>
