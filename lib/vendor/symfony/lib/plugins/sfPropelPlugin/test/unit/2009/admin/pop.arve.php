<?php
/**
 * Rakendus: sisu frame, edasimuujad
 *
 * Struktuuri�hikute nimekirja kuvamine, otsingu vorm ning tulemuste kuvamine,
 * struktuuri�hikute lisamise, kopeerimise, liigutamise, kustutamise ning muutmise
 * navigeerimine
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
  require_once(MODULE_DIR . "statistics/mod.query.inc");
  require_once(MODULE_DIR . "ind_functions.inc");
  include_once(MODULE_DIR . "tellimus.inc");
  require_once(MODULE_DIR . "productcatalog/mod.product.inc");
	require_once(MODULE_DIR . "productcatalog/mod.category.inc");
	require_once(MODULE_DIR . "productcatalog/mod.variable.inc");
	require_once(MODULE_DIR . "productcatalog/mod.product.substructure.inc");
	require_once(MODULE_DIR . "phpmailer/class.phpmailer.php");
  if (!$objIPAccess->fnValidate($arrAllowIP["access"], $_SERVER["REMOTE_ADDR"]) or $objIPAccess->fnValidate($arrAllowIP["deny"], $_SERVER["REMOTE_ADDR"])) {
    header("Location: " . LOGINCENTER_PATH);
  }


  if (!is_object($_SESSION["user"])) {
    header("Location: " . LOGINCENTER_PATH);
  }
  	if ($_GET['tellimus']){
  		if ($_SESSION['email'][$_GET['tellimus']] && $_SESSION['email'][$_GET['tellimus']] > (time()-300) && $_GET['send'])
  		{
  			$engSmarty->display("admin/not_sended.tpl");
  			exit;
  		}
  		$change = get_tellimus($_GET['tellimus']);
  		$tellimus = $change[0];
  		$products = get_order_products($tellimus['id']);
  		if ($tellimus['bank_id'] == 5)
  		{
  			$installment[0] = $tellimus['installment_period'];
  			$installment[1] = $tellimus['installment_price'];
  		}
  	}
  	else
  	{
  		exit;
  	}
		
		$arrData->invoice = str_replace("Arve Nr:", "", $tellimus['explanation']);
		$arrData->date = date("d.m.Y", $tellimus['date_add_u']);
		
		if (!$installment)
			$arrData->total_price = $tellimus['total_price'];
		
		if (!$installment && !$banklink)
			$expire  = mktime(0, 0, 0, date("m", $tellimus['date_add_u'])  , date("d", $tellimus['date_add_u']) + 7, date("Y", $tellimus['date_add_u']));
		else
			$expire = $tellimus['date_add_u'];
		
		$arrData->date_expire = date("d.m.Y", $expire);
		$arrData->klient_nr = substr($tellimus['reference_number'], 0, 6);
		
		if ($installment)
			$arrData->type = "Otsekorralduslepinguga";
		else if($banklink)
			$arrData->type = "Makstud pangalingiga";
		else
			$arrData->type = "7 pv neto";
		
		$arrData->reference = $tellimus['reference_number'];
		if (trim($tellimus['company']))
			$arrData->address = trim($tellimus['company'])."<br>".$tellimus['address']."<br>".$tellimus['pindex']." ".$tellimus['city'];
		else
			$arrData->address = $tellimus['contact_name']."<br>".$tellimus['address']."<br>".$tellimus['pindex']." ".$tellimus['city'];
			
		if ($tellimus['transport'] != "1")
		{
			foreach ($products as $key => $tmp_product)
			{
				$changed_products[$key] = $tmp_product;
				$changed_products["transport".$key]['code'] = $tmp_product['code']."-PK";
				if ($tellimus['transport'] == "2")
					$changed_products["transport".$key]['name'] = "Saatmine kulleriga";
				if ($tellimus['transport'] == "3")
					$changed_products["transport".$key]['name'] = "Saatmine postiasutusest";
				
				$changed_products["transport".$key]['oneprice'] = $tmp_product['transport_price'];
				$changed_products["transport".$key]['amount'] = $tmp_product['amount'];
				$changed_products["transport".$key]['vat_value'] = "18%";
			}
			$products = $changed_products;
		}
		foreach ($products as $tmp_product)
		{
			$product->name = $tmp_product['name'];
			$product->price = $tmp_product['oneprice'];
			$product->qnt = $tmp_product['amount'];
			$product->code = $tmp_product['code'];
			$product->vat_value = $tmp_product['vat_value'];
			$arrData->installment = $installment;
			if ($installment)
			{
				$product->name = $tmp_product['name']."/OTSEKORRALDUS - ".$installment[0]." makset";
				$product->price = round($tmp_product['oneprice'] / $installment[0], 2);
			}
			$product->price_display = number_format ($product->price, 2, '.','');
			$product->price_without_vat = round($product->price/((int)$product->vat_value+100)*100, 2);
			$product->vat_price = $product->price - $product->price_without_vat;
			$product->total_price = $product->price*$product->qnt;
			$product->total_price_display = number_format ($product->total_price, 2, '.','');
			$arrData->products[] = $product;
			$arrData->total[(int)$product->vat_value]->total = $arrData->total[(int)$product->vat_value]->total + $product->price_without_vat*$product->qnt;
			$arrData->total[(int)$product->vat_value]->total_display = number_format ($arrData->total[(int)$product->vat_value]->total, 2, '.','');
			$arrData->total[(int)$product->vat_value]->tax = $product->vat_value;
			$arrData->total[(int)$product->vat_value]->tax_price = $arrData->total[(int)$product->vat_value]->tax_price + $product->vat_price*$product->qnt;
			$arrData->total[(int)$product->vat_value]->tax_price_display = number_format ($arrData->total[(int)$product->vat_value]->tax_price, 2, '.','');
			$arrData->total[(int)$product->vat_value]->total_with_tax = $arrData->total[(int)$product->vat_value]->total_with_tax + $product->price_without_vat*$product->qnt + $product->vat_price*$product->qnt;
			$arrData->total[(int)$product->vat_value]->total_with_tax_display = number_format ($arrData->total[(int)$product->vat_value]->total_with_tax, 2, '.','');
			if ($installment)
			{
				$arrData->total_price = $arrData->total_price + $product->price*$product->qnt;
			}
			unset($product);
		}
		$arrData->total_price_display = number_format ($arrData->total_price, 2, '.','');
		$arrData->total_vats = count($arrData->total)+2;
		$engSmarty->assign('arrData', $arrData);
	
  require_once(CONFIG_DIR . $_SESSION["lang"] . ".translation.inc");
		
		$strTemplate = "arve.tpl";
		
		$engSmarty->assign("arrProducts", $arrProducts);
		$engSmarty->assign("tellimus", $tellimus);
  /*
 	$engSmarty->debug_tpl = "debug.tpl";
	$engSmarty->debugging = 1;
	$engSmarty->error_reporting = 512;
	*/
  $engSmarty->assign("_GET", $_GET);
  
  $engSmarty->assign("arrTranslation", $arrTranslation);
  if (!$_GET['send'])
  {
  	$engSmarty->display($strTemplate);
  }
  else
  {
	  	$mailContentHtml = $engSmarty->fetch($strTemplate);
	  	$phpmailerObject = new PHPMailer();
	  	
	  	$phpmailerObject->IsSMTP();
		$phpmailerObject->IsHTML(true);
		$phpmailerObject->CharSet = 'UTF-8';
		$phpmailerObject->WordWrap = 64;
		
		$phpmailerObject->AddAddress($tellimus['email']);
		$phpmailerObject->From = "tellimus@tea.ee";
		$phpmailerObject->FromName = "=?utf-8?B?".base64_encode("TEA Kirjastus AS, E-Tellimiskeskus")."?=";
		$phpmailerObject->Body = $mailContentHtml;
		$phpmailerObject->Subject = "=?utf-8?B?".base64_encode($tellimus['explanation'])."?=";
		
		if ($phpmailerObject->Send()){
			$engSmarty->display("admin/sended.tpl");
			$_SESSION['email'][$_GET['tellimus']] = time();
		}else
			$engSmarty->display("admin/not_sended.tpl");
  }
?>
