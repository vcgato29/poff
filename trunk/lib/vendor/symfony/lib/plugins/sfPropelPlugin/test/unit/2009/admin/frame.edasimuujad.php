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
	if ($_GET['action'] == "delete"){
		if ($_GET['items']){
			$strUsertype = "client";
			$items_arr = explode(";", $_GET["items"]);
			while(list($key, $val) = @each($items_arr)){
				$muuja = get_edasimuujad($val);
				if (is_array($muuja)){
					$recUpdate->password = md5(uniqid(rand(), true));
			        $recUpdate->status = "deleted";
			        $objUser->fnUpdateData($recUpdate, "ID='" . $muuja[0]['userID'] . "' and status='active' and usertype='" . $strUsertype . "'");
			         
					delete_edasimuuja($val);
				}
			}
			header("location: frame.edasimuujad.php");
		}
	}
		$strTemplate = "content.edasimuujad.tpl";
		if ($_GET['sort']){
			switch ($_GET['sort']){
				case "fname":
					$sort_val = 1;
					break;
				case "contact_person":
					$sort_val = 2;
					break;
				case "email":
					$sort_val = 3;
					break;
				case "country":
					$sort_val = 4;
					break;
				case "region":
					$sort_val = 5;
					break;
				case "city":
					$sort_val = 6;
					break;
				case "address":
					$sort_val = 7;
					break;
				default:
					$sort_val = 0;
			}
			$muujad = get_edasimuujad(0, $sort_val);
		}else
			$muujad = get_edasimuujad();
			
		$engSmarty->assign("muujad", $muujad);
  
  $engSmarty->assign("_GET", $_GET);
  $engSmarty->assign("boolRefreshTree", $_GET["refreshtree"]);
  $engSmarty->assign("arrTranslation", $arrTranslation);
  $engSmarty->display("admin/".$strTemplate);

?>
