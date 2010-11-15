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
  require_once(MODULE_DIR . "productcatalog/mod.variable.inc");
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


    if (@in_array($_GET["action"], array("update", "insert", "delete"))) {
      if ($arrGlobalRights[5475] == "write") {
        include(MODULE_DIR . "productcatalog/actions.variableselection.inc");
      } else {
        $_GET["action"] = "view";
        $strError = $arrTranslation["structure"]["error"]["noprivileges"];
      }
    }
    if ($arrGlobalRights[5475] != "deny") {
      include(MODULE_DIR . "productcatalog/actions.variableselection.inc");
    } else {
      $recProductCategory->recForm->boolClose = true;
    }
  }
  if ($strError) {
    $recProductCategory->recError->strError = $strError;
  }
  elseif($recError)
  {
    $recProductCategory->recError->strError = $arrTranslation["structure"]["error"][$recError->type];
  }


  $engSmarty->assign("_GET", $_GET);
  $engSmarty->assign("boolRefresh", $_GET["refresh"]);
  $engSmarty->assign("recProductVariableSelection", $recProductVariableSelection);
  //printout($recProductVariableSelection);
  $engSmarty->display("admin/pop.productvariableselection.tpl");
?>
