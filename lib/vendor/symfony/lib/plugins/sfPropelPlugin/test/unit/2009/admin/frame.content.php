<?php
/**
 * Rakendus: sisu frame
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
require_once(MODULE_DIR . "productcatalog/mod.category.inc");
require_once(MODULE_DIR . "productcatalog/mod.variable.inc");
require_once(MODULE_DIR . "productcatalog/mod.product.inc");
require_once(MODULE_DIR . "statistics/mod.query.inc");
require_once(MODULE_DIR . "ind_functions.inc");
//require_once(MODULE_DIR . "sitevariables/mod.sitevariables.inc");

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


if ($_GET["action"] == "delete" and $_GET["ID"] and $_GET["items"]) 
{
	$arrNode = explode(";", $_GET["items"]);

	$objStructure->fnDeleteNodes($arrNode);
	header("Location: frame.content.php?ID=" . $_GET["ID"] . "&refreshtree=1");
	exit;
}

if ($_GET["action"] == "productsdelete" and $_GET["ID"] and $_GET["items"]) 
{
	$arrNode = explode(";", $_GET["items"]);

	$objProductAdmin->fnDeleteProducts($arrNode);
	header("Location: frame.content.php?ID=" . $_GET["ID"]);
	exit;
}

if ($_GET["action"] == "productvariabledelete" and $_GET["ID"] and $_GET["items"]) 
{
	$arrNode = explode(";", $_GET["items"]);

	$objProductVariable->fnDeleteVariables($arrNode);
	header("Location: frame.content.php?ID=" . $_GET["ID"]);
}


if (!$_GET["ID"] or $arrGlobalRights[$_GET["ID"]] == "deny") 
{
	$_GET["ID"] = 1;
}


$recNode = $objStructure->fnGetDataRecord("ID='" . $_GET["ID"] . "'");

if (is_object($recNode)) 
{
	$engSmarty->assign("recNode", $recNode);
	
	switch ($recNode->type) 
	{
    case "xmlimport":
        $recData = array('url' => $_SERVER['SERVER_NAME']);
        break;
    case "directors":
        require_once(MODULE_DIR . 'directors.inc');
        $directors = new DirectorsManager();
        $recData = $directors->Handler();
        break;
    case "comments":
        require_once(MODULE_DIR . 'poffcomments.inc');
        $comments = new POFF_comments();
        $recData = $comments->handler();
        break;
		case "bannercategory":
			if ($_POST["search"]) 
			{
				foreach($_POST as $key => $item) 
				{
					if (substr($key, 0, strlen("formSearch")) == "formSearch") 
					{
						$arrLink[] = substr($key, strlen("formSearch") + 1) . "=" . $item;
					}
				}
				header("Location: frame.content.php?ID=" . $_GET["ID"] . "&action=search&sortColumn=position&sortOrder=asc&" . @implode("&", $arrLink));
			}
			elseif (!$_GET["sortColumn"] or $_GET["action"] != "search") 
			{
				if (is_array($objStructure->arrNodeType["element"])) 
				{
					foreach($objStructure->arrNodeType["element"] as $item) 
					{
						$_GET["search" . $item] = true;
					}
				}
			}
			$recData = $objStructure->fnGetNodeList($_GET["ID"], $recNode->type, $_GET["sortColumn"], $_GET["sortOrder"], $_GET);
			$recData->arrHeader = $objBannercategory->fnGetArrHeader();
			$recData->arrData = $objBannercategory->fnGetArrData($recData->arrData);
			$recSearch->recUser->arrID[] = $_SESSION["user"]->ID;
			$recSearch->recUser->arrName[] = $_SESSION["user"]->realname;
			$arrUser = $objUser->fnGetDataList("status='active' and ID!='" . $_SESSION["user"]->ID . "'", "ID, realname");
			if (is_array($arrUser))
			{
				foreach($arrUser as $item)
				{
					$recSearch->recUser->arrID[] = $item->ID;
					$recSearch->recUser->arrName[] = $item->realname;
				}
			}
			break;
			
		case "documents":
		case "lang":
		case "folder":
		case "forum":
		case "forumfilters":
		case "categorylinks":
		case "newsmaillist":
		case "banner":
		case "bannerlanguage":
		if ($_POST["search"]) 
		{
			foreach($_POST as $key => $item) 
			{
				if (substr($key, 0, strlen("formSearch")) == "formSearch") 
				{
					$arrLink[] = substr($key, strlen("formSearch") + 1) . "=" . $item;
				}
			}
			header("Location: frame.content.php?ID=" . $_GET["ID"] . "&action=search&sortColumn=position&sortOrder=asc&" . @implode("&", $arrLink));
		}
		elseif (!$_GET["sortColumn"] or $_GET["action"] != "search") 
		{
			if (is_array($objStructure->arrNodeType["element"])) 
			{
				foreach($objStructure->arrNodeType["element"] as $item) 
				{
					$_GET["search" . $item] = true;
				}
			}
		}
		case "settings":
		case "generic":
		case "productscontainer":
		case "statistics":
		$recData = $objStructure->fnGetNodeList($_GET["ID"], $recNode->type, $_GET["sortColumn"], $_GET["sortOrder"], $_GET);
		$recSearch->recUser->arrID[] = $_SESSION["user"]->ID;
		$recSearch->recUser->arrName[] = $_SESSION["user"]->realname;
		$arrUser = $objUser->fnGetDataList("status='active' and ID!='" . $_SESSION["user"]->ID . "'", "ID, realname");
		if (is_array($arrUser)) 
		{
			foreach($arrUser as $item) 
			{
				$recSearch->recUser->arrID[] = $item->ID;
				$recSearch->recUser->arrName[] = $item->realname;
			}
		}
		break;
		case "forumsection":
		if (is_array($objStructure->arrNodeType["element"])) 
		{
			foreach($objStructure->arrNodeType["element"] as $item) 
			{
				$_GET["search" . $item] = true;
			}
		}
		$recData = $objStructure->fnGetNodeList($_GET["ID"], $recNode->type, $_GET["sortColumn"], $_GET["sortOrder"], $_GET);
		$recTopicsTree = $objForumtopic->getAdminTopicsList($recData);
		$recSearch->recUser->arrID[] = $_SESSION["user"]->ID;
		$recSearch->recUser->arrName[] = $_SESSION["user"]->realname;
		$arrUser = $objUser->fnGetDataList("status='active' and ID!='" . $_SESSION["user"]->ID . "'", "ID, realname");
		if (is_array($arrUser))
		{
			foreach($arrUser as $item) 
			{
				$recSearch->recUser->arrID[] = $item->ID;
				$recSearch->recUser->arrName[] = $item->realname;
			}
		}
		break;
		case "users":
			$recData = $objUser->fnGetUserList($_GET["ID"], "admin", $_GET["sortColumn"], $_GET["sortOrder"]);
			break;

		case "usergroups":
			$recData = $objUserGroup->fnGetList($_GET["ID"], $_GET["sortColumn"], $_GET["sortOrder"]);
			break;

		case "clients":
			$recData = $objUser->fnGetUserList($_GET["ID"], "client", $_GET["sortColumn"], $_GET["sortOrder"]);
			break;

		case "query":
			if ($_POST["action"] == "show")
			{
				$recUserInput = $objQuery->fnMakeRecord($_POST);
				$result = $objQuery->fnValidateData($recUserInput, "report");

				if (!is_array($result)) 
				{

					$recList = $objQuery->fnGetReport($_GET["ID"], $result);
					if (is_array($recList->arrData)) 
					{
						$recData = $recList;
					} 
					else 
					{
						$_POST["action"] = "view";
						$recError->type = "noresult";
					}

				} 
				else 
				{
					$_POST["action"] = "view";
					$recError->type = $result["type"];
					$recError->fields = $result["field"];
				}
			} 
			elseif (sizeof($_GET) > 1) 
			{

				if (sizeof($_GET) > 3) 
				{
					foreach($_GET as $key => $item)
					{
						if (!@in_array($key, array("ID", "sortColumn", "sortOrder"))) 
						{
							$recQuery->$key = $item;
						}
					}
				}

				$recList = $objQuery->fnGetReport($_GET["ID"], $recQuery, $_GET["sortColumn"], $_GET["sortOrder"]);
				if (is_array($recList->arrData)) 
				{
					$recData = $recList;
				}
				else 
				{
					$_POST["action"] = "view";
					$recError->type = "noresult";
				}
			}
			
			if ($_POST["action"] != "show" and $recError) 
			{
				$recError->strSection = "query";
				$recData = $objQuery->fnCompileSmartyRecord($recUserInput, $recError);
			}
			$recData->recData->startdate = $_POST["formQuery_startdate"];
			$recData->recData->enddate = $_POST["formQuery_enddate"];
		break;
		  
		case "sitevariables":
			$recData = $objSitevariables->fnGetVariables($_GET["ID"]);
			break; 
		
		case "productcategories":
			$catID = (int)$_GET["catID"];
			$sortDir = $_GET["sort"];
			if ($catID && $sortDir)
			{
				$objProductCategory->fnChangePosition($catID, $sortDir);
				header("Location: frame.content.php?ID=" . $_GET["ID"]);
				exit;
			}
			$recData = $objProductCategory->fnGetCategoryList(0);
			break;
			
		case "productvariables":
			$recData = $objProductVariable->fnGetVariableList();
			break;
			
		case "products":
			if ($_GET["sortColumn"] && $_GET["sortOrder"])
			{
				$_SESSION["productSortColumn"] = $_GET["sortColumn"];
				$_SESSION["productSortOrder"] = $_GET["sortOrder"];
			}
			if (isset($_POST["search"]))
			{
				unset($_SESSION["productSearch"]);
				if (is_array($_POST["search"]) && count($_POST["search"]))
				{
					foreach ($_POST["search"] as $searchField => $searchValue)
					{
						if (trim($searchValue))
							$_SESSION["productSearch"][$searchField] = $searchValue;
					}
				}
				header("location: frame.content.php?ID=".$recNode->ID);
				exit;
			}
			if ((int)$_POST['nrOfResults'])
			{
				$_SESSION['nrOfResults'] = (int)$_POST['nrOfResults'];
				header("location: frame.content.php?ID=".$recNode->ID);
				exit;
			}
			else if ($_POST['nrOfResults'] == "all")
			{
				$_SESSION['nrOfResults'] = $_POST['nrOfResults'];
				header("location: frame.content.php?ID=".$recNode->ID);
				exit;
			}
			else if (!$_SESSION['nrOfResults'])
			{
				$_SESSION['nrOfResults'] = 30;
			}
			$engSmarty->assign("nrOfResults", $_SESSION['nrOfResults']);
			if ((int)$_GET['page'] == 0)
				$_GET['page'] = 1;
			
			$_GET["search"] = $_SESSION["productSearch"];
			$_GET["sortColumn"] = $_SESSION["productSortColumn"];
			$_GET["sortOrder"] = $_SESSION["productSortOrder"];
			$recData = $objProductAdmin->fnGetProductList($_GET);
			$engSmarty->assign("SortField", $_GET['sort']);
			$engSmarty->assign("SortDirection", $_SESSION['sort_dir']);
			$engSmarty->assign("OldSortDirection", $_SESSION['old_sort_dir']);
			if ($_SESSION['nrOfResults'] != "all")
			{
				$engSmarty->assign("productsMaxPages", $_SESSION["productsMaxPages"]);
				$engSmarty->assign("productsSelectedPage", $_SESSION["productsSelectedPage"]);
			}
			else
			{
				unset($_SESSION["productsMaxPages"]);
				unset($_SESSION["productsSelectedPage"]);
			}
			break;
	}
	if ($recNode->type != "settings" && $recNode->type != "productscontainer" && $recNode->type != "generic" && $recNode->type != "statistics")
		$recNode->strHeader = "admin/content." . $recNode->type . ".tpl";
	else
		$engSmarty->assign("CurrentRight", $arrGlobalRights[$_GET["ID"]]);
}

if(sizeOf($recData) > 0 || $recNode->type == "query")
{
	$strTemplate = "frame.content.tpl";
}
else
{
	$strTemplate = "firstpage.tpl";
}

$engSmarty->assign("_GET", $_GET);
$engSmarty->assign("recSearch", $recSearch);
$engSmarty->assign("boolRefreshTree", $_GET["refreshtree"]);
$engSmarty->assign("recData", $recData);
$engSmarty->assign("recNode", $recNode);
$engSmarty->assign("arrGlobalRights", $arrGlobalRights);
$engSmarty->assign("arrTranslation", $arrTranslation);
$naviTree = $objStructure->_fnGetPath($_GET["ID"]);
$naviTree[sizeOf($naviTree)-1]->last = 1;
$naviTree[0]->first = 1;
$engSmarty->assign("naviTree", $naviTree);
//$engSmarty->display("admin/".$strTemplate);
$output = $engSmarty->fetch("admin/".$strTemplate);
//$engSmarty->debugging = true;
if (!$engSmarty->debugging)
{
  if (strstr($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip'))
  {
    $gzip_size = strlen($output);
    $gzip_contents = "\x1f\x8b\x08\x00\x00\x00\x00\x00".
      substr(gzcompress($output, 3), 0, - 4).
      pack('V', crc32($output)).
      pack('V', $gzip_size);
    header('Content-Encoding: gzip');
    header('Content-Length: '.strlen($gzip_contents));
    echo $gzip_contents;
  }
  else
  {
    header('Content-Length: '.strlen($output));
    echo $output;
  }
}
else
{
  $engSmarty->display("admin/".$strTemplate);
}
?>