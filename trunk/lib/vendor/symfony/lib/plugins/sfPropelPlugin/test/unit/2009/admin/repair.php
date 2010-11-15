<?php
	require_once("../cfg/admin/pre.inc");
	require_once(CONFIG_DIR . "access.inc");
	require_once(MODULE_DIR . "access/class.IPAccess.inc");
	require_once(INIT_DIR . "env.inc");
	require_once(INIT_DIR . "lang.inc");
	require_once(INIT_DIR . "db.inc");
	require_once(INIT_DIR . "smarty.inc");
	require_once(MODULE_DIR . "structure/mod.structure.inc");
	require_once(MODULE_DIR . "structure/mod.lang.inc");
	require_once(MODULE_DIR . "structure/mod.product.inc");
	require_once(MODULE_DIR . "user/mod.user.inc");
	require_once(MODULE_DIR . "user/mod.usergroup.inc");
	require_once(MODULE_DIR . "productcatalog/mod.category.inc");
	require_once(MODULE_DIR . "statistics/mod.query.inc");
	require_once(MODULE_DIR . "ind_functions.inc");
	require_once(MODULE_DIR . "productcatalog/mod.productamounts.inc");
	
	if (!$objIPAccess->fnValidate($arrAllowIP["access"], $_SERVER["REMOTE_ADDR"]) or $objIPAccess->fnValidate($arrAllowIP["deny"], $_SERVER["REMOTE_ADDR"])) {
	    header("Location: " . LOGINCENTER_PATH);
	}
	if (!is_object($_SESSION["user"])) {
	    header("Location: " . LOGINCENTER_PATH);
	}
	else
	{
		$xml = get_url_content("/ocra_4room/transport/xmlcore.asp?get=1&what=itemclass", "directo5.gate.ee", 443, "ssl://");
		if (!$xml)
			exit;
		
		$dom = new domDocument;
		$dom->loadXML($xml);
		if (!$dom) {
		    echo 'Error while parsing the document';
		    exit;
		}

		$s = simplexml_import_dom($dom);
		$tmp_arr = simplexml2array($s);
		//printout($tmp_arr);
		//exit;
		foreach ($tmp_arr["itemclasses"]["itemclass"] as $category){
			$recCat->code = $category["@attributes"]["code"];
			$recCat->name_est = $category["@attributes"]["default_name"];
			$recCat->master = $category["@attributes"]["master"];
			$recCat->masters = $category["@attributes"]["masters"];
			
			$arrCategories[$category["@attributes"]["code"]] = $recCat;
			unset($recCat);
		}
		
		$xml = get_url_content("/ocra_4room/transport/xmlcore.asp?get=1&what=item", "directo5.gate.ee", 443, "ssl://");
		$dom = new domDocument;
		$dom->loadXML($xml);
		if (!$dom) {
		    echo 'Error while parsing the document';
		    exit;
		}

		$s = simplexml_import_dom($dom);
		$tmp_arr = simplexml2array($s);
		//printout($tmp_arr);
		//exit;
		foreach ($tmp_arr["items"]["item"] as $product){
			$recProd->code = $product["@attributes"]["code"];
			$recProd->name_est = $product["@attributes"]["default_name"];
			$recProd->price = round($product["@attributes"]["retail_price"]);
			$recProd->special_price1 = $product["@attributes"]["special_price1"];
			$recProd->special_price2 = $product["@attributes"]["special_price2"];
			$recProd->category_name_id = $product["@attributes"]["class"];
			$recProd->on_purchase = $product["@attributes"]["on_purchase"];
			if (is_array($product["data"])){
				foreach($product["data"] as $parameters){
					if (is_array($parameters["@attributes"])){
						if ($parameters["@attributes"]["code"] == "ART_LANG"){
							$recProd->{"name_".strtolower($parameters["@attributes"]["param"])} = $parameters["@attributes"]["content"];
						}else{
							if ($parameters["@attributes"]["param"]){
								$recProd->params[$parameters["@attributes"]["code"]][$parameters["@attributes"]["param"]] = $parameters["@attributes"]["content"];
							}else
								$recProd->params[$parameters["@attributes"]["code"]] = $parameters["@attributes"]["content"];
						}
					}
				}
			}
			$arrProducts[$product["@attributes"]["code"]] = $recProd;
			unset($recProd);
		}
		
		foreach ($arrProducts as $product){
			if (is_object($arrCategories[$product->category_name_id])){
				$tmp_pr = $product;
				$arrCategories[$product->category_name_id]->products[] = $tmp_pr;
				unset($tmp_pr);
			}
		}
		
		foreach($arrCategories as $cat_key => $category){
			if (!is_array($category->products))
				unset($arrCategories[$cat_key]);
		}
		
		$cat = $objProductCategory->fnGetCategoryByName("directo");
		if (is_object($cat)){
			$cat_tree = $objProductCategory->fnGetCategoryTree($cat->ID);
			$languageList = $objLang->fnGetDataList("1=1","langcode,name");
			if (is_array($cat_tree)){
				foreach($cat_tree as $categories){
					if (array_key_exists($categories->name, $arrCategories))
						$arrAction[$categories->name] = $categories->ID;
				}
				foreach($arrCategories as $cat_key => $category){
					$recData->parentID = $cat->ID;
			  		$recData->name = $category->code;
			  		
					foreach($languageList as $languageItem){
						$recData->{"title_" . $languageItem->langcode} = $category->name_est;
					}
					if (!$arrAction[$category->code]){
						$recInsert = $objProductCategory->fnProcessData($recData, "insert");
						$newID = $objProductCategory->fnInsertData($recInsert);
						if ($newID){
							$arrCategories[$cat_key]->ID = $newID;
						}
					}else{
						$recData->ID = $arrAction[$category->code];
						$recUpdate = $objProductCategory->fnProcessData($recData, "update");
						$boolResult = $objProductCategory->fnUpdateData($recUpdate, "ID='" . $arrAction[$category->code] . "'");
						if ($boolResult)
							$arrCategories[$cat_key]->ID = $arrAction[$category->code];
					}
					unset($newID);
					unset($recInsert);
					unset($recData);
				}
			}
			
			foreach($arrCategories as $main_category_key => $category)
			{
					foreach($category->products as $prod_key => $product)
					{
						$products[$category->ID][$product->code] = $objProduct->fnGetDataList("name='".$product->code."'", "id", $objProduct->strTableName);
						if (count($products[$category->ID][$product->code]) == 1)
						{
							unset($products[$category->ID][$product->code]);
							continue;
						}
						else
						{
							foreach ($products[$category->ID][$product->code] as $pdr_key => $prd)
							{
								$connectedcategories = $objProductCategoryConnection->fnGetProductCategoryConnections($prd->id);
								foreach($connectedcategories as $cat_id => $selected)
								{
									$products[$category->ID][$product->code][$pdr_key]->categories[] = $cat_id;
								}
								if (count($products[$category->ID][$product->code][$pdr_key]->categories) == 1 && $products[$category->ID][$product->code][$pdr_key]->categories[0] == $category->ID)
								{
									$objProductAdmin->fnDeleteProduct($prd->id);
									unset($products[$category->ID][$product->code][$pdr_key]);
								}
							}
						}
					}
			}
			foreach ($products as $category => $productsToInsert)
			{
				if (count($productsToInsert))
				{
					foreach($productsToInsert as $code => $productArr)
					{
						$recInsertCategoryConnectionsObj->productID = $productArr[0]->id;
						$productArr[0]->categories[] = $category;
						$recInsertCategoryConnectionsObj->connections = $productArr[0]->categories;
						$objProductCategoryConnection->fnInsertProductCategoryConnections($recInsertCategoryConnectionsObj);
						unset($recInsertCategoryConnectionsObj);
					}
				}
			}
		}
	}
	echo "<br /><br /><br /><br /><br /><br /><center><span style='font-size:18px; font-family: Verdana;'>Andmed uuendatud.</span></center>";
?>