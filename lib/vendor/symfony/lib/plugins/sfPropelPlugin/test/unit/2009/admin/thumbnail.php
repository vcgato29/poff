<?
  require_once("../cfg/pre.inc");


  $maxWidth=150;
  $maxHeight=300;


  if (@file_exists(GALLERY_DIR . $_GET["ID"])) {

    $srcSize  = getImageSize(GALLERY_DIR . $_GET["ID"]);
    $srcRatio  = $srcSize[0]/$srcSize[1];
    $destRatio = $maxWidth/$maxHeight;
    if ($destRatio > $srcRatio) {
      $destSize[1] = $maxHeight;
      $destSize[0] = $maxHeight*$srcRatio;
    }
    else {
      $destSize[0] = $maxWidth;
      $destSize[1] = $maxWidth/$srcRatio;
    }

    $destImage = imageCreateTrueColor($destSize[0],$destSize[1]);
echo $srcSize[2];

    switch ($srcSize[2]) {
      case 1: //GIF
        $srcImage = imageCreateFromGif(GALLERY_DIR . $_GET["ID"]) or die("Cannot Initialize new GD image stream");;
        break;

      case 2: //JPEG
        $srcImage = imageCreateFromJpeg(GALLERY_DIR . $_GET["ID"]) or die("Cannot Initialize new GD image stream");;
        break;

      case 3: //PNG
        $srcImage = imageCreateFromPng(GALLERY_DIR . $_GET["ID"]) or die("Cannot Initialize new GD image stream");;
        break;

      default:
        return false;
        break;
    }

    imageCopyResampled($destImage, $srcImage, 0, 0, 0, 0,$destSize[0],$destSize[1],$srcSize[0],$srcSize[1]);

    imageJpeg($destImage);

  }

?>