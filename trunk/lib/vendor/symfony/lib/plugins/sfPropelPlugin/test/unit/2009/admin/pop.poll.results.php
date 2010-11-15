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
require_once(MODULE_DIR . "structure/mod.comment.inc");
require_once(MODULE_DIR . "user/mod.usergroup.inc");

if (!$objIPAccess->fnValidate($arrAllowIP["access"], $_SERVER["REMOTE_ADDR"]) or $objIPAccess->fnValidate($arrAllowIP["deny"], $_SERVER["REMOTE_ADDR"]))
{
	$recStructure->boolClose = true;
}
if (!is_object($_SESSION["user"]))
{
	$recStructure->boolClose = true;
}
if (!$recStructure->boolClose)
{
	require_once(CONFIG_DIR . $_SESSION["lang"] . ".translation.inc");

	if (!$_GET["action"])
	{
		$_GET["action"] = "view";
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
		include(MODULE_DIR . "structure/actions.poll.results.inc");
	}
	else
	{
		$recStructure->boolClose = 1;
	}
}

if ($strError)
{
	$recStructure->recError->strError = $strError;
}

$recTree = $objStructure->fnGetNode($_GET["ID"], "navigate");
$engSmarty->assign("recTree", $recTree);

$engSmarty->debug_tpl = "debug.tpl";
$engSmarty->debugging = 0;

$engSmarty->assign("recStructure", $recStructure);
$engSmarty->assign("_GET", $_GET);
$engSmarty->assign("arrTranslation", $arrTranslation);
$engSmarty->display("admin/pop.poll.results.tpl");
?>
