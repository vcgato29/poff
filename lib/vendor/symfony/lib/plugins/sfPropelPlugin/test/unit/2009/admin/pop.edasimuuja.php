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
	
	$strUsertype = "client";
	
	if ($_POST['ID']){
		$recData['ID'] = $_POST['ID'];
		$recData['userID'] = $_POST['userID'];
	}
	$recData['fname'] = $_POST['form_fname'];
	$recData['contact_name'] = $_POST['form_contact'];
	$recData['email'] = $_POST['form_email'];
	$recData['password'] = $_POST['form_password'];
	$recData['telefon'] = $_POST['form_telefon'];
	$recData['fax'] = $_POST['form_fax'];
	$recData['http'] = $_POST['form_http'];
	$recData['markused'] = $_POST['form_markused'];
	$recData['index'] = $_POST['form_index'];
	$recData['address'] = $_POST['form_address'];
	
	$strTemplate = "pop.edasimuuja.tpl";
	
	if ($_GET['ID']){
		$muujad = get_edasimuujad($_GET['ID']);
		$recData['fname'] = $muujad[0]['fname'];
		$recData['userID'] = $muujad[0]['userID'];
		$recData['contact_name'] = $muujad[0]['contact_name'];
		$recData['email'] = $muujad[0]['email'];
		$recData['password'] = $muujad[0]['password'];
		$recData['telefon'] = $muujad[0]['telefon'];
		$recData['fax'] = $muujad[0]['fax'];
		$recData['http'] = $muujad[0]['http'];
		$recData['markused'] = $muujad[0]['add_info'];
		$recData['index'] = $muujad[0]['postalcode'];
		$recData['country'] = $muujad[0]['country'];
		$recData['region'] = $muujad[0]['region'];
		$recData['city'] = $muujad[0]['city'];
		$recData['address'] = $muujad[0]['address'];
		$country = get_country();
		$region = get_region(0,$recData['country']);
		$city = get_city(0, $recData['region'], $recData['country']);
	}else{
		$country = get_country();
		if ($_POST['form_country']){
			$recData['country'] = $_POST['form_country'];
			$region = get_region(0,$_POST['form_country']);
			if ($_POST['form_region']){
				$recData['region'] = $_POST['form_region'];
				$city = get_city(0, $_POST['form_region'], $_POST['form_country']);
				$recData['city'] = $_POST['form_city'];
			}
		}
  	}
  	$engSmarty->assign("region", $region);
  	$engSmarty->assign("country", $country);
  	$engSmarty->assign("city", $city);
  	if (is_array($muujad))
  		$engSmarty->assign("muujad", $muujad);
  	
  	if ($_POST['formUser_submit']){
		if (!$recData['fname'])
			$recError['fname'] = 1;
		if (!$recData['email'])
			$recError['email'] = 1;
		if (!$recData['password'])
			$recError['password'] = 1;
		if (!$recData['country'])
			$recError['country'] = 1;
		if (!$recData['region'])
			$recError['region'] = 1;
		if (!$recData['city'])
			$recError['city'] = 1;
		if (!is_array($recError)){
			if ($recData['ID']){
				$_POST[$objUser->strFormName."_username"] = $_POST['form_email'];
			    $_POST[$objUser->strFormName."_realname"] = $_POST['form_contact'];
			    $_POST[$objUser->strFormName."_password"] = $_POST['form_password'];
			    $_POST[$objUser->strFormName."_email"] = $_POST['form_email'];
			    $_POST[$objUser->strFormName."_phone"] = $_POST['form_telefon'];
			    $recUserInput = $objUser->fnMakeRecord($_POST);
			    $recUserInput->ID = $_POST["userID"];

			    $result = $objUser->fnValidateData($recUserInput, "update");

			    if (is_array($result)) {
				    $_GET["action"] = "view";
				    $recError["type"] = $result["type"];
			        $recError["fields"] = $result["field"];
				    $error = 1;
			    }
				if (!$error){
					$recUpdate = $objUser->fnProcessData($result, "update");
				    $boolResult = $objUser->fnUpdateData($recUpdate, "ID='" . $_POST["userID"] . "' and status='active' and usertype='" . $strUsertype . "'");

					if (!$boolResult) {
				        $_GET["action"] = "view";
				        $recError["type"] = "updatefailure";
				        $error = 1;
				    }
				    unset($recUpdate);

					if (!$error)
				      	$objUserLog->fnLogEvent("user", "update", $_REQUEST["userID"]);
				}
				if (!$error)
					update_edasimuuja($recData);
			}else{
				$_POST[$objUser->strFormName."_username"] = $_POST['form_email'];
			    $_POST[$objUser->strFormName."_realname"] = $_POST['form_contact'];
			    $_POST[$objUser->strFormName."_password"] = $_POST['form_password'];
			    $_POST[$objUser->strFormName."_email"] = $_POST['form_email'];
			    $_POST[$objUser->strFormName."_phone"] = $_POST['form_telefon'];
			    $recUserInput = $objUser->fnMakeRecord($_POST);
			    $recUserInput->usertype = $strUsertype;

			    $result = $objUser->fnValidateData($recUserInput, "insert");

			    if (is_array($result)) {
			        $_GET["action"] = "view";
			        $recError["type"] = $result["type"];
			        $recError["fields"] = $result["field"];
			        $error = 1;
			    }
				if (!$error){
				    $recInsert = $objUser->fnProcessData($result, "insert");

				    $newID = $objUser->fnInsertData($recInsert);

				    if (!$newID) {
				       $_GET["action"] = "view";
				       $recError["insert"] = "insertfailure";
				       $error = 1;
				    }
				    unset($recInsert);
					if (!$error)
				      	$objUserLog->fnLogEvent("user", "insert", $newID);
			    }
			    if (!$error){
			    	$recData['userID'] = $newID;
					$recData['ID'] = add_edasimuuja($recData);
					
					//Send mail about registration with login and password.
					
					  
					  $strMail .= "Tere\n\n";
					  $strMail .= "Olete registreeritud Tiki-Treiler'i edasimuujaks\n";
					  $strMail .= "Sisse loogida saate siin http://www.tikitreiler.ee/est/edasimuuja/login \n";
					  $strMail .= "Teie kasutajatunnus on ".$recData['email']."\n";
					  $strMail .= "Teie parool on ".$recData['password']."\n";
					  $strMail .= "\n";
					  $strMail .= "Lugupidamisega, Tiki-Treiler'i administratsioon\n";

					  $strHeader = "From: system@tikitreiler.ee;";

				      //@mail($recData['email'], "Edasimuuja registreerimine", $strMail, $strHeader);
					  
				}
			}
			if (!$error)
				$refresh = true;
		}
	}
	$engSmarty->assign("recData", $recData);
	$engSmarty->assign("recError", $recError);
  $engSmarty->assign("_GET", $_GET);
  $engSmarty->assign("_POST", $_POST);
  $engSmarty->assign("boolRefresh", $refresh);
  $engSmarty->assign("arrTranslation", $arrTranslation);
  $engSmarty->display("admin/".$strTemplate);


?>
