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
			$recProd->price = $product["@attributes"]["base_price"];
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
			}else{
				//First insert
				foreach($arrCategories as $cat_key => $category){
					$recData->parentID = $cat->ID;
			  		$recData->name = $category->code;
			  		
					foreach($languageList as $languageItem){
						$recData->{"title_" . $languageItem->langcode} = $category->name_est;
					}
					$recInsert = $objProductCategory->fnProcessData($recData, "insert");
					$newID = $objProductCategory->fnInsertData($recInsert);
					if ($newID){
						$arrCategories[$cat_key]->ID = $newID;
					}
					unset($newID);
					unset($recInsert);
					unset($recData);
				}
			}
			
			$languageList = $objLang->fnGetDataList("1=1","langcode,name");
			$variables = $objProductVariable->fnGetVariableList();
			$variables = $variables->arrData;
			
			foreach($arrCategories as $main_category_key => $category){
				$arrProducts = $objProduct->fnGetCategoryProductList($category->ID);
				if ($arrProducts == "0"){
					foreach($category->products as $prod_key => $product){
						
						$recData->name = $product->code;
						
						foreach($languageList as $languageItem){
							if ($product->{"name_" . $languageItem->langcode})
								$recData->{"title_" . $languageItem->langcode} = $product->{"name_" . $languageItem->langcode};
							else
								$recData->{"title_" . $languageItem->langcode} = $product->name_est;
						}
						
						$recData->price = $product->price;
						$recReturn->modifier = "Crontab";
						$recData->onfirstpage = "N";

						$recInsert = $objProductAdmin->fnProcessData($recData, "insert");
						$newID = $objProductAdmin->fnInsertData($recInsert);
						if ($newID){
							$product->ID = $newID;
							foreach($variables as $vars){
								if ($product->{$vars->name} || $product->{$vars->name} === "0"){
									$recInsertVariables[$vars->ID][1]["value_est"] = $product->{$vars->name};
								}else if ($product->params[strtoupper($vars->name)] && !is_array($product->params[strtoupper($vars->name)])){
									$recInsertVariables[$vars->ID][1]["value_est"] = $product->params[strtoupper($vars->name)];
								}elseif($product->params[strtoupper($vars->name)] && is_array($product->params[strtoupper($vars->name)])){
									$recInsertVariables[$vars->ID][1]["value_est"] = array_pop($product->params[strtoupper($vars->name)]);
								}
							}
							$recInsertVariablesObj->productID = $newID;
							$recInsertVariablesObj->files = $_FILES;
							$recInsertVariablesObj->variables = $recInsertVariables;
							$objProductValue->fnInsertValues($recInsertVariablesObj);
							
							$recInsertCategoryConnectionsObj->productID = $newID;
							$recInsertCategoryConnectionsObj->connections[] = $category->ID;
							$objProductCategoryConnection->fnInsertProductCategoryConnections($recInsertCategoryConnectionsObj);
							unset($recInsertCategoryConnectionsObj);
							unset($recInsertVariablesObj);
							unset($recInsertVariables);
						}
					}
				}else{
					//printout($arrProducts);
					foreach($arrProducts as $product){
						$tmprecItem = $objProductAdmin->fnGetProduct($product->ID);
						$recItem = $tmprecItem->arrData;
						unset($tmprecItem);
						foreach($category->products as $prod_key => $product_ext){
							if ($recItem->name == $product_ext->code){
								$curent_prod = clone $product_ext;
								foreach($languageList as $languageItem){
									if ($product_ext->{"name_" . $languageItem->langcode})
										$recItem->{"title_" . $languageItem->langcode} = $product_ext->{"name_" . $languageItem->langcode};
								}
								
								$recItem->price = $product_ext->price;
								$recItem->modifier = "Crontab";
								
								$recUpdate = $objProductAdmin->fnProcessData($recItem, "update");
								unset($recItem);
								$last_prod_key = $prod_key;
								break;
							}
						}
						$arrCategories[$main_category_key]->notUpdated = sizeof($arrCategories[$main_category_key]->products);
						if (!isset($recUpdate)){
							continue;
						}
						unset($arrCategories[$main_category_key]->products[$last_prod_key]);
						unset($last_prod_key);
						$arrCategories[$main_category_key]->notUpdated = sizeof($arrCategories[$main_category_key]->products);
						$recUpdate->last_modified = date("Y") . "-" . date("m") . "-" . date("d") . " " . date("H") . ":" . date("i") . ":" . date("s");
		
						$boolResult = $objProductAdmin->fnUpdateData($recUpdate, "ID='" . $product->ID . "'");
						
						unset($recUpdate);
						if ($boolResult){
							$variable_obj = $objProductVariable->fnGetVariableList();
							$variableList = $variable_obj->arrData;
							
							if(is_array($variableList))
							{
								//foreach($variableList as $variable)
								while (list(, $variable) = each($variableList)) 
								{
									switch($variable->type)
									{
										case "select":
											$value = $objProductValue->fnGetValue($product->ID, $variable->ID);
											$recInsertVariables[$variable->ID][2][] = $value->value_id;
											break;
											
										case "selectmultiple":
											$value = $objProductValue->fnGetValue($product->ID, $variable->ID);
											$recInsertVariables[$variable->ID][2] = $value->value_id;
											break;
											
										case "text":
										
										case "textarea":
										
											if($variable->multiple == "N"){
												if ($curent_prod->{$variable->name} || $curent_prod->{$variable->name} === "0"){
													$recInsertVariables[$variable->ID][1]["value_est"] = $curent_prod->{$variable->name};
												}else if ($curent_prod->params[strtoupper($variable->name)] && !is_array($curent_prod->params[strtoupper($variable->name)])){
													$recInsertVariables[$variable->ID][1]["value_est"] = $curent_prod->params[strtoupper($variable->name)];
												}elseif($curent_prod->params[strtoupper($variable->name)] && is_array($curent_prod->params[strtoupper($variable->name)])){
													$recInsertVariables[$variable->ID][1]["value_est"] = array_pop($curent_prod->params[strtoupper($variable->name)]);
												}else{
													$value = $objProductValue->fnGetValue($product->ID, $variable->ID);
													$recInsertVariables[$variable->ID][1]["value_" . DEFAULT_LANG] = $value->{"value_" . DEFAULT_LANG};
												}
											}else{
												foreach($languageList as $languageItem){
													$value = $objProductValue->fnGetValue($product->ID, $variable->ID);
													$recInsertVariables[$variable->ID][1]["value_" . $languageItem->langcode] = $value->{"value_" . $languageItem->langcode};
												}
											}
											break;
												
										case "checkbox":
											$value = $objProductValue->fnGetValue($product->ID, $variable->ID);
											$recInsertVariables[$variable->ID]["boolean"] = $value->value_boolean;
											break;
									}
								}
							}
							/* -- external defined variables end -- */
							
							/* -- categories list start -- */
							$connectedcategories = $objProductCategoryConnection->fnGetProductCategoryConnections($product->ID);
							foreach($connectedcategories as $cat_id => $selected){
								$arrConnCategory[] = $cat_id;
							}
							
							/* -- categories list end -- */
							
							$recInsertVariablesObj->productID = $product->ID;
							$recInsertVariablesObj->files = $_FILES;
							$recInsertVariablesObj->variables = $recInsertVariables;
							$objProductValue->fnInsertValues($recInsertVariablesObj);
							
							$recInsertCategoryConnectionsObj->productID = $product->ID;
							$recInsertCategoryConnectionsObj->connections = $arrConnCategory;
							
							$objProductCategoryConnection->fnInsertProductCategoryConnections($recInsertCategoryConnectionsObj);
							unset($recInsertCategoryConnectionsObj);
							unset($recInsertVariablesObj);
							unset($recInsertVariables);
							unset($arrConnCategory);
						}
						//printout($newRecItem);
					}
					if ($arrCategories[$main_category_key]->notUpdated > 0){
						foreach($category->products as $prod_key => $product){
							$recData->name = $product->code;
							
							foreach($languageList as $languageItem){
								if ($product->{"name_" . $languageItem->langcode})
									$recData->{"title_" . $languageItem->langcode} = $product->{"name_" . $languageItem->langcode};
								else
									$recData->{"title_" . $languageItem->langcode} = $product->name_est;
							}
							
							$recData->price = $product->price;
							$recReturn->modifier = "Crontab";
							$recData->onfirstpage = "N";

							$recInsert = $objProductAdmin->fnProcessData($recData, "insert");
							$newID = $objProductAdmin->fnInsertData($recInsert);
							if ($newID){
								$product->ID = $newID;
								foreach($variables as $vars){
									if ($product->{$vars->name} || $product->{$vars->name} === "0"){
										$recInsertVariables[$vars->ID][1]["value_est"] = $product->{$vars->name};
									}else if ($product->params[strtoupper($vars->name)] && !is_array($product->params[strtoupper($vars->name)])){
										$recInsertVariables[$vars->ID][1]["value_est"] = $product->params[strtoupper($vars->name)];
									}elseif($product->params[strtoupper($vars->name)] && is_array($product->params[strtoupper($vars->name)])){
										$recInsertVariables[$vars->ID][1]["value_est"] = array_pop($product->params[strtoupper($vars->name)]);
									}
								}
								$recInsertVariablesObj->productID = $newID;
								$recInsertVariablesObj->files = $_FILES;
								$recInsertVariablesObj->variables = $recInsertVariables;
								$objProductValue->fnInsertValues($recInsertVariablesObj);
								
								$recInsertCategoryConnectionsObj->productID = $newID;
								$recInsertCategoryConnectionsObj->connections[] = $category->ID;
								$objProductCategoryConnection->fnInsertProductCategoryConnections($recInsertCategoryConnectionsObj);
								unset($recInsertCategoryConnectionsObj);
								unset($recInsertVariablesObj);
								unset($recInsertVariables);
								unset($arrCategories[$main_category_key]->products[$prod_key]);
							}
						}
						$arrCategories[$main_category_key]->notUpdated = sizeof($arrCategories[$main_category_key]->products);
					}
				}
			}
		}
	}
	echo "<br /><br /><br /><br /><br /><br /><center><span style='font-size:18px; font-family: Verdana;'>Andmed uuendatud.</span></center>";
?>