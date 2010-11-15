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
  require_once(MODULE_DIR . "productcatalog/mod.category.inc");
  require_once(MODULE_DIR . "productcatalog/mod.product.substructure.inc");

  if (!$objIPAccess->fnValidate($arrAllowIP["access"], $_SERVER["REMOTE_ADDR"]) or $objIPAccess->fnValidate($arrAllowIP["deny"], $_SERVER["REMOTE_ADDR"])) {
    $recStructure->boolClose = true;
  }


  if (!is_object($_SESSION["user"])) {
    $recStructure->boolClose = true;
  }


  if (!$recStructure->boolClose) 
  {
      require_once(CONFIG_DIR . $_SESSION["lang"] . ".translation.inc");

      $objStructure->fnInclude();
      $arrSetRights = $objUserRights->fnGetRights("", $_SESSION["user"]->ID);
      $arrGlobalRights = $objStructure->fnGetNode(1, "rights", "", "", $arrSetRights);

      if ((@in_array($_GET["action"], array("update", "delete", "insert")) and $arrGlobalRights[5485] == "write")) 
	  {
          include(MODULE_DIR . "productcatalog/actions.product.substructure.inc");
      } 
	  elseif (@in_array($_GET["action"], array("insert", "update", "delete"))) 
	  {
          $_GET["action"] = "view";
          $strError = $arrTranslation["error"]["noprivileges"];
		  $recStructure->boolClose = 1;
      }

      if (($_GET["ID"] and $arrGlobalRights[5485] != "deny") or ($_GET["parentID"] and $arrGlobalRights[5485] != "deny")) 
	  {
          include(MODULE_DIR . "productcatalog/actions.product.substructure.inc");
      } 
	  else 
	  {
          $recStructure->boolClose = 1;
      }
  }

  if ($strError) {
    $recStructure->recError->strError = $strError;
  }

  $engSmarty->debug_tpl = "debug.tpl";
  $engSmarty->debugging = 0;

  $engSmarty->assign("recStructure", $recStructure);
  $engSmarty->assign("_GET", $_GET);
  $engSmarty->display("admin/pop.structure.tpl");
  //printout($recNode);
?>
