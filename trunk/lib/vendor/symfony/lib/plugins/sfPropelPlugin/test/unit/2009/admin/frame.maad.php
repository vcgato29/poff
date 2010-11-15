<?php
/**
 * Rakendus: sisu frame, edasimuujad
 *
 * Struktuuriühikute nimekirja kuvamine, otsingu vorm ning tulemuste kuvamine,
 * struktuuriühikute lisamise, kopeerimise, liigutamise, kustutamise ning muutmise
 * navigeerimine
 * @package CMS_PAGE
 * @subpackage admin
 */

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
  //require_once(MODULE_DIR . "productcatalog/mod.category.inc");
  //require_once(MODULE_DIR . "productcatalog/mod.variable.inc");
  //require_once(MODULE_DIR . "productcatalog/mod.product.inc");
  require_once(MODULE_DIR . "statistics/mod.query.inc");
  require_once(MODULE_DIR . "ind_functions.inc");
  include_once(MODULE_DIR . "edasimuuja.inc");
  //require_once(MODULE_DIR . "sitevariables/mod.sitevariables.inc");

  if (!$objIPAccess->fnValidate($arrAllowIP["access"], $_SERVER["REMOTE_ADDR"]) or $objIPAccess->fnValidate($arrAllowIP["deny"], $_SERVER["REMOTE_ADDR"])) {
    header("Location: " . LOGINCENTER_PATH);
  }


  if (!is_object($_SESSION["user"])) {
    header("Location: " . LOGINCENTER_PATH);
  }

  require_once(CONFIG_DIR . $_SESSION["lang"] . ".translation.inc");


	foreach($_GET as $key => $value){
		$_GET[$key] = norm($value);
	}
	
		$strTemplate = "content.maad.tpl";
		
		$tree = get_locations($_GET['country'], $_GET['region']);
			
		$engSmarty->assign("tree", $tree);
  
  $engSmarty->assign("_GET", $_GET);
  $engSmarty->assign("boolRefreshTree", $_GET["refreshtree"]);
  $engSmarty->assign("arrTranslation", $arrTranslation);
  $engSmarty->display("admin/" .$strTemplate);
?>
