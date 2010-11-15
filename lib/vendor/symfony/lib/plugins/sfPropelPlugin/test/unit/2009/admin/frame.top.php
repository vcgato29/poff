<?php
/**
 * Rakendus: ülemine frame
 *
 * Kasutajavaate ülemine inforiba, kus kuvatakse kasutaja nimi, administreeritava
 * süsteemi http aadress ning samuti lingid abiinfo ja väljalogimisekraanile
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



  if (!$objIPAccess->fnValidate($arrAllowIP["access"], $_SERVER["REMOTE_ADDR"]) or $objIPAccess->fnValidate($arrAllowIP["deny"], $_SERVER["REMOTE_ADDR"])) {
    header("Location: " . LOGINCENTER_PATH);
  }


  if (!is_object($_SESSION["user"])) {
    header("Location: " . LOGINCENTER_PATH);
  }

  require_once(CONFIG_DIR . $_SESSION["lang"] . ".translation.inc");

  $recMain->site = str_replace(
                               array("http://", "https://"),
                               array("", ""),
                               CLIENT_PATH);
  $recMain->username = $_SESSION["user"]->realname;

  $engSmarty->assign("recMain", $recMain);
  $engSmarty->assign("arrTranslation", $arrTranslation);
  $engSmarty->display("admin/frame.top.tpl");
?>
