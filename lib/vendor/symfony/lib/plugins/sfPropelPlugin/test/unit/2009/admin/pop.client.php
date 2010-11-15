<?php
/**
 * Rakendus: kasutaja h�pikaken
 *
 * Infovorm uue kasutaja loomiseks v�i olemasoleva kasutaja andmete muutmiseks
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


    $strUsertype = "client";


    $arrSetRights = $objUserRights->fnGetRights("", $_SESSION["user"]->ID);
    $arrGlobalRights = $objStructure->fnGetNode(1, "rights", "", "", $arrSetRights);


    if (@in_array($_GET["action"], array("insert", "update"))) {
      if ($arrGlobalRights[6] == "write") {
        include(MODULE_DIR . "user/actions.user.inc");
      } else {
        $_GET["action"] = "view";
        $strError = $arrTranslation["error"]["noprivileges"];
      }
    }
    if ($arrGlobalRights[6] != "deny") {
      include(MODULE_DIR . "user/actions.user.inc");
    } else {
      $recUser->recForm->boolClose = true;
    }
  }


  if ($strError) {
    $recUser->recError->strError = $strError;
  }

  $engSmarty->assign("_GET", $_GET);
  $engSmarty->assign("recUser", $recUser);
  $engSmarty->assign("recGroup", $recGroup);
  $engSmarty->assign("arrTranslation", $arrTranslation);
  $engSmarty->display("admin/pop.client.tpl");
?>
