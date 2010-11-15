<?php
/**
 * Rakendus: struktuuripuu
 *
 * Ssteemi struktuuri kuvamine ning navigatsioon
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
//require_once(MODULE_DIR . "sitevariables/mod.sitevariables.inc");

if (!$objIPAccess->fnValidate($arrAllowIP["access"], $_SERVER["REMOTE_ADDR"]) or $objIPAccess->fnValidate($arrAllowIP["deny"], $_SERVER["REMOTE_ADDR"])) 
{
	header("Location: " . LOGINCENTER_PATH);
	exit;
}

if (!is_object($_SESSION["user"])) 
{
	header("Location: " . LOGINCENTER_PATH);
	exit;
}
require_once(CONFIG_DIR . $_SESSION["lang"] . ".translation.inc");


if (!$_GET["ID"] or $arrGlobalRights[$_GET["ID"]] == "deny") 
{
	$_GET["ID"] = 1;
}

$objStructure->fnInclude();

$arrSetRights = $objUserRights->fnGetRights("", $_SESSION["user"]->ID);
$arrGlobalRights = $objStructure->fnGetNode(1, "rights", "", "", $arrSetRights);

$recTree = $objStructure->fnGetNode($_GET["ID"], "tree");

$engSmarty->assign("recTree", $recTree);
$engSmarty->assign("arrTranslation", $arrTranslation);
//$engSmarty->display("admin/frame.tree.tpl");
$output = $engSmarty->fetch("admin/frame.tree.tpl");
if (strstr($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip'))
{
	$gzip_size = strlen($output);
	$gzip_contents = "\x1f\x8b\x08\x00\x00\x00\x00\x00".
		substr(gzcompress($output, 3), 0, - 4).
		pack('V', crc32($output)).
		pack('V', $gzip_size);
	header('Content-Encoding: gzip');
	header('Content-Length: '.strlen($gzip_contents));
	echo $gzip_contents;
}
else
{
	header('Content-Length: '.strlen($output));
	echo $output;
}
?>