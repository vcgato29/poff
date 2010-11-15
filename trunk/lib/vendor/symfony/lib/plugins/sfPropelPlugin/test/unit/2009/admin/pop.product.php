<?php
/**
 * Rakendus: lehe seadete hüpikaken
 *
 * Infovorm lehe seadmete muutmiseks
 * @package CMS_PAGE
 * @subpackage admin
 */
//ini_set('display_errors','1');
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
require_once(MODULE_DIR . "productcatalog/mod.product.inc");
require_once(MODULE_DIR . "productcatalog/mod.category.inc");
require_once(MODULE_DIR . "productcatalog/mod.variable.inc");
require_once(MODULE_DIR . "productcatalog/mod.product.substructure.inc");
require_once(MODULE_DIR . "ind_functions.inc");


$objStructure->fnInclude();

require_once(MODULE_DIR . "structure/mod.lang.inc");

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


	if (!$_GET["action"]) 
	{
		$_GET["action"] = "view";
	}

	$arrSetRights = $objUserRights->fnGetRights("", $_SESSION["user"]->ID);
	$arrGlobalRights = $objStructure->fnGetNode(1, "rights", "", "", $arrSetRights);

  $id = receiveVariablesInfo();

	if (@in_array($_GET["action"], array("update", "insert", "delete", "substructuredelete")))
	{
		if ($arrGlobalRights[5485] == "write") 
		{
      if (isset($_POST['screenings']))
      {
        updateScreenings($_POST['screenings']);
      }
      adminFormatForUpdate($_POST, $id);
			include(MODULE_DIR . "productcatalog/actions.product.inc");
		} 
		else 
		{
			$_GET["action"] = "view";
			$strError = $arrTranslation["structure"]["error"]["noprivileges"];
		}
	}
	
	if ($arrGlobalRights[5485] != "deny") 
	{
		include(MODULE_DIR . "productcatalog/actions.product.inc");
	}
	else 
	{
		$recProduct->recForm->boolClose = true;
	}
}
if ($strError) 
{
	$recProduct->recError->strError = $strError;
}
elseif($recError)
{
	$recProduct->recError->strError = $arrTranslation["structure"]["error"][$recError->type];
	if(is_array($recError->fields))
	{
		foreach($recError->fields as $errField)$recProduct->recError->$errField = "error";
	}
}
//$engSmarty->debugging = true;

$engSmarty->assign("directors", getDirectors());
$engSmarty->assign("countries", getCountries());
$engSmarty->assign("screenings", receiveScreeningsAdmin($_GET['ID']));
$engSmarty->assign("id", $id);

adminSplitMultipleData($recProduct, $id);

$engSmarty->assign("_GET", $_GET);
$engSmarty->assign("boolRefresh", $_GET["refresh"]);
$engSmarty->assign("arrTranslation", $arrTranslation);
$engSmarty->assign("recProduct", $recProduct);
$engSmarty->assign("RELATIVE_DIR", '/'.RELATIVE_DIR);
$engSmarty->display("admin/pop.product.tpl");

?>
