<?php
/**
 * Rakendus: lehe seadete hpikaken
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
  require_once(MODULE_DIR . "productcatalog/mod.category.inc");
  require_once(MODULE_DIR . "structure/mod.productcatalogpublic.inc");
  require_once(MODULE_DIR . "structure/mod.lang.inc");

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


    if (@in_array($_GET["action"], array("update", "insert", "changefilterposition", "deletefilter"))) {
      if (/*$arrGlobalRights[$_GET["parentID"]] == "write"*/ 1 < 2) {
        include(MODULE_DIR . "structure/actions.productcatalogpublicfilter.inc");
      } else {
        $_GET["action"] = "view";
        $strError = $arrTranslation["structure"]["error"]["noprivileges"];
      }
    }
    if ($arrGlobalRights[$_GET["parentID"]] != "deny") {
      include(MODULE_DIR . "structure/actions.productcatalogpublicfilter.inc");
    } else {
      $recProductcatalogpublicFilter->recForm->boolClose = true;
    }
  }
  if ($strError) {
    $recProductcatalogpublicFilter->recError->strError = $strError;
  }
  elseif($recError)
  {
    $recProductcatalogpublicFilter->recError->strError = $arrTranslation["structure"]["error"][$recError->type];
  }
  
  $engSmarty->assign("_GET", $_GET);
  $engSmarty->assign("boolRefresh", $_GET["refresh"]);
  $engSmarty->assign("recProductcatalogpublicFilter", $recProductcatalogpublicFilter);
  $engSmarty->display("admin/pop.productcatalogpublicfilter.tpl");
?>