<?php
/**
 * Rakendus: sisu pop, edasimuujad
 *
 * struktuuriühikute lisamise, kustutamise ning muutmise
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



	foreach($_POST as $key => $value){
		$_POST[$key] = norm($value);
	}
	foreach($_GET as $key => $value){
		$_GET[$key] = norm($value);
	}
		
	
	if ($_POST['formUser_submit']){
		$recData['ID'] = $_POST['ID'];
		$recData['value_est'] = $_POST['value_est'];
		$recData['value_eng'] = $_POST['value_eng'];
		$recData['value_rus'] = $_POST['value_rus'];
		$recData['country'] = $_POST['country'];
		$recData['region'] = $_POST['region'];
		$recData['city'] = $_POST['city'];
		$recData['path'] = $_POST['path'];
		if (!$recData['value_est'])
			$recError['value_est'] = 1;
		if (!$recData['value_eng'])
			$recError['value_eng'] = 1;
		if (!$recData['value_rus'])
			$recError['value_rus'] = 1;
		if (!$recData['path'] && ($recData['country'] && !$recData['region']))
			$recError['path'] = 1;
		
		if (is_array($recError))
			$engSmarty->assign("recError", $recError);
		else{
			if (!$recData['ID']){
				if ($recData['country']){
					if ($recData['region'])
						$recData['ID'] = add_city($recData['value_est'], $recData['value_eng'], $recData['value_rus'], $recData['country'], $recData['region']);
					else
						$recData['ID'] = add_region($recData['value_est'], $recData['value_eng'], $recData['value_rus'], $recData['country'], $recData['path']);
				}else
					$recData['ID'] = add_country($recData['value_est'], $recData['value_eng'], $recData['value_rus']);
			}else{
				if ($recData['country']){
					if ($recData['region'])
						update_city($recData['ID'], $recData['value_est'], $recData['value_eng'], $recData['value_rus'], $recData['country'], $recData['region']);
					else
						update_region($recData['ID'], $recData['value_est'], $recData['value_eng'], $recData['value_rus'], $recData['country'], $recData['path']);
				}else
					update_country($recData['ID'], $recData['value_est'], $recData['value_eng'], $recData['value_rus']);
			}
			$refresh = true;
		}
	}
	
	$strTemplate = "pop.edasimuuja.location.tpl";
	
	if (!$_POST['formUser_submit']){
		$recData['country'] = $_GET['country'];
		$recData['region'] = $_GET['region'];
		$recData['ID'] = $_GET['ID'];
	}
	
	if ($recData['country']){
		if ($recData['region']){
			if ($recData['ID']){
				$city = get_city($recData['ID']);
				$recData['city'] = $recData['ID'];
				if (!$_POST['formUser_submit']){
					$recData['value_est'] = $city[0]['name_est'];
					$recData['value_eng'] = $city[0]['name_eng'];
					$recData['value_rus'] = $city[0]['name_rus'];
				}
			}
			$region = get_region($recData['region']);
		}else{
			if ($recData['ID']){
				$region = get_region($recData['ID']);
				if (!$_POST['formUser_submit']){
					$recData['value_est'] = $region[0]['name_est'];
					$recData['value_eng'] = $region[0]['name_eng'];
					$recData['value_rus'] = $region[0]['name_rus'];
					$recData['path'] = $region[0]['path'];
				}
			}
		}
		$country = get_country($recData['country']);
	}else{
		if ($recData['ID']){
			$country = get_country($recData['ID']);
			if (!$_POST['formUser_submit']){
				$recData['value_est'] = $country[0]['name_est'];
				$recData['value_eng'] = $country[0]['name_eng'];
				$recData['value_rus'] = $country[0]['name_rus'];
			}
		}
	}
	
	if (!is_array($city) && !is_array($region) && !is_array($country)){
		unset($recData['ID']);
		unset($_GET['ID']);
  	}
  	$engSmarty->assign("region", $region);
  	$engSmarty->assign("country", $country);
  	$engSmarty->assign("city", $city);
  	
	$engSmarty->assign("recData", $recData);
  $engSmarty->assign("_GET", $_GET);
  $engSmarty->assign("_POST", $_POST);
  $engSmarty->assign("boolRefresh", $refresh);
  $engSmarty->assign("arrTranslation", $arrTranslation);
  
  $engSmarty->display("admin/" .$strTemplate);

?>
