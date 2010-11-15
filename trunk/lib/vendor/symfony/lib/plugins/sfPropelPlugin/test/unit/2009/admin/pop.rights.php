<?php
/**
 * Rakendus: õiguste hüpikaken
 *
 * Kasutajate ja kasutajagruppide õiguste muutmise infovorm
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
  require_once(MODULE_DIR . "comments.inc");
  
  if (!$objIPAccess->fnValidate($arrAllowIP["access"], $_SERVER["REMOTE_ADDR"]) or $objIPAccess->fnValidate($arrAllowIP["deny"], $_SERVER["REMOTE_ADDR"])) {
    $boolClose = true;
  }


  if (!is_object($_SESSION["user"])) {
    $boolClose = true;
  }


  if (!$boolClose) {
    require_once(CONFIG_DIR . $_SESSION["lang"] . ".translation.inc");
    $objStructure->fnInclude();

    if (!$_GET["action"]) {
      $_GET["action"] = "view";
    }

    $arrSetRights = $objUserRights->fnGetRights("", $_SESSION["user"]->ID);
    $arrGlobalRights = $objStructure->fnGetNode(1, "rights", "", "", $arrSetRights);


    if (@in_array($_GET["action"], array("update"))) {
      if ($arrGlobalRights[$_GET["ID"]] == "write") {
        include(MODULE_DIR . "structure/actions.rights.inc");

      } else {
        $_GET["action"] = "view";
        $strError = $arrTranslation["error"]["noprivileges"];
      }
    }
    if ($_GET["ID"] and $arrGlobalRights[$_GET["ID"]] != "deny") {
      include(MODULE_DIR . "structure/actions.rights.inc");
    } else {
      $boolClose = true;
    }
  }

  $recStructure->recData->comments = getComments($_GET['ID']);
  $engSmarty->assign("recStructure", $recStructure);
  $engSmarty->assign("boolClose", $boolClose);
  $engSmarty->assign("boolRefresh", $boolRefresh);
  $engSmarty->assign("arrUser", $arrUser);
  $engSmarty->assign("arrGroup", $arrGroup);
  $engSmarty->assign("arrClient", $arrClient);
  $engSmarty->assign("recNode", $recNode);
  $engSmarty->assign("_GET", $_GET);
  $engSmarty->assign("strError", $strError);
  $engSmarty->assign("arrTranslation", $arrTranslation);

  $engSmarty->display("admin/pop.rights.tpl");
?>
