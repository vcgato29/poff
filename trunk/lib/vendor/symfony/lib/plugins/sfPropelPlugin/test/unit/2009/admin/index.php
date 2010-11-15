<?php
require_once("../cfg/admin/pre.inc");
require_once(CONFIG_DIR . "lang.inc");
require_once(CONFIG_DIR . "access.inc");
require_once(MODULE_DIR . "access/class.IPAccess.inc");
require_once(INIT_DIR . "env.inc");
require_once(INIT_DIR . "db.inc");
require_once(MODULE_DIR . "user/mod.user.inc");
require_once(MODULE_DIR . "user/mod.usergroup.inc");
require_once(INIT_DIR . "smarty.inc");
//check if IP is banned
if (!$objIPAccess->fnValidate($arrAllowIP["access"], $_SERVER["REMOTE_ADDR"]) or $objIPAccess->fnValidate($arrAllowIP["deny"], $_SERVER["REMOTE_ADDR"])) 
{
	header("Location: " . LOGINCENTER_PATH);
	exit;
}

if (false == $_SESSION["lang"]) $_SESSION["lang"] = DEFAULT_LANG;
require_once(CONFIG_DIR . $_SESSION["lang"] . ".translation.inc");
//log out from admin
if ($_GET["action"] == "logout") 
{
	$objUser->fnLogout();
	$objUserLog->fnLogEvent("login", "logout");
	header("Location: " . LOGINCENTER_PATH);
	exit;
}

//not logged in, show login form
if (!is_object($_SESSION["user"]) || $_SESSION["user"]->realname == "anonymous")
{
	if (sizeof($_POST) > 0 ) 
	{
		$recInput->username = trim($_POST["formLogin_username"]);
		$recInput->password = trim($_POST["formLogin_password"]);
		
		if ($objUser->fnLogin($recInput->username, $recInput->password))
		{
			$objUserLog->fnLogEvent("login", "login");
			$loc =  SYSTEM_PATH."/admin/index.php";
			session_write_close();
			
			header("Location: " . $loc);
			exit;
		} 
		else 
		{
			$engSmarty->assign("error", 1);
		}
	}
	$engSmarty->assign("arrTranslation", $arrTranslation);
	$engSmarty->assign("RELATIVE_DIR", '/'.RELATIVE_DIR);
	$engSmarty->display("admin/login.tpl");
}
else
{
	$engSmarty->assign("RELATIVE_DIR", '/'.RELATIVE_DIR);
	$engSmarty->display("admin/index.tpl");
}
?>