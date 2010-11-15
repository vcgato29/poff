<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
    <title>FLICKR</title>
    <link rel="stylesheet" type="text/css" href="/style/flickr.css" />
</head>
<body>
<?php
ini_set('display_errors','0');
//ini_set('pcre.backtrack_limit','1000000');
$badge  = 'http://www.flickr.com/badge_code_v2.gne?count=1&display=random&size=m&layout=x&source=user&user=44530972%40N04';
$width  = 190;
$height = 240;
$gray   = false;
/**
 *  if you want the Class to try to guess the best source size 
 *  (should work for all near-standard uses) you don't have to add
 *  anything at all. Should you need to force the script to
 *  auto-detect, the following line will do:
*/
$size = "auto";
/**
 *  if you want to manually define the size to use add the following
 *  line and use one of these size-constants:
 *  "xxs" (75x75), "xs" (100x?), "s" (240x?), 
 *  "m" (500x?), "l" (1024x?), "xl" (original)
*/
$size = "m";
include("flickpic.php"); 
?>
</body>
</html>