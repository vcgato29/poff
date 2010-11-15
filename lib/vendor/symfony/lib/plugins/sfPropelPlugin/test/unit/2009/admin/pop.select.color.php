<?php
/**
 * Rakendus: lehe seadete hüpikaken
 *
 * V&auml;rvi valik
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
  require_once(MODULE_DIR . "user/mod.usergroup.inc");
  require_once(MODULE_DIR . "structure/mod.structure.inc");
  //require_once(MODULE_DIR . "productcatalog/mod.category.inc");
  //require_once(MODULE_DIR . "structure/mod.lang.inc");

	$colors_arr = Array(
		'row1' => Array(Array('c4cbe8','a7b0db'), Array('cdf18d','b2e615'), Array('eec56b','ffad00')),
		'row2' => Array(Array('d36a93','c9467a'), Array('e77366','d94225'), Array('81a05c','526629')),
		'row3' => Array(Array('80bbdb','308bdc'), Array('90c2cb','70b2be'), Array('',''))
	
	);
	
  if (!$objIPAccess->fnValidate($arrAllowIP["access"], $_SERVER["REMOTE_ADDR"]) or $objIPAccess->fnValidate($arrAllowIP["deny"], $_SERVER["REMOTE_ADDR"])) {
    $boolClose = true;
  }


  if (!is_object($_SESSION["user"])) {
    $boolClose = true;
  }

  $engSmarty->assign("colors_arr", $colors_arr);
  $engSmarty->assign("boolClose", $boolClose);
  
  $engSmarty->display("admin/pop.select.color.tpl");
?>
