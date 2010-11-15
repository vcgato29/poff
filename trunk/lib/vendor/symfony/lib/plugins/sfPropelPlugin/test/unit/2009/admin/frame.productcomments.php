<?php
/**
 * Rakendus: sisu frame, edasimuujad
 *
 * Struktuuri�hikute nimekirja kuvamine, otsingu vorm ning tulemuste kuvamine,
 * struktuuri�hikute lisamise, kopeerimise, liigutamise, kustutamise ning muutmise
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
  require_once(MODULE_DIR . "statistics/mod.query.inc");
  require_once(MODULE_DIR . "ind_functions.inc");
  include_once(MODULE_DIR . "tellimus.inc");
  require_once(MODULE_DIR . "productcatalog/mod.product.inc");
require_once(MODULE_DIR . "productcatalog/mod.category.inc");
require_once(MODULE_DIR . "productcatalog/mod.variable.inc");
require_once(MODULE_DIR . "productcatalog/mod.product.substructure.inc");

  //require_once(MODULE_DIR . "sitevariables/mod.sitevariables.inc");

  if (!$objIPAccess->fnValidate($arrAllowIP["access"], $_SERVER["REMOTE_ADDR"]) or $objIPAccess->fnValidate($arrAllowIP["deny"], $_SERVER["REMOTE_ADDR"])) 
  {
    header("Location: " . LOGINCENTER_PATH);
  }


  if (!is_object($_SESSION["user"])) 
  {
    header("Location: " . LOGINCENTER_PATH);
  }

  require_once(CONFIG_DIR . $_SESSION["lang"] . ".translation.inc");
	
	if ($_GET['action'] == "delete")
	{
		if ($_GET['items'])
		{
			$items_arr = explode(";", $_GET["items"]);
			while(list($key, $val) = @each($items_arr))
			{
				if (strlen($val)>0) delete_comment($val);
			}
			header("location: frame.productcomments.php");
			
			exit;
		}
	}
	
		
$strTemplate = "content.productcomments.tpl";

$comments = get_all_comments();

$engSmarty->assign("comments", $comments);
  
 // $engSmarty->debug_tpl = "debug.tpl";
//	$engSmarty->debugging = 1;
//	$engSmarty->error_reporting = 512;
  $engSmarty->assign("_GET", $_GET);
  $engSmarty->assign("boolRefreshTree", $_GET["refreshtree"]);
  $engSmarty->assign("arrTranslation", $arrTranslation);
  $engSmarty->display("admin/" .$strTemplate);

?>