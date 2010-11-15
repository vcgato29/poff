<?php
/**
 * Rakendus: lehe seadete hüpikaken
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
  require_once(MODULE_DIR . "productcatalog/mod.product.inc");
  require_once(MODULE_DIR . "productcatalog/mod.category.inc");
  require_once(MODULE_DIR . "productcatalog/mod.variable.inc");
  require_once(MODULE_DIR . "productcatalog/mod.productamounts.inc");

  $productID = $_GET["productID"];

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

    if ($arrGlobalRights[5485] != "deny") 
	{

		if(isSet($_POST["amounts"]))
		{
			foreach($_POST["amounts"] as $key => $amount)
			{
				//$key = $productID
				$GLOBALS['objProductAmounts']->clearProductAmounts($key);
				$GLOBALS['objProductAmounts']->setProductAmount($key, $amount);
			}
		}
		$recData = $objProductAdmin->fnGetProductList();
		foreach($recData->arrData as $key => $val){
			$arrItem[$val->ID]['amount'] = $GLOBALS['objProductAmounts']->fnGetProductAmount($val->ID);
			$arrItem[$val->ID]['info'] = $recData->arrData[$key];
		}
		if(is_array($arrItem))
		{
			$engSmarty->assign("arrItem", $arrItem);
		}

    } else {
      $recProductAmounts->recForm->boolClose = true;
    }
  }
  if ($strError) {
    $recProductAmounts->recError->strError = $strError;
  }
  elseif($recError)
  {
    $recProductAmounts->recError->strError = $arrTranslation["structure"]["error"][$recError->type];
	if(is_array($recError->fields))
	{
	    foreach($recError->fields as $errField)$recProductAmounts->recError->$errField = "error";
	}
  }
  $engSmarty->assign("_GET", $_GET);
  $engSmarty->assign("boolRefresh", $_GET["refresh"]);
  $engSmarty->assign("recProductAmounts", $recProductAmounts);
  $engSmarty->display("admin/pop.productamounts.tpl");
?>
