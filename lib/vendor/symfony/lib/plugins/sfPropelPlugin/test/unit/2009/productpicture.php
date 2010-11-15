<?php
/**
 * Rakendus: pildi genereerimine
 *
 * <i>CMS ADMIN</i> s?steemist ?lesse laetud pildi kuvamine
 * @package CMS_PAGE
 * @subpackage public
 */

require_once("cfg/pre.inc");
require_once(CONFIG_DIR . "access.inc");
require_once(CONFIG_DIR . "template.inc");
require_once(MODULE_DIR . "access/class.IPAccess.inc");
require_once(INIT_DIR . "env.inc");
require_once(INIT_DIR . "lang.inc");
require_once(INIT_DIR . "db.inc");
require_once(INIT_DIR . "smarty.inc");
require_once(MODULE_DIR . "structure/mod.structure.inc");
require_once(MODULE_DIR . "user/mod.user.inc");
require_once(MODULE_DIR . "user/mod.usergroup.inc");
require_once(MODULE_DIR . "structure/mod.product.inc");

require_once(MODULE_DIR . "statistics/mod.query.inc");
require_once(MODULE_DIR . "ind_functions.inc");
  
  
  error_reporting('E_ALL');
  $ID = (int)$_GET['ID'];

  $recFile = PRODUCTPICTURE_DIR . $ID;

  $engSmarty->debug_tpl = "debug.tpl";
  $engSmarty->debugging = 0;

  $srcSize  = getImageSize($recFile);
  $width = $srcSize[0];
  $height = $srcSize[1];

  /*if($_GET["maxheight"] > 0)
  {
	  $_GET["maxheight"] = (int)$_GET["maxheight"];
      if($height > $_GET["maxheight"])
	  {
	      $ratio = $_GET["maxheight"] / $height;
		  $height = (int)$_GET["maxheight"];
		  $width = (int)($width * $ratio);
		  unset($ratio);
	  }
  }

  if($_GET["maxwidth"] > 0)
  {
	  $_GET["maxwidth"] = (int)$_GET["maxwidth"];
      if($width > $_GET["maxwidth"])
	  {
	      $ratio = $_GET["maxwidth"] / $width;
		  $width = (int)$_GET["maxwidth"];
		  $height = (int)($height * $ratio);
	  }
  }

 */
 $recFile = $objProductPicture->fnGetItem($ID);
 
if (intval($_GET['width']))
	$recFile->sizeX = intval($_GET['width']);
else
	$recFile->sizeX = $srcSize[0];
if (intval($_GET['height']))
	$recFile->sizeY = intval($_GET['height']);
else
	$recFile->sizeY = $srcSize[1];

if (!intval($_GET['width']) && !intval($_GET['height'])){
	$height = $recFile->sizeY;
	$width = $recFile->sizeX;
	$max_height = 600;
	$max_width = 800;
	if($height > $max_height && $width > $max_width){
		$diff_height = $height - $max_height;
		$diff_width = $width - $max_width;
		if ($diff_height >= $diff_width){
			$scale_y = 1;
		}else{
			$scale_x = 1;
		}
	}
	if (($width > $max_width && !$scale_y) || $scale_x){
		$scaling = $width/$max_width;
		$width = $max_width;
		$height = round($height/$scaling);
	}else if($height > $max_height || $scale_y){
		$scaling = $height/$max_height;
		$height = $max_height;
		$width = round($width/$scaling);
	}
	
	$recFile->sizeY = $height;
	$recFile->sizeX = $width;
}  
    
     
if(isset($_REQUEST['prodID']))
{

   $prodID = (int)$_REQUEST['prodID'];


 $arrFiles = $objProductPicture->fnGetDataList
(
	"productID='" . $prodID . "' ORDER BY productID ASC",
	"ID,  filename, productID"
);
 

 $k = 0;
foreach ($arrFiles as $key => $val)
{
	if (0 < $key)
	{
		$recFile->previous = 1;
	}
	if (sizeof($arrFiles) - 1 > $key)
	{
		$recFile->next = 1;
	}
	if ($ID == $arrFiles[$key]->ID)
	{
		$recFile->prevID = $k == 0 ? $arrFiles[count($arrFiles)-1]->ID : $arrFiles[$k-1]->ID;
		$recFile->nextID = $k == count($arrFiles)-1 ? $arrFiles[0]->ID : $arrFiles[$k+1]->ID;
	}
	$k++;  
}
}
	
 //$_SESSION["lang"] = ($_REQUEST['lang']);
	if(FALSE == $_SESSION["lang"])$_SESSION["lang"] = "est";

	require_once(CONFIG_DIR . $_SESSION["lang"] . ".translation.inc");	

  $strTemplate = "productpicture.tpl";
  $engSmarty->assign('ID', $ID);
  $engSmarty->assign('productpicture', $recFile);       
  $engSmarty->assign('width', $width);
  $engSmarty->assign('height', $height + 50);
  $engSmarty->assign('productID',  $prodID);     
   $engSmarty->assign("arrLang", $arrTranslation);
  
  $engSmarty->display($strTemplate);
   
?>