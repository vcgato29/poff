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
  require_once(MODULE_DIR . "statistics/mod.query.inc");
  require_once(MODULE_DIR . "ind_functions.inc");
  include_once(MODULE_DIR . "tellimus.inc");
  //require_once(MODULE_DIR . "sitevariables/mod.sitevariables.inc");

  if (!$objIPAccess->fnValidate($arrAllowIP["access"], $_SERVER["REMOTE_ADDR"]) or $objIPAccess->fnValidate($arrAllowIP["deny"], $_SERVER["REMOTE_ADDR"])) {
    header("Location: " . LOGINCENTER_PATH);
  }


  if (!is_object($_SESSION["user"])) {
    header("Location: " . LOGINCENTER_PATH);
  }

	foreach($_GET as $key => $value){
		$_GET[$key] = norm($value);
	}

  require_once(CONFIG_DIR . $_SESSION["lang"] . ".translation.inc");
	
	if ($_GET['action'] == "delete"){
		if ($_GET['items']){
			$items_arr = explode(";", $_GET["items"]);
			while(list($key, $val) = @each($items_arr)){
				delete_tellimus($val);
			}
			if ($_GET['invoice'])
				header("location: frame.tellimused.php?invoice=1");
			else
				header("location: frame.tellimused.php");
			
			exit;
		}
	}
	
		
		$strTemplate = "content.tellimused.tpl";
		if ($_GET['sort']){
			switch ($_GET['sort']){
				case "summa":
					$sort_val = 1;
					break;
				case "contact_person":
					$sort_val = 2;
					break;
				case "email":
					$sort_val = 3;
					break;
				case "status":
					$sort_val = 4;
					break;
				case "address":
					$sort_val = 7;
					break;
				case "transport":
					$sort_val = 9;
					break;
				case "transport_price":
					$sort_val = 10;
					break;
				case "date":
					$sort_val = 8;
					break;	
				default:
					$sort_val = 0;
			}
			$tellimused = get_tellimused($sort_val);
		}else
			$tellimused = get_tellimused();
			
		$engSmarty->assign("tellimused", $tellimused);
  
 // $engSmarty->debug_tpl = "debug.tpl";
//	$engSmarty->debugging = 1;
//	$engSmarty->error_reporting = 512;
  $engSmarty->assign("_GET", $_GET);
  $engSmarty->assign("boolRefreshTree", $_GET["refreshtree"]);
  $engSmarty->assign("arrTranslation", $arrTranslation);
  $engSmarty->display("admin/" .$strTemplate);

?>
