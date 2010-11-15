<?php
	ini_set('display_errors','0');

	require_once("cfg/pre.inc");
	require_once(CONFIG_DIR . "access.inc");
	require_once(MODULE_DIR . "access/class.IPAccess.inc");
	require_once(INIT_DIR . "env.inc");
	require_once(INIT_DIR . "db.inc");
	require_once(INIT_DIR . "smarty.inc");
	require_once(MODULE_DIR . "user/mod.user.inc");
	require_once(INIT_DIR . "smarty.inc");
	require_once(MODULE_DIR . "structure/mod.structure.inc");
	require_once(MODULE_DIR . "productcatalog/mod.product.inc");
	require_once(MODULE_DIR . "structure/mod.gallery.inc");

	if (!isset($_SESSION["lang"]))
	{
		$_SESSION["lang"] = DEFAULT_LANG;
	}
	require_once(CONFIG_DIR . $_SESSION["lang"] . ".translation.inc");
	$engSmarty->assign("arrTranslation", $arrTranslation);

	$ID = intval($_GET['ID']);
	if (is_file(GALLERY_DIR . $ID))
	{
		$recFile = $objGalleryPicture->fnGetDataRecord("ID='" . $ID . "'", "filename, descript, parentID");
		$recFile->ID = $ID;
		$arrFiles = $objGalleryPicture->fnGetDataList
		(
			"parentID='" . $recFile->parentID . "' ORDER BY sort ASC",
			"ID, thumbnail, filename, descript, thumb_descript"
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

		$recFile->description = nl2br($recFile->descript);

		$srcSize  = getImageSize(GALLERY_DIR . $ID);
		if (intval($_GET['width']))
			$recFile->sizeX = intval($_GET['width']);
		else
			$recFile->sizeX = $srcSize[0];
		if (intval($_GET['height']))
			$recFile->sizeY = intval($_GET['height']);
		else
			$recFile->sizeY = $srcSize[1];

		if (!intval($_GET['width']) && !intval($_GET['height']))
		{
			$height = $recFile->sizeY;
			$width = $recFile->sizeX;
			$max_height = 600;
			$max_width = 800;
			if($height > $max_height && $width > $max_width)
			{
				$diff_height = $height - $max_height;
				$diff_width = $width - $max_width;
				if ($diff_height >= $diff_width)
				{
					$scale_y = 1;
				}
				else
				{
					$scale_x = 1;
				}
			}
			if (($width > $max_width && !$scale_y) || $scale_x)
			{
				$scaling = $width/$max_width;
				$width = $max_width;
				$height = round($height/$scaling);
			}
			else if($height > $max_height || $scale_y)
			{
				$scaling = $height/$max_height;
				$height = $max_height;
				$width = round($width/$scaling);
			}
			
			$recFile->sizeY = $height;
			$recFile->sizeX = $width;
		}

		$strTemplate = "picture.tpl";
		$engSmarty->assign('productpicture', $recFile);
		$engSmarty->assign("strPath", SYSTEM_PATH."/".$_SESSION["lang"]);
		$engSmarty->display($strTemplate);
	}
	else
	{
		echo "<html><head><script type='text/javascript'>window.close();</script></head><body></body></html>";
	}
?>