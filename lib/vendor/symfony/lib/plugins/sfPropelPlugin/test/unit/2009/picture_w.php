<?php
	define('JPEG_QUALITY', 90);
	ini_set('memory_limit', '128M');
	ini_set('display_errors','0');
	require_once("cfg/pre.inc");
	require_once(INIT_DIR . "env.inc");
	require_once("functions.bmp.php");
	
	if(isset($_REQUEST["ID"]))
	{
		$ID = null;
		$search_dir = null;
		$search_path = null;
		if (isset($_REQUEST["width"]) && isset($_REQUEST["height"]) || isset($_REQUEST["maxwidth"]) || isset($_REQUEST["maxheight"]))
		{
			if ($_REQUEST["product"])
			{
				if (!$_REQUEST["external"] && !$_REQUEST["category"])
					$search_path = PRODUCTPICTURE_DIR;
				else if ($_REQUEST["external"])
					$search_path = EXTERNALPRODUCTPICTURE_DIR;
				else
					$search_path = PRODUCTCATEGORYPICTURE_DIR;
			}
			else if($_REQUEST["article"])
			{
				$search_path = ARTICLE_DIR;
			}
			else if($_REQUEST["banner"])
			{
				$search_path = BANNER_DIR;
			}
			else if($_REQUEST["folder"])
			{
				$search_path = FOLDERIMAGE_DIR;
			}
			else if($_REQUEST["category"])
			{
				$search_path = PRODUCTCATEGORYPICTURE_DIR;
			}
      else if($_REQUEST["director"])
      {
        $search_path = SYSTEM_DIR . 'upload/directors/';
      }
			else
			{
				$search_path = GALLERY_DIR;
			}
			
			if($_REQUEST["maxwidth"])
			{
				$cache_width = (int)$_REQUEST["maxwidth"];
			}
			if($_REQUEST["maxheight"])
			{
				$cache_height = (int)$_REQUEST["maxheight"];
			}
			
			if ($_REQUEST["width"] && $_REQUEST["height"])
			{
				$cache_width = (int)$_REQUEST["width"];
				$cache_height = (int)$_REQUEST["height"];
				$path_part2 = "_strict";
			}
			if ($_REQUEST["rounded"])
				$path_part = "_rounded".(int)$_REQUEST["rounded"];
			
			$ID = $_REQUEST["ID"];
			
			$search_dir = $search_path."size_".$cache_width."x".$cache_height.$path_part.$path_part2."/";
		}
		if (file_exists($search_dir.$ID) && (isset($_REQUEST["width"]) && isset($_REQUEST["height"]) || isset($_REQUEST["maxwidth"]) || isset($_REQUEST["maxheight"])))
		{
			$fileTime = gmdate("D, d M Y H:i:s", filemtime($search_dir.$ID)) . " GMT";
			
			header("Expires: ".gmdate("D, d M Y H:i:s", mktime(0, 0, 0, date("m"),   date("d"),   date("Y")+1))." GMT");
			header("Cache-Control: public");
			header("Last-Modified: ".$fileTime);
			header("Pragma: public");
			if ($_REQUEST["rounded"] || $_REQUEST["alphabg"])
				header("Content-Type: image/png");
			else
				header("Content-Type: image/jpeg");
			if($_SERVER["HTTP_IF_MODIFIED_SINCE"] == $fileTime)
			{
				header("HTTP/1.1 304 Not Modified");
				exit;
			}
			header("Content-Length: ".filesize($search_dir.$ID));
			if ($_REQUEST["rounded"] || $_REQUEST["alphabg"])
				header("Content-Disposition: inline; filename=".$ID.".png");
			else
				header("Content-Disposition: inline; filename=".$ID.".jpg");
			header("Content-Transfer-Encoding: binary");

			@readfile($search_dir.$ID);
			exit;
		}
		else
		{
		  
			$recImage = $search_path.$_REQUEST["ID"];

			if (file_exists($recImage)) 
			{
				$arrPildiInfo  = getImageSize($recImage);
				$originaalPildimaxheight  = $arrPildiInfo[1];
				$originaalPildimaxwidth  = $arrPildiInfo[0];

				if (isSet($_REQUEST["maxwidth"]) && $_REQUEST["maxwidth"] < $originaalPildimaxwidth) 
				{
				    $suhe = $_REQUEST["maxwidth"] / $originaalPildimaxwidth;
					$pildimaxwidth = $_REQUEST["maxwidth"];
					$pildimaxheight = $originaalPildimaxheight * $suhe;
				}
				else
				{
				    $pildimaxheight = $originaalPildimaxheight;
					$pildimaxwidth = $originaalPildimaxwidth;
				}

				if(isSet($_REQUEST["maxheight"]) && $pildimaxheight > $_REQUEST["maxheight"])
				{
				    $suhe = $_REQUEST["maxheight"] / $pildimaxheight;
				    $pildimaxheight = $_REQUEST["maxheight"];
					$pildimaxwidth = $pildimaxwidth * $suhe;
				}
				
				if (isSet($_REQUEST["width"]) || isSet($_REQUEST["height"])){
					if ($_REQUEST["width"] >= $_REQUEST["height"]){
						if ($_REQUEST["width"] < $originaalPildimaxwidth){
							$suhe = $_REQUEST["width"] / $originaalPildimaxwidth;
							$pildimaxwidth = $_REQUEST["width"];
							$pildimaxheight = $_REQUEST["height"];
							$pildimaxheight2 = $originaalPildimaxheight * $suhe;
						}
						
						if ($_REQUEST["width"] >= $originaalPildimaxwidth){
							$suhe = 1;
							$not_resize_x = 1;
							$pildimaxwidth = $_REQUEST["width"];
							$pildimaxheight2 = $originaalPildimaxheight * $suhe;
						}
						
						$pildimaxheight = $_REQUEST["height"];
						$resize = '1';
						
						if ($pildimaxheight2 > $pildimaxheight)
						{
							$suhe2 = $pildimaxheight/$pildimaxheight2;
							$pildimaxwidth2 = $pildimaxwidth * $suhe2;
							$pildimaxheight2 = $pildimaxheight;
						}
					}else{
						if ($_REQUEST["height"] < $originaalPildimaxheight){
							$suhe = $_REQUEST["height"] / $originaalPildimaxheight;
							$pildimaxwidth2 = $originaalPildimaxwidth * $suhe;
							$pildimaxheight = $_REQUEST["height"];
						}
						
						if ($_REQUEST["height"] >= $originaalPildimaxheight){
							$suhe = 1;
							$not_resize_y = 1;
							$pildimaxheight = $_REQUEST["height"];
							$pildimaxwidth2 = $originaalPildimaxwidth * $suhe;
						}
						
						$resize = '1';
						$pildimaxwidth = $_REQUEST["width"];
						
						if ($pildimaxwidth2 > $pildimaxwidth)
						{
							$suhe2 = $pildimaxwidth/$pildimaxwidth2;
							$pildimaxheight2 = $pildimaxheight * $suhe2;
							$pildimaxwidth2 = $pildimaxwidth;
						}
					}
				}
				if ($_REQUEST["gif"])
					$destImage = imageCreate($pildimaxwidth, $pildimaxheight);
				else
					$destImage = imageCreateTrueColor($pildimaxwidth, $pildimaxheight);
				if ($_REQUEST["rounded"])
				{
			        imagealphablending($destImage, false);
			        imagesavealpha($destImage,true);
			        $bgc = imagecolorallocatealpha($destImage, 233, 230, 227, 0);
		        }
		        if ($_REQUEST["alphabg"])
				{
					imagealphablending($destImage, false);
					imagesavealpha($destImage,true);
				
					$bgc = imagecolorallocatealpha($destImage, 255, 255, 255, 127);
				}
       			if (!$bgc) $bgc = imagecolorallocate($destImage, 255, 255, 255);
       			
       			imagefilledrectangle($destImage, 0, 0, $pildimaxwidth, $pildimaxheight, $bgc);
				switch ($arrPildiInfo[2]) {
				  case 1: //GIF
					$srcImage = imageCreateFromGif($recImage) or die("Cannot Initialize new GD image stream");;
				 break;

				  case 2: //JPEG
					$srcImage = imageCreateFromJpeg($recImage) or die("Cannot Initialize new GD image stream");;
					break;

				  case 3: //PNG
					$srcImage = imageCreateFromPng($recImage) or die("Cannot Initialize new GD image stream");;
					imagealphablending($srcImage, false);
		        	imagesavealpha($srcImage,true);
					break;
				  case 6: //BMP
				  	$srcImage = imagecreatefrombmp($recImage) or die("Cannot Initialize new GD image stream");;
				  	break;
				  default:
					return false;
					break;
				}
				if ($resize){
					if ($pildimaxheight2){
						if ($pildimaxheight > $pildimaxheight2){
							//add
							$dst_y = ($pildimaxheight-$pildimaxheight2)/2;
							$dst_y_hgt = $pildimaxheight2;
							if ($not_resize_x){
								$dst_x = ($pildimaxwidth - $originaalPildimaxwidth)/2;
								imageCopyResampled($destImage, $srcImage, $dst_x, $dst_y, 0, 0,$originaalPildimaxwidth, $dst_y_hgt, $originaalPildimaxwidth, $originaalPildimaxheight);
							}else
								imageCopyResampled($destImage, $srcImage, 0, $dst_y, 0, 0,$pildimaxwidth, $dst_y_hgt, $originaalPildimaxwidth, $originaalPildimaxheight);
						}else{
							//crop
							$src_yhgt = $pildimaxheight/$suhe;
							$src_y = ($originaalPildimaxheight - $src_yhgt)/2;
							if ($not_resize_x){
								$dst_x = ($pildimaxwidth - $originaalPildimaxwidth)/2;
								imageCopyResampled($destImage, $srcImage, $dst_x, 0, 0, $src_y,$originaalPildimaxwidth, $pildimaxheight, $originaalPildimaxwidth, $src_yhgt);
							}else
								imageCopyResampled($destImage, $srcImage, 0, 0, 0, $src_y,$pildimaxwidth, $pildimaxheight, $originaalPildimaxwidth, $src_yhgt);
						}
					}else if ($pildimaxwidth2){
						if ($pildimaxwidth > $pildimaxwidth2){
							//add
							$dst_x = ($pildimaxwidth-$pildimaxwidth2)/2;
							$dst_x_hgt = $pildimaxwidth2;
							if ($not_resize_y){
								$dst_y = ($pildimaxheight - $originaalPildimaxheight)/2;
								imageCopyResampled($destImage, $srcImage, $dst_x, $dst_y, 0, 0,$dst_x_hgt, $originaalPildimaxheight, $originaalPildimaxwidth, $originaalPildimaxheight);
							}else
								imageCopyResampled($destImage, $srcImage, $dst_x, 0, 0, 0,$dst_x_hgt, $pildimaxheight, $originaalPildimaxwidth, $originaalPildimaxheight);
						}else{
							//crop
							$src_xhgt = $pildimaxwidth/$suhe;
							$src_x = ($originaalPildimaxwidth - $src_xhgt)/2;
							if ($not_resize_y){
								$dst_y = ($pildimaxheight - $originaalPildimaxheight)/2;
								imageCopyResampled($destImage, $srcImage, 0, $dst_y, $src_x, 0,$pildimaxwidth, $originaalPildimaxheight, $src_xhgt, $originaalPildimaxheight);
							}else
								imageCopyResampled($destImage, $srcImage, 0, 0, $src_x, 0,$pildimaxwidth, $pildimaxheight, $src_xhgt, $originaalPildimaxheight);
						}
					}
				}else
					imageCopyResampled($destImage, $srcImage, 0, 0, 0, 0,$pildimaxwidth, $pildimaxheight, $originaalPildimaxwidth, $originaalPildimaxheight);
				
				imagedestroy($srcImage);
				
				if($_REQUEST["rounded"])
				{
					$new_width = $pildimaxwidth*4;
					$new_height = $pildimaxheight*4;
					
					$colTrans = imagecolorallocatealpha($destImage, 255, 255, 255, 127);
					
					$radius = (int)$_REQUEST["rounded"]*4;
					if ($radius)
					{
						$srcImage = imageCreateTrueColor($new_width, $new_height);
				        imagealphablending($srcImage, false);
				        imagesavealpha($srcImage,true);
						imageCopyResampled($srcImage, $destImage, 0, 0, 0, 0,$new_width, $new_height, $pildimaxwidth, $pildimaxheight);
						if ($radius <= 20)
							$step = round(10/$radius, 2);
						elseif ($radius <= 50)
							$step = round(20/$radius, 2);
						elseif ($radius <= 100)
							$step = round(30/$radius, 2);
						else
							$step = round(50/$radius, 2);
						
						for($angle = 0; $angle <= 90; $angle = $angle + $step)
						{
							$y = $radius - round($radius*sin(deg2rad($angle)));
							$x = $radius - round($radius*cos(deg2rad($angle)));
							
							$y1 = $new_height - $y;
							$x1 = $new_width - $x;
							
							$pos1 = imagecolorat($srcImage, $x, $y);
							$pos2 = imagecolorat($srcImage, $x, $y1);
							$pos3 = imagecolorat($srcImage, $x1, $y);
							$pos4 = imagecolorat($srcImage, $x1, $y1);
							
							$col1 = imagecolorsforindex($srcImage, $pos1);
							$col2 = imagecolorsforindex($srcImage, $pos2);
							$col3 = imagecolorsforindex($srcImage, $pos3);
							$col4 = imagecolorsforindex($srcImage, $pos4);
							
							$color1 = imagecolorallocate($srcImage, $col1['red'], $col1['green'], $col1['blue']);
							$color2 = imagecolorallocate($srcImage, $col2['red'], $col2['green'], $col2['blue']);
							$color3 = imagecolorallocate($srcImage, $col3['red'], $col3['green'], $col3['blue']);
							$color4 = imagecolorallocate($srcImage, $col4['red'], $col4['green'], $col4['blue']);
							
							imagesetpixel($srcImage, $x, $y, $color1);
							imagesetpixel($srcImage, $x, $y1, $color2);
							imagesetpixel($srcImage, $x1, $y, $color3);
							imagesetpixel($srcImage, $x1, $y1, $color4);
							
							$old_y = $y;
							$old_x = $x;
							
							for ($x2 = 0; $x2 < $x; $x2++)
							{
								imagesetpixel($srcImage, $x2, $y, $colTrans);
								imagesetpixel($srcImage, $x2, $y1, $colTrans);
								imagesetpixel($srcImage, $new_width - $x2, $y, $colTrans);
								imagesetpixel($srcImage, $new_width - $x2, $y1, $colTrans);
							}
						}
						
						imageCopyResampled($destImage, $srcImage, 0, 0, 0, 0, $pildimaxwidth, $pildimaxheight, $new_width, $new_height);
						imagedestroy($srcImage);
					}
				}
				
				if($_REQUEST["color"] <> "" && strlen($_REQUEST["color"]) == 6){
					
					$Red = hexdec(substr($_REQUEST["color"], 0, 2));
					$Green = hexdec(substr($_REQUEST["color"], 2, 2));
					$Blue = hexdec(substr($_REQUEST["color"], 4, 2));
					
					//We will create a monochromatic palette based on
					//the input color
					//which will go from black to white
					//Input color luminosity: this is equivalent to the 
					//position of the input color in the monochromatic
					//palette
					$lum_inp=round(255*($Red+$Green+$Blue)/765); //765=255*3

					//We fill the palette entry with the input color at its 
					//corresponding position

					$pal[$lum_inp]['r']=$Red;
					$pal[$lum_inp]['g']=$Green;
					$pal[$lum_inp]['b']=$Blue;

					//Now we complete the palette, first we'll do it to
					//the black,and then to the white.

					//FROM input to black
					//===================
					//how many colors between black and input
					$steps_to_black=$lum_inp;        

					//The step size for each component
					if($steps_to_black)
					 {
					 $step_size_red=$Red/$steps_to_black;    
					 $step_size_green=$Green/$steps_to_black;    
					 $step_size_blue=$Blue/$steps_to_black;    
					 }

					for($i=$steps_to_black;$i>=0;$i--)
					 {
					 $pal[$steps_to_black-$i]['r']=$Red-round($step_size_red*$i);
					 $pal[$steps_to_black-$i]['g']=$Green-round($step_size_green*$i);
					 $pal[$steps_to_black-$i]['b']=$Blue-round($step_size_blue*$i);
					 }

					//From input to white:
					//===================
					//how many colors between input and white
					$steps_to_white=255-$lum_inp;

					if($steps_to_white){
						if ($_REQUEST["colorize"]){
							if ($_REQUEST["colorize"] == "red"){
								$step_size_red=(255-$Red)/$steps_to_white;
								$step_size_green=0;    
								$step_size_blue=0;  
							}elseif ($_REQUEST["colorize"] == "blue"){
								$step_size_red=0;   
								$step_size_green=0;    
								$step_size_blue=(255-$Blue)/$steps_to_white;
							}else{
								$step_size_red=0;   
								$step_size_green=(255-$Green)/$steps_to_white;    
								$step_size_blue=0;
							}
						}else{
							$step_size_red=(255-$Red)/$steps_to_white;   
							$step_size_green=(255-$Green)/$steps_to_white;    
							$step_size_blue=(255-$Blue)/$steps_to_white;    
						}
					 }else
					  	$step_size_red=$step_size_green=$step_size_blue=0;

					 //The step size for each component
					 for($i=($lum_inp+1);$i<=255;$i++){
						$pal[$i]['r']=$Red + round($step_size_red*($i-$lum_inp));
						$pal[$i]['g']=$Green + round($step_size_green*($i-$lum_inp));
						$pal[$i]['b']=$Blue + round($step_size_blue*($i-$lum_inp));
					 }
					//--- End of palette creation

					//Now,let's change the original palette into the one we
					//created
					$x = imagesx($destImage);
					$y = imagesy($destImage);
					$palette_size = imagecolorstotal($destImage);
					if ($palette_size > 0){
						for($c = 0; $c < $palette_size; $c++){ 
							$col = imagecolorsforindex($destImage, $c);          
							$lum_src=round(255*($col['red']+$col['green']+$col['blue'])/765);
							$col_out=$pal[$lum_src];
							imagecolorset($destImage, $c, $col_out['r'],$col_out['g'],$col_out['b']);
						}
					}else{
						for($i=0; $i<$y; $i++)  
						{  
							for($j=0; $j<$x; $j++)  
							{  
								$pos = imagecolorat($destImage, $j, $i);
								//echo "Original=".$pos."<br>";
								$col = imagecolorsforindex($destImage, $pos);  
								$lum_src=round(255*($col['red']+$col['green']+$col['blue'])/765);
								$col_out=$pal[$lum_src];
								$col1 = imagecolorresolve($destImage, $col_out['r'], $col_out['g'], $col_out['b']);
								//echo "Replacement=".$col1."<br>";
								imagesetpixel($destImage, $j, $i, $col1);
								//imagecolorset($destImage, $c, $col_out['r'],$col_out['g'],$col_out['b']);
							}  
						} 
					}
				}
				if ($cache_width || $cache_height)
				{
					if (!is_dir($search_dir))
					{
						mkdir($search_dir, 0755);
					}
					$path = $search_dir.$ID;
					if ($_REQUEST["rounded"] || $_REQUEST["alphabg"])
					{
						imagePNG($destImage, $path);
					}
					else
					{
						imageJPEG($destImage, $path, JPEG_QUALITY);
					}
				}
				if ($_REQUEST["rounded"] || $_REQUEST["alphabg"])
				{
					header('Content-type: image/png');
					header("Content-disposition: inline; filename=".$_REQUEST["ID"].".png\n");
				}
				else
				{
					header('Content-type: image/jpeg');
					header("Content-disposition: inline; filename=".$_REQUEST["ID"].".jpg\n");
				}
				header("Content-transfer-encoding: binary\n");
				if ($_REQUEST["rounded"] || $_REQUEST["alphabg"])
					imagePNG($destImage);
				else
					imageJPEG($destImage, null, JPEG_QUALITY);
				imagedestroy($destImage);
			}
		}
	}
?>