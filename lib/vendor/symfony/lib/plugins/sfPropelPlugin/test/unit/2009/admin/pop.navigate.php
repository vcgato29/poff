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



  if (!$objIPAccess->fnValidate($arrAllowIP["access"], $_SERVER["REMOTE_ADDR"]) or $objIPAccess->fnValidate($arrAllowIP["deny"], $_SERVER["REMOTE_ADDR"])) 
  {
    $boolClose = true;
  }

  if (!is_object($_SESSION["user"])) 
  {
    $boolClose = true;
  }

  if (!$boolClose) 
  {
    require_once(CONFIG_DIR . $_SESSION["lang"] . ".translation.inc");


    if (!$_GET["startID"])
    {
      $_GET["startID"] = 2;
    }
    
    if (!$_GET["ID"]) 
    {
      $_GET["ID"] = $_GET["startID"];
    }
    
    $objStructure->fnInclude();
    $arrSetRights = $objUserRights->fnGetRights("", $_SESSION["user"]->ID);
    $arrGlobalRights = $objStructure->fnGetNode(1, "rights", "", "", $arrSetRights);
    $recTree = $objStructure->fnGetNode($_GET["ID"], "navigate", $_GET["startID"]);


    if (@in_array($_GET["action"], array("copy", "move"))) 
    {
      if ($arrGlobalRights[$_GET["ID"]] == "write") 
      {
        include(MODULE_DIR . "structure/actions.navigate.inc");

      }
       else 
       {
        $_GET["action"] = "view";
        $strError = $arrTranslation["error"]["noprivileges"];
      }
    }
    if ($_GET["ID"] and $arrGlobalRights[$_GET["ID"]] != "deny") 
    {
      include(MODULE_DIR . "structure/actions.navigate.inc");
    }
    else 
    {
      $boolClose = true;
    }

  }

  $engSmarty->assign("boolActionStatus", $boolActionStatus);
  $engSmarty->assign("strAction", $strAction);
  $engSmarty->assign("recTree", $recTree);
  $engSmarty->assign("_GET", $_GET);
  $engSmarty->assign("boolRefresh", $boolRefresh);
  $engSmarty->assign("boolRefreshTree", $boolRefreshTree);
  $engSmarty->assign("boolClose", $boolClose);
  $engSmarty->assign("strError", $strError);
  $engSmarty->assign("arrTranslation", $arrTranslation);
  $engSmarty->display("admin/pop.navigate.tpl");
?>
