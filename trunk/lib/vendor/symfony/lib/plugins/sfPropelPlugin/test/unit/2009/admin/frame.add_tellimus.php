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

  if (!$objIPAccess->fnValidate($arrAllowIP["access"], $_SERVER["REMOTE_ADDR"]) or $objIPAccess->fnValidate($arrAllowIP["deny"], $_SERVER["REMOTE_ADDR"])) {
    header("Location: " . LOGINCENTER_PATH);
  }


  if (!is_object($_SESSION["user"])) {
    header("Location: " . LOGINCENTER_PATH);
  }
  	if ($_GET['tellimus']){
  		$change = get_tellimus($_GET['tellimus']);
  		$change_tellimus = $change[0];
  		$tellimus->id = $change_tellimus['id'];
  		$tellimus->viitenumber = $change_tellimus['reference_number'];
  		$tellimus->explanation = $change_tellimus['explanation'];
  		$tellimus->products = get_order_products($tellimus->id);
  	}
  	if ($_SESSION['order_changed'] == 1)
  	{
  		$tellimus->changes_applayed = 1;
  		unset($_SESSION['order_changed']);
  	}
  	if ($_SESSION['order_added'] == 1)
  	{
  		$tellimus->order_added = 1;
  		unset($_SESSION['order_added']);
  	}
  	$arrUsers = $objUser->fnGetUserList(0, "client");
  	$tellimus->arrUsers = $arrUsers->arrData;
	
	$arrProducts = $objProductAdmin->fnGetProductList();
	$arrProducts = $arrProducts->arrData;
	
	if ($_POST['transport'])
		$tellimus->transport = $_POST['transport'];
	else if($tellimus->id)
		$tellimus->transport = $change_tellimus['transport'];
		
	if ($_POST['bank_id'])
		$tellimus->bank_id = $_POST['bank_id'];
	else if($tellimus->id)
		$tellimus->bank_id = $change_tellimus['bank_id'];
	
	if ($_POST['period'])
		$tellimus->period = $_POST['period'];
	else if($tellimus->id)
		$tellimus->period = $change_tellimus['installment_period'];
	
	if ($_POST['order_user'])
		$tellimus->order_user = $_POST['order_user'];
	else if($tellimus->id)
		$tellimus->order_user = $change_tellimus['user_id'];
	
	if ($_POST['old_user'])
		$tellimus->old_user = $_POST['old_user'];
	else if($tellimus->id)
		$tellimus->old_user = $change_tellimus['user_id'];
	
	if ($_POST['name'])
		$tellimus->name = $_POST['name'];
	else if($tellimus->id)
		$tellimus->name = $change_tellimus['contact_name'];
		
	if (isset($_POST['r_name']))
		$tellimus->r_name = $_POST['r_name'];
	else if($tellimus->id)
		$tellimus->r_name = $change_tellimus['reciever_name'];
	
	if (isset($_POST['company']))
		$tellimus->company = $_POST['company'];
	else if($tellimus->id)
		$tellimus->company = $change_tellimus['company'];
	
	if (isset($_POST['r_company']))
		$tellimus->r_company = $_POST['r_company'];
	else if($tellimus->id)
		$tellimus->r_company = $change_tellimus['reciever_company'];
	
	if ($_POST['email'])
		$tellimus->email = $_POST['email'];
	else if($tellimus->id)
		$tellimus->email = $change_tellimus['email'];
	
	if ($_POST['phone'])
		$tellimus->phone = $_POST['phone'];
	else if($tellimus->id)
		$tellimus->phone = $change_tellimus['telefon'];
	
	if (isset($_POST['r_phone']))
		$tellimus->r_phone = $_POST['r_phone'];
	else if($tellimus->id)
		$tellimus->r_phone = $change_tellimus['reciever_phone'];
	
	if ($_POST['address'])
		$tellimus->address = $_POST['address'];
	else if($tellimus->id)
		$tellimus->address = $change_tellimus['address'];
	
	if (isset($_POST['r_address']))
		$tellimus->r_address = $_POST['r_address'];
	else if($tellimus->id)
		$tellimus->r_address = $change_tellimus['reciever_address'];
	
	if ($_POST['city'])
		$tellimus->city = $_POST['city'];
	else if($tellimus->id)
		$tellimus->city = $change_tellimus['city'];
	
	if (isset($_POST['r_city']))
		$tellimus->r_city = $_POST['r_city'];
	else if($tellimus->id)
		$tellimus->r_city = $change_tellimus['reciever_city'];
	
	if (isset($_POST['pindex']))
		$tellimus->pindex = $_POST['pindex'];
	else if($tellimus->id)
		$tellimus->pindex = $change_tellimus['pindex'];
	
	if (isset($_POST['r_index']))
		$tellimus->r_index = $_POST['r_index'];
	else if($tellimus->id)
		$tellimus->r_index = $change_tellimus['reciever_index'];
	
	if ($tellimus->order_user)
	{
		foreach ($tellimus->arrUsers as $order_user)
		{
			if ($order_user->ID == $tellimus->order_user)
			{
				$tellimus->order_user_code = $order_user->code;
				if (!$tellimus->name || ($tellimus->name && $tellimus->old_user != $tellimus->order_user))
					$tellimus->name = $order_user->realname;
				if (!isset($tellimus->company) || (isset($tellimus->company) && $tellimus->old_user != $tellimus->order_user))
					$tellimus->company = $order_user->company;
				if (!$tellimus->email || ($tellimus->email && $tellimus->old_user != $tellimus->order_user))
					$tellimus->email = $order_user->email;
				if (!$tellimus->phone || ($tellimus->phone && $tellimus->old_user != $tellimus->order_user))
					$tellimus->phone = $order_user->phone;
				if (!$tellimus->address || ($tellimus->address && $tellimus->old_user != $tellimus->order_user))
					$tellimus->address = $order_user->address;
				if (!$tellimus->city || ($tellimus->city && $tellimus->old_user != $tellimus->order_user))
					$tellimus->city = $order_user->city;
				if (!isset($tellimus->pindex) || (isset($tellimus->pindex) && $tellimus->old_user != $tellimus->order_user))
					$tellimus->pindex = $order_user->pindex;
				break;
			}
		}
	}
	$tellimus->old_user = $tellimus->order_user;
	if (!$tellimus->name || !$tellimus->address || !$tellimus->email || !$tellimus->phone || !$tellimus->city || !$tellimus->bank_id || !$tellimus->transport || ($tellimus->bank_id == "5" && ($tellimus->period < 2 || !$tellimus->period)))
		$error = 1;
	
	if ($tellimus->products)
	{
		if (!$_POST['products'])
		{
			foreach($arrProducts as $product)
			{
				foreach($tellimus->products as $keytell => $tell_prod)
				{
					if ($product->ID == $tell_prod['productID'])
					{
						$_POST['products'][] = $product->ID;
						$_POST['qnt'][$product->ID] = $tell_prod['amount'];
						$_POST['price'][$product->ID] = $tell_prod['oneprice'];
						$_POST['vat'][$product->ID] = $tell_prod['vat_value'];
						$_POST['transport_price'][$product->ID] = $tell_prod['transport_price'];
					}
				}
			}
		}
	}
	
	if ($_POST['products'])
	{
		foreach($arrProducts as $product)
		{
			if (in_array($product->ID, $_POST['products']))
			{
				if ($_POST['qnt'][$product->ID])
					$product->qnt = $_POST['qnt'][$product->ID];
				if ($_POST['price'][$product->ID])
					$product->price = $_POST['price'][$product->ID];
				if ($_POST['vat'][$product->ID])
					$product->vat = $_POST['vat'][$product->ID];
				if ($_POST['transport_price'][$product->ID])
					$product->transport_price = $_POST['transport_price'][$product->ID];
				if ($tellimus->transport == "1")
					$product->transport_price = 0;
				if ((!$product->transport_price && $product->transport_price !== 0) || !$product->vat || !$product->qnt){
					$error = 1;
				}
				$total_price = $total_price + $product->qnt*($product->price + $product->transport_price);
				$total_transport_price = $total_transport_price + $product->qnt*$product->transport_price;
				$tellimus->tooted[$product->ID] = $product;
				$strReturn .= $product->name. ' / ' .$product->title." / ".$product->qnt."tk / ".$product->price." EEK / Kokku: ".round($product->price*$product->qnt, 2)." EEK<br>";
				
				
				$products[$product->ID]->code = $product->name;
					$products[$product->ID]->name = $product->title;
					$products[$product->ID]->qnt = $product->qnt;
					$products[$product->ID]->price = $_POST['price'][$product->ID];
					$products[$product->ID]->transport_price = $product->transport_price;
					$products[$product->ID]->vat_value = $_POST['vat'][$product->ID];
				
			}
		}
	}
	if (count($products) > 1 && $tellimus->bank_id == "5")
	{
		$error = 1;
		$tellimus->bank_id = null;
	}
	if ($_POST['save_to_system'] && count($products) && !$error)
	{
		if ($tellimus->order_user)
		{
			$recUser->ID = $tellimus->order_user;
			$recUser->code = $tellimus->order_user_code;
		}
		else
		{
			$recUser->ID = 0;
			$recUser->code = 1;
		}
		if (!$tellimus->id)
		{
			$tellimusID = add_tellimus($recUser->ID, $_POST['name'], $_POST['address'], $_POST['city'], $_POST['pindex'], $_POST['company'], $_POST['email'], $_POST['phone'], $strReturn, $total_price, $tellimus->bank_id, $tellimus->transport, $total_transport_price, $_POST['r_name'], $_POST['r_phone'], $_POST['r_address'], $_POST['r_city'], $_POST['r_index'], $_POST['r_company']);
			$tellimusHash = sha1($_SERVER['REMOTE_ADDR'] . "_" . $tellimusID);
			$explanation = "Arve Nr: " . date("d.m.Y") . "-" . $tellimusID;
			add_tellimus_hash($tellimusID, $tellimusHash, $explanation);
			$reference_number = generate_reference_number($tellimusID, $_POST['bank_id'], $recUser);
			add_viitenumber($tellimusID, $reference_number);
			if ($tellimus->bank_id == "5")
			{
				$installment[0] = $tellimus->period;
				$installment[1] = round($total_price/$tellimus->period, 2);
				add_tellimus_installment($tellimusID, $installment[0], $installment[1]);
				
			}
			
			set_order_products($tellimusID, $products);
			$_SESSION['order_added'] = 1;
			$tellimus->id = $tellimusID;
		}
		else
		{
			update_tellimus($tellimus->id, $recUser->ID, $_POST['name'], $_POST['address'], $_POST['city'], $_POST['pindex'], $_POST['company'], $_POST['email'], $_POST['phone'], $strReturn, $total_price, $tellimus->bank_id, $tellimus->transport, $total_transport_price, $_POST['r_name'], $_POST['r_phone'], $_POST['r_address'], $_POST['r_city'], $_POST['r_index'], $_POST['r_company']);
			
			$reference_number = generate_reference_number($tellimus->id, $_POST['bank_id'], $recUser);
			add_viitenumber($tellimus->id, $reference_number);
			
			if ($tellimus->bank_id == "5")
			{
				$installment[0] = $tellimus->period;
				$installment[1] = round($total_price/$tellimus->period, 2);
				add_tellimus_installment($tellimus->id, $installment[0], $installment[1]);
			}
			
			delete_tellimus_products($tellimus->id);
			set_order_products($tellimus->id, $products);
			$_SESSION['order_changed'] = 1;
		}
		
		header("location: frame.add_tellimus.php?tellimus=".$tellimus->id);
		exit;
	}
	else if ($_POST['save_to_system'])
	{
		$engSmarty->assign("strError", "Palun t&auml;itke k&otilde;ik vajalik lahtrid!");
	}
	
  require_once(CONFIG_DIR . $_SESSION["lang"] . ".translation.inc");
		
		$strTemplate = "content.add_tellimus.tpl";
		
		$engSmarty->assign("arrProducts", $arrProducts);
		$engSmarty->assign("tellimus", $tellimus);
  /*
 	$engSmarty->debug_tpl = "debug.tpl";
	$engSmarty->debugging = 1;
	$engSmarty->error_reporting = 512;
	*/
  $engSmarty->assign("_GET", $_GET);
  $engSmarty->assign("boolRefreshTree", $_GET["refreshtree"]);
  $engSmarty->assign("arrTranslation", $arrTranslation);
  $engSmarty->display("admin/" .$strTemplate);

?>
