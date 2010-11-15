<?php

  // /captcha.php
  // /images/captcha.png
  // /images/agustinasans.ttf

	ini_set('memory_limit', '128M');
	ini_set('display_errors','0');
	
	require_once("cfg/pre.inc");
	require_once(INIT_DIR . "env.inc");
	
  if (!isset($_SESSION['last_captcha']))
  {
    $text = make_string();
    $_SESSION['last_captcha'] = $text;
  }
  else
  {
    $text = $_SESSION['last_captcha'];
  }
	
	$width = '200';
	$height = '60';
	$ttfPath = 'images/malapropism.ttf';
	$bgImagePath = 'images/captcha.png';
	
	
	$backgroundImage = imagecreatefrompng($bgImagePath);
	
	$bgWidth = imagesx($backgroundImage);
	$bgHeight = imagesy($backgroundImage);
	
	$randomXStart = rand(0, $bgWidth-$width);
	$randomYStart = rand(0, $bgHeight-$height);
	$randomContrast = rand(192, 255);
	imagefilter($backgroundImage, IMG_FILTER_CONTRAST, $randomContrast);
	imagefilter($backgroundImage, IMG_FILTER_COLORIZE, 247, 147, 30);
	$captcha = imageCreateTrueColor($width, $height);
	imagecopy($captcha, $backgroundImage, 0, 0, $randomXStart, $randomYStart, $bgWidth, $bgHeight);
	$textcolor = imagecolorallocate($captcha, 247, 147, 30);
	
	$offset = 0;
	$charOffset = 0;
	$charPosition = 5;
	while ($charOffset < strlen($text))
	{
		$char = substr($text, $charOffset, 1);
		
		$randomAngle = rand(-25, 25);
		$randomSize = rand(18, 24);
		
		$imageOffset = imagettftext($captcha, $randomSize, $randomAngle, $charPosition, 40, $textcolor, $ttfPath, $char);
		
		if ($imageOffset[2]>$imageOffset[4])
		{
			$offsetLeft = $imageOffset[2];
		}
		else 
		{
			$offsetLeft = $imageOffset[4];
		}
		$charPosition = $offsetLeft - 2;
		$charOffset++;
	}
	
	$captchaResult = imageCreateTrueColor($charPosition+7, $height);
	imagecopy($captchaResult, $captcha, 0, 0, 0, 0, $charPosition+7, $height);
	
	header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
	header("Cache-Control: no-store, no-cache, must-revalidate");
	header("Cache-Control: post-check=0, pre-check=0", false);
	header("Pragma: no-cache");
	header("Content-disposition: inline; filename=captcha.png\n");
	header('Content-type: image/png');
	
	imagePNG($captchaResult);
	
	function make_string($length = 5)
	{
		$valid1 = "aeiouy12345";
		$valid2 = "bcdfghjklmnprstvwxz6789";
		
		for ($a = 0; $a < $length; $a++)
		{			
			if ($a%2)
			{
				$charList = $valid1;
			}
			else 
			{
				$charList = $valid2;
			}
	        $b = rand(0, strlen($charList) - 1);
	        $rndstr .= $charList[$b];
	    }
	    
	    return $rndstr;
	}
?>