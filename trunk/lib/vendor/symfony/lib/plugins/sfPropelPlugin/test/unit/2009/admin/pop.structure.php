<?php
/**
 * Rakendus: struktuurielementide h�pikaken
 *
 * Struktuuri�hikute loomiseks ning muutmiseks kasutatav infovorm
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
  require_once(MODULE_DIR . "productcatalog/mod.category.inc");
  require_once(MODULE_DIR . "comments.inc");
 require_once(MODULE_DIR . "ind_functions.inc");
  if (!$objIPAccess->fnValidate($arrAllowIP["access"], $_SERVER["REMOTE_ADDR"]) or $objIPAccess->fnValidate($arrAllowIP["deny"], $_SERVER["REMOTE_ADDR"])) {
    $recStructure->boolClose = true;
  }


  if (!is_object($_SESSION["user"])) {
    $recStructure->boolClose = true;
  }


  if (!$recStructure->boolClose) {
    require_once(CONFIG_DIR . $_SESSION["lang"] . ".translation.inc");


    if (!$_GET["action"]) {
      $_GET["action"] = "selectform";
    }

    $objStructure->fnInclude();
    $arrSetRights = $objUserRights->fnGetRights("", $_SESSION["user"]->ID);
    $arrGlobalRights = $objStructure->fnGetNode(1, "rights", "", "", $arrSetRights);


    if ((@in_array($_GET["action"], array("update", "delete")) and $arrGlobalRights[$_GET["ID"]] == "write") or (@in_array($_GET["action"], array("select", "insert")) and $arrGlobalRights[$_GET["parentID"]] == "write")) 
    {
      include(MODULE_DIR . "structure/actions.structure.inc");
    } 
    elseif (@in_array($_GET["action"], array("insert", "update", "select", "delete"))) 
    {
      $_GET["action"] = ($_GET["action"] == "update") ? "view": "selectform";
      $strError = $arrTranslation["error"]["noprivileges"];
    }

    if (($_GET["ID"] and $arrGlobalRights[$_GET["ID"]] != "deny") or ($_GET["parentID"] and $arrGlobalRights[$_GET["parentID"]] != "deny")) 
    {
      include(MODULE_DIR . "structure/actions.structure.inc");
    }
    else 
    {
      $recStructure->boolClose = 1;
    }
  }

  if ($strError) {
    $recStructure->recError->strError = $strError;
  }
  
  if (is_numeric($_GET["parentID"])) 
  {
  	$startID = $objStructure->fnGetStartNodeID($_GET["parentID"]);
  }
  else if (is_numeric($_GET["ID"])) 
  {
  	$startID = $objStructure->fnGetStartNodeID($_GET["ID"]);
  }

  $recTree = $objStructure->fnGetNode($_GET["ID"], "navigate", $startID);
  $engSmarty->assign("recTree", $recTree);

  //$engSmarty->debug_tpl = "debug.tpl";
  //$engSmarty->debugging = 0;

  $engSmarty->assign("recStructure", $recStructure);
  $engSmarty->assign("arrTranslation", $arrTranslation);
  $engSmarty->assign("_GET", $_GET);
  $engSmarty->assign("RELATIVE_DIR", '/'.RELATIVE_DIR);
  $engSmarty->display("admin/pop.structure.tpl");
?>