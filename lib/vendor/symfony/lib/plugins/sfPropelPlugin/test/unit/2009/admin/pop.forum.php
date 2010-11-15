<?php
/**
 * Rakendus: struktuurielementide hüpikaken
 *
 * Struktuuriühikute loomiseks ning muutmiseks kasutatav infovorm
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

    $objStructure->fnInclude();
    $arrSetRights = $objUserRights->fnGetRights("", $_SESSION["user"]->ID);
    $arrGlobalRights = $objStructure->fnGetNode(1, "rights", "", "", $arrSetRights);

    $recTopic = $objForumtopic->fnGetDataRecord("ID='" . $_GET["topicID"] . "'");


    if (@in_array($_GET["action"], array("update", "delete")) and $arrGlobalRights[$recTopic->parentID] == "write") {
      include(MODULE_DIR . "structure/actions.forumadmin.inc");
    } elseif (@in_array($_GET["action"], array("update", "delete"))) {
      $_GET["action"] = "view";
      $strError = $arrTranslation["error"]["noprivileges"];
    }

    if (is_object($recTopic) and $arrGlobalRights[$recTopic->parentID] != "deny") {
      include(MODULE_DIR . "structure/actions.forumadmin.inc");
    } else {
      $boolClose = 1;
    }
  }


  if ($strError) {
    $engSmarty->assign("strError", $strError);
  }
  if ($recError) {
    $engSmarty->assign("recError", $recError);
  }

  $engSmarty->assign("recTopic", $recTopic);
  $engSmarty->assign("boolClose", $boolClose);
  $engSmarty->assign("_GET", $_GET);
  $engSmarty->assign("arrTranslation", $arrTranslation);
  $engSmarty->display("admin/pop.forum.tpl");
?>
