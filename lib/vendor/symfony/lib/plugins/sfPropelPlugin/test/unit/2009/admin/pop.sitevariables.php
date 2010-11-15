<?php
/**
 * Rakendus: lehe seadete hüpikaken
 *
 * Infovorm lehe seadmete muutmiseks
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
  require_once(MODULE_DIR . "user/mod.usergroup.inc");
  require_once(MODULE_DIR . "structure/mod.structure.inc");
  require_once(MODULE_DIR . "structure/mod.sitevariables.inc");
  require_once(MODULE_DIR . "structure/mod.lang.inc");

 
  //foreach($_GET as $a => $b)print $a." ".$b."<br>";
  if (!$objIPAccess->fnValidate($arrAllowIP["access"], $_SERVER["REMOTE_ADDR"]) or $objIPAccess->fnValidate($arrAllowIP["deny"], $_SERVER["REMOTE_ADDR"])) {
    $boolClose = true;
  }


  if (!is_object($_SESSION["user"])) {
    $boolClose = true;
  }


  if (!$boolClose) {
    require_once(CONFIG_DIR . $_SESSION["lang"] . ".translation.inc");


    if (!$_GET["action"]) {
      $_GET["action"] = "view";
    }

    $arrSetRights = $objUserRights->fnGetRights("", $_SESSION["user"]->ID);
    $arrGlobalRights = $objStructure->fnGetNode(1, "rights", "", "", $arrSetRights);


    if (@in_array($_GET["action"], array("update"))) {
      if ($arrGlobalRights[5] == "write") {
        include(MODULE_DIR . "structure/actions.sitevariables.inc");
      } else {
        $_GET["action"] = "view";
        $strError = $arrTranslation["error"]["noprivileges"];
      }
    }
    if ($arrGlobalRights[5] != "deny") {
      include(MODULE_DIR . "structure/actions.sitevariables.inc");
    } else {
      $recSitevariables->recForm->boolClose = true;
    }
  }


  if ($strError) {
    $recSitevariables->recError->strError = $strError;
  }
	
	foreach($recSitevariables->recData->arrData as $key1 => $val1){
		if ($val1->content && substr($val1->name, 0, 6) == "footer")
			$recSitevariables->recData->arrData[$key1]->content = stripslashes($val1->content);
	}
	
  $engSmarty->assign("arrTranslation", $arrTranslation);
  $engSmarty->assign("_GET", $_GET);
  $engSmarty->assign("boolRefresh", $_GET["refresh"]);
  $engSmarty->assign("recSitevariables", $recSitevariables);
  $engSmarty->display("admin/pop.sitevariables.tpl");
?>
