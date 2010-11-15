<?php
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
	require_once(MODULE_DIR . "productcatalog/mod.category.inc");
	require_once(MODULE_DIR . "productcatalog/mod.variable.inc");
	require_once(MODULE_DIR . "productcatalog/mod.product.inc");
	require_once(MODULE_DIR . "statistics/mod.query.inc");
	require_once(MODULE_DIR . "ind_functions.inc");

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


	$_GET["ID"] = (int) $_GET["ID"];
	$objStructure->fnInclude();
	$arrSetRights = $objUserRights->fnGetRights("", $_SESSION["user"]->ID);
	$arrGlobalRights = $objStructure->fnGetNode(1, "rights", "", "", $arrSetRights);

	if (!$_GET["ID"] or $arrGlobalRights[$_GET["ID"]] == "deny") 
	{
		echo "<script>window.close();</script>";
		exit;
	}

	$recNode = $objStructure->fnGetDataRecord("ID='" . $_GET["ID"] . "'");

	if (is_object($recNode))
	{
		switch ($recNode->type) 
		{
			case "users":
				$recData = $objUser->fnGetUserList($_GET["ID"], "admin", $_GET["sortColumn"], $_GET["sortOrder"]);
				$results = $recData->arrData;
				break;

			case "clients":
				$recData = $objUser->fnGetUserList($_GET["ID"], "client", $_GET["sortColumn"], $_GET["sortOrder"]);
				$results = $recData->arrData;
				break;
				
			case "products":
				$recData = $objProductAdmin->fnGetProductList($_GET);
				$results = $recData->arrData;
				if (is_array($results) && count($results))
				{
					$variable_obj = $objProductVariable->fnGetVariableList();
					$variableList = $variable_obj->arrData;
					$languageList = $objLang->fnGetDataList("1=1","langcode,name");
					foreach ($results as $prodKey => $product)
					{
						if(is_array($variableList))
						{
							foreach($variableList as $variable)
							{
								switch($variable->type)
								{
									case "select":
										$InsertVariable = clone($variable);
										$selectionList = $objProductVariableSelection->fnGetSelectionList($variable->ID);
										$value = $objProductValue->fnGetValue($product->ID, $variable->ID);
										if (isset($value->value_id))
										{
											foreach ($selectionList as $selection)
											{
												if ($selection->ID == $value->value_id)
												{
													$InsertVariable->value = $selection->title;
													break;
												}
											}
										}
										//$variables[] = $InsertVariable;
										$results[$prodKey]->{$InsertVariable->title} = $InsertVariable->value;
										unset($InsertVariable);
										break;
										
									case "selectmultiple":
										$InsertVariable = clone($variable);
										$selectionList = $objProductVariableSelection->fnGetSelectionList($variable->ID);
										$value = $objProductValue->fnGetValue($product->ID, $variable->ID);
										if (is_array($value->value_id) && count($value->value_id))
										{
											foreach ($selectionList as $selection)
											{
												if ($value->value_id[$selection->ID])
												{
													$InsertVariable->value .= $selection->title.", ";
												}
											}
											$InsertVariable->value = substr($InsertVariable->value, 0, -2);
										}
										//$variables[] = $InsertVariable;
										$results[$prodKey]->{$InsertVariable->title} = $InsertVariable->value;
										unset($InsertVariable);
										break;
									
									//case "fckeditor":
									case "text":
									case "textarea":
									
										if($variable->multiple == "N")
										{
											$langvariable = $variable;
											$langvariable->name = "value_" . DEFAULT_LANG;
											$langvariable->title = $variable->title;
											$value = $objProductValue->fnGetValue($product->ID, $variable->ID);
											$langvariable->value = $value->{"value_" . DEFAULT_LANG};
											//$variables[] = $langvariable;
											$results[$prodKey]->{$langvariable->title} = $langvariable->value;
											unset($langvariable);
										}
										else
										{
											foreach($languageList as $languageItem)
											{
												//seems like some strange case: if clone is not used, $variable is affected somehow. now its php5 only.
												$langvariable = clone($variable);
												
												$langvariable->name = "value_" . $languageItem->langcode;
												$langvariable->title = $variable->title . " " . $languageItem->name;
												
												$value = $objProductValue->fnGetValue($product->ID, $variable->ID);
												$langvariable->value = $value->{"value_" . $languageItem->langcode};
												
												//$variables[] = $langvariable;
												$results[$prodKey]->{$langvariable->title} = $langvariable->value;
												unset($langvariable);
											}
										}
										break;
											
									case "checkbox":
										$InsertVariable = clone($variable);
										$value = $objProductValue->fnGetValue($product->ID, $variable->ID);
										$InsertVariable->value = $value->value_boolean;
										//$variables[] = $InsertVariable;
										$results[$prodKey]->{$InsertVariable->title} = $InsertVariable->value;
										unset($InsertVariable);
										break;
								}
							}
						}
						//$results[$prodKey]->variables = $variables;
						//unset($variables);
					}
				}
				break;
			
			default:
				echo "<script>window.close();</script>";
				exit;
				break;
		}
	}
	else
	{
		echo "<script>window.close();</script>";
		exit;
	}
	if (is_array($results) && count($results))
	{
		$headerSet = 0;
		foreach($results as $value)
		{
			unset($value->strLink);
			unset($value->code);
			if (!$headerSet)
			{
				$engSmarty->assign("header", array_keys(get_object_vars($value)));
				$headerSet = 1;
			}
			foreach($value as $valueDetails)
			{
				$output .= '"'.$valueDetails.'";';
			}
			$output = substr($output, 0, -1);
			$TableLine[] = $output;
			unset($output);
		}
		$engSmarty->assign("Table", $TableLine);
		$export = $engSmarty->fetch("admin/csv.export.tpl");
	}
	else
	{
		echo "<script>window.close();</script>";
		exit;
	}
	header("Expires: ".gmdate("D, d M Y H:i:s")." GMT");
	header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
	header("Cache-Control: no-store, no-cache, must-revalidate");
	header("Cache-Control: post-check=0, pre-check=0", false);
	header("Pragma: ");
	header("Cache-control: ");
	header("Content-type: application/octet-stream\n");
	header("Content-disposition: attachment; filename=".$recNode->type.".csv\n");
	header("Content-transfer-encoding: binary\n");
	
	echo $export;
	exit;
?>
