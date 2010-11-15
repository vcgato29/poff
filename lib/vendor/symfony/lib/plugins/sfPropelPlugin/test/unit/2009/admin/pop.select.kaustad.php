<?php
/**
 * Rakendus: navigeerimise hüpikaken
 *
 * Struktuuriühikute kopeerimisel ja liigutamisel kasutatav navigatsiooniaken
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
	require_once(MODULE_DIR . "ind_functions.inc");
  require_once(MODULE_DIR . "edasimuuja.inc");


  if (!$objIPAccess->fnValidate($arrAllowIP["access"], $_SERVER["REMOTE_ADDR"]) or $objIPAccess->fnValidate($arrAllowIP["deny"], $_SERVER["REMOTE_ADDR"])) {
    $boolClose = true;
  }

  if (!is_object($_SESSION["user"])) {
    $boolClose = true;
  }

  if (!$boolClose) {
    require_once(CONFIG_DIR . $_SESSION["lang"] . ".translation.inc");
	
	foreach($_POST as $key => $value){
		if (!is_array($value))
			$_POST[$key] = norm($value);
	}
	foreach($_GET as $key => $value){
		$_GET[$key] = norm($value);
	}

    if (!$_GET["ID"]) {
      $_GET["ID"] = 2;
    }
    
    $user_id = $_REQUEST["cluserID"];
    
    if ($_POST["action_rights"]){
    	$boolClose = true;
    	$folders = $_POST["folders"];
    	$old_folders = $_POST["old_folders"];
    	if (is_array($folders)){
    		foreach($folders as $val){
    			if (!@in_array($val, $old_folders)){
	    			$recInsert->userID = $user_id;
		            $recInsert->structureID = $val;
		            $recInsert->type = "user";
		            $recInsert->rights = "read";
		            $objUserRights->fnInsertData($recInsert);
	            }
    		}
    	}
    	if (is_array($old_folders)){
    		foreach($old_folders as $val){
    			if (!@in_array($val, $folders)){
    				$objUserRights->fnDeleteData("type='user' and structureID='" . $val . "' and userID = '".$user_id."'");
    			}
    		}
    	}
    }
	
    $objStructure->fnInclude();
    $arrSetRights = $objUserRights->fnGetRights("", $_SESSION["user"]->ID);
    $arrGlobalRights = $objStructure->fnGetNode(1, "rights", "", "", $arrSetRights);
    //$recNode = $objStructure->fnGetNodeByPath(dirname($_SERVER["REQUEST_URI"]));
	$recNode = $objStructure->fnGetNodeByPath('/est/edasimuuja');
	
	$recTree = $objStructure->fnGetNode($recNode->ID, "structure");
	$sql = "(";
	foreach($recTree->arrNode as $key=>$val){
		$arrUserRights = $objUserRights->fnGetDataList("structureID='".$val->ID."' and type='user' and userID='".$user_id."'", "userID, structureID, rights");
		if ($arrUserRights[0]->rights == "read")
			$recTree->arrNode[$key]->access = 1;
		else
			$recTree->arrNode[$key]->access = 0;
		
		$test = $objFolder->fnGetItem($val->ID);
		if ($test->markwords == "Login folder" || $test->markwords == "public")
			unset($recTree->arrNode[$key]);
		else{
			$arrUserRights = $objUserRights->fnGetDataList("structureID='".$val->ID."' and type='user' and userID='2'", "userID, structureID, rights");
			if ($arrUserRights[0]->rights != "deny"){
				$recInsert->userID = "2";
			    $recInsert->structureID = $val;
			    $recInsert->type = "user";
			    $recInsert->rights = "deny";
			    $objUserRights->fnInsertData($recInsert);
		    }
		    $arrUserRights = $objUserRights->fnGetDataList("structureID='".$val->ID."' and type='user' and userID='3'", "userID, structureID, rights");
			if ($arrUserRights[0]->rights != "deny"){
			    $recInsert->userID = "3";
			    $recInsert->structureID = $val;
			    $recInsert->type = "user";
			    $recInsert->rights = "deny";
			    $objUserRights->fnInsertData($recInsert);
		    }
		}
	}
    


  }
	
//$engSmarty->debug_tpl = "debug.tpl";
//$engSmarty->debugging = 1;
//$engSmarty->error_reporting = 512;

  $engSmarty->assign("boolActionStatus", $boolActionStatus);
  $engSmarty->assign("strAction", $strAction);
  $engSmarty->assign("recTree", $recTree);
  $engSmarty->assign("user_id", $user_id);
  $engSmarty->assign("_GET", $_GET);
  $engSmarty->assign("_POST", $_POST);
  //$engSmarty->assign("boolRefresh", $boolRefresh);
  //$engSmarty->assign("boolRefreshTree", $boolRefreshTree);
  $engSmarty->assign("boolClose", $boolClose);
  $engSmarty->assign("strError", $strError);
  $engSmarty->assign("arrTranslation", $arrTranslation);
  $engSmarty->display("admin/pop.select.kaustad.tpl");
?>
