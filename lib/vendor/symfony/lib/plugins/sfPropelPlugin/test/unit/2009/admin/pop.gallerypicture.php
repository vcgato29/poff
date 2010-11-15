<?php
/**
 * Rakendus: kasutaja hüpikaken
 *
 * Infovorm uue kasutaja loomiseks või olemasoleva kasutaja andmete muutmiseks
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
  require_once(MODULE_DIR . "structure/mod.gallery.inc");


  if (!$objIPAccess->fnValidate($arrAllowIP["access"], $_SERVER["REMOTE_ADDR"]) or $objIPAccess->fnValidate($arrAllowIP["deny"], $_SERVER["REMOTE_ADDR"])) {
    $recUser->recForm->boolClose = true;
  }


  if (!is_object($_SESSION["user"])) {
    $recUser->recForm->boolClose = true;
  }


  if (!$recUser->recForm->boolClose) {
    require_once(CONFIG_DIR . $_SESSION["lang"] . ".translation.inc");


    if (!$_GET["action"]) {
      $_GET["action"] = "view";
    }


    $strUsertype = "admin";


    $arrSetRights = $objUserRights->fnGetRights("", $_SESSION["user"]->ID);
    $arrGlobalRights = $objStructure->fnGetNode(1, "rights", "", "", $arrSetRights);


    if (@in_array($_GET["action"], array("insert", "update"))) {
      //if ($arrGlobalRights[$_GET["parentID"]] == "write") {
        include(MODULE_DIR . "structure/actions.gallerypicture.inc");
      //} else {
      //  $_GET["action"] = "view";
      //  $strError = $arrTranslation["error"]["noprivileges"];
      //}
    }
    if ($arrGlobalRights[$_GET["parentID"]] != "deny") {
      include(MODULE_DIR . "structure/actions.gallerypicture.inc");
    } else {
      $recUser->recForm->boolClose = true;
    }
  }


  if ($strError) {
    $recUser->recError->strError = $strError;
  }

  $engSmarty->assign("_GET", $_GET);
  $engSmarty->assign("recGalleryPicture", $recGalleryPicture);
  $engSmarty->assign("arrTranslation", $arrTranslation);
  $engSmarty->display("admin/pop.gallerypicture.tpl");
?>
