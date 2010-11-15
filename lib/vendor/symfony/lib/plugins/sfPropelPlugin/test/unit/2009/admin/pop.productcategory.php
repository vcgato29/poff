<?php
/**
 * Rakendus: lehe seadete h�pikaken
 *
 * Infovorm lehe seadmete muutmiseks
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
  require_once(MODULE_DIR . "productcatalog/mod.category.inc");
  require_once(MODULE_DIR . "productcatalog/mod.product.inc");
  require_once(MODULE_DIR . "structure/mod.lang.inc");
  require_once(MODULE_DIR . "structure/mod.product.inc");
  require_once(MODULE_DIR . "ind_functions.inc");


  if (!$objIPAccess->fnValidate($arrAllowIP["access"], $_SERVER["REMOTE_ADDR"]) or $objIPAccess->fnValidate($arrAllowIP["deny"], $_SERVER["REMOTE_ADDR"])) {
    $boolClose = true;
  }


  if (!is_object($_SESSION["user"])) {
    $boolClose = true;
  }


  if (!$boolClose) {
    require_once(CONFIG_DIR . $_SESSION["lang"] . ".translation.inc");


    if (!$_GET["action"]) {
      $_GET["action"] = "view";
    }

    $arrSetRights = $objUserRights->fnGetRights("", $_SESSION["user"]->ID);
    $arrGlobalRights = $objStructure->fnGetNode(1, "rights", "", "", $arrSetRights);

    if (@in_array($_GET["action"], array("update", "insert", "delete"))) {
      if ($arrGlobalRights[5420] == "write") {
        include(MODULE_DIR . "productcatalog/actions.category.inc");
      } else {
        $_GET["action"] = "view";
        $strError = $arrTranslation["structure"]["error"]["noprivileges"];
      }
    }
    if ($arrGlobalRights[5420] != "deny") {
      include(MODULE_DIR . "productcatalog/actions.category.inc");
    } else {
      $recProductCategory->recForm->boolClose = true;
    }
  }
  if ($strError) {
    $recProductCategory->recError->strError = $strError;
  }
  elseif($recError)
  {
    $recProductCategory->recError->strError = $arrTranslation["structure"]["error"][$recError->type];
  }
  $catProducts = $objProduct->fnGetCategoryProductList($_GET["ID"]);
  if (is_array($catProducts) && count($catProducts))
  	$engSmarty->assign("recProductCategoryProducts", $catProducts);

  $engSmarty->assign("_GET", $_GET);
  $engSmarty->assign("boolRefresh", $_GET["refresh"]);
  $engSmarty->assign("recProductCategory", $recProductCategory);
  $engSmarty->assign("arrTranslation", $arrTranslation);
  //printout($recProductCategory);
  //$engSmarty->debugging = true;
  $engSmarty->display("admin/pop.productcategory.tpl");
?>
