<?php
/**
* Rakendus: �ldine
*
* <i>CMS CLIENT</i> s�steemi keskne rakendus, l�bi mille toimub p�hiline
* infovahetus s�steemi kasutajaga. Rakendus kontrollib kasutaja sisendit,
* t��tleb ning kuvab vastavalt sellele soovitud ekraanivaate.
* @package CMS_PAGE
* @subpackage public
*/

ini_set('display_errors','0');
ini_set('pcre.backtrack_limit','1000000');

require_once("cfg/pre.inc");
require_once(CONFIG_DIR . "access.inc");
require_once(MODULE_DIR . "access/class.IPAccess.inc");
require_once(INIT_DIR . "env.inc");
require_once(INIT_DIR . "lang.inc");
require_once(INIT_DIR . "db.inc");
require_once(INIT_DIR . "smarty.inc");
require_once(MODULE_DIR . "structure/mod.structure.inc");
require_once(MODULE_DIR . "user/mod.user.inc");
require_once(MODULE_DIR . "user/mod.usergroup.inc");
require_once(MODULE_DIR . "productcatalog/mod.category.inc");
require_once(MODULE_DIR . "statistics/mod.query.inc");
require_once(MODULE_DIR . "ind_functions.inc");
require_once(MODULE_DIR . "phpmailer/class.phpmailer.php");

//check if user IP has rights to see the page
if ($objIPAccess->fnValidate($arrAllowIP["access"], $_SERVER["REMOTE_ADDR"]) && !$objIPAccess->fnValidate($arrAllowIP["deny"], $_SERVER["REMOTE_ADDR"]))
{
	$objStructure->fnInclude();
	
	if (!isset($_SESSION["lang"]))
	{
		$_SESSION["lang"] = DEFAULT_LANG;
	}
	$productsLink = $_SESSION["productsLink"];
	require_once(CONFIG_DIR . $_SESSION["lang"] . ".translation.inc");
	$engSmarty->assign("arrTranslation", $arrTranslation);
	require_once(MODULE_DIR . "structure/actions.userinit.inc");
	$recNode = $objStructure->fnGetNodeByPath($_SESSION["lang"]);
	require_once(MODULE_DIR . "structure/actions.ajax_search.inc");
	$strTemplate = "content.ajax_search.tpl";
	$engSmarty->assign("searchString", $searchString);
	$engSmarty->assign("recSearch", $recSearch);
	$engSmarty->assign('SYSTEM_PATH', SYSTEM_PATH);
	$engSmarty->display($strTemplate);
}
?>