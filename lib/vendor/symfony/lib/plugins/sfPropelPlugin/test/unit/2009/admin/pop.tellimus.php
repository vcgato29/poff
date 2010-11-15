<?php
/**
 * Rakendus: sisu pop, edasimuujad
 *
 * struktuuriühikute lisamise, kustutamise ning muutmise
 * navigeerimine
 * @package CMS_PAGE
 * @subpackage admin
 */
//ini_set('display_errors','1');
  require_once("../cfg/admin/pre.inc");
  require_once(CONFIG_DIR . "lang.inc");
  require_once(CONFIG_DIR . "access.inc");
  require_once(MODULE_DIR . "access/class.IPAccess.inc");
  require_once(INIT_DIR . "env.inc");
  require_once(INIT_DIR . "db.inc");
  require_once(MODULE_DIR . "user/mod.user.inc");
  require_once(INIT_DIR . "smarty.inc");
  require_once(MODULE_DIR . "structure/mod.structure.inc");
  require_once(MODULE_DIR . "user/mod.usergroup.inc");
  require_once(MODULE_DIR . "statistics/mod.query.inc");
  require_once(MODULE_DIR . "ind_functions.inc");
  include_once(MODULE_DIR . "tellimus.inc");

  if (!$objIPAccess->fnValidate($arrAllowIP["access"], $_SERVER["REMOTE_ADDR"]) or $objIPAccess->fnValidate($arrAllowIP["deny"], $_SERVER["REMOTE_ADDR"])) {
    header("Location: " . LOGINCENTER_PATH);
  }


  if (!is_object($_SESSION["user"])) {
    header("Location: " . LOGINCENTER_PATH);
  }

  require_once(CONFIG_DIR . $_SESSION["lang"] . ".translation.inc");



	foreach($_POST as $key => $value){
		$_POST[$key] = norm($value);
	}
	foreach($_GET as $key => $value){
		$_GET[$key] = norm($value);
	}
	
	$strTemplate = "pop.tellimus.tpl";
	
	$tellimus = get_tellimus($_GET['ID']);
	$tellimus_products = split("<br>", $tellimus[0]['tellimus']);
	if ($tellimus_products[sizeof($tellimus_products)-1] == "")
		unset($tellimus_products[sizeof($tellimus_products)-1]);
	foreach($tellimus_products as $prod_key=>$prod_val){
		$tmp = split(" / ", $prod_val);
		$prod_arr[$prod_key]['art_nr'] = $tmp[0];
		$prod_arr[$prod_key]['title'] = $tmp[1];
		$prod_arr[$prod_key]['qnt'] = $tmp[2];
		$prod_arr[$prod_key]['price'] = $tmp[3];
		$prod_arr[$prod_key]['total'] = str_replace("Kokku: ", "", $tmp[4]);
	}
//$engSmarty->debug_tpl = "debug.tpl";
//$engSmarty->debugging = 1;
//$engSmarty->error_reporting = 512;
	$engSmarty->assign("ArrTellimus", $prod_arr);
	$engSmarty->assign("tellimus", $tellimus[0]);
  $engSmarty->assign("_GET", $_GET);
  $engSmarty->assign("boolRefresh", $refresh);
  $engSmarty->assign("arrTranslation", $arrTranslation);
  $engSmarty->display("admin/" .$strTemplate);


?>
