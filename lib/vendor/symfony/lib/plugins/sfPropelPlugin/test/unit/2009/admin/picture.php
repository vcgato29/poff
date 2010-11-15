<?php
/**
 * Rakendus: pildi genereerimine
 *
 * <i>CMS ADMIN</i> süsteemist ülesse laetud pildi kuvamine
 * @package CMS_PAGE
 * @subpackage public
 */

  require_once("../cfg/pre.inc");
  require_once(CONFIG_DIR . "access.inc");
  require_once(MODULE_DIR . "access/class.IPAccess.inc");
  require_once(INIT_DIR . "env.inc");
  require_once(INIT_DIR . "db.inc");
  require_once(MODULE_DIR . "user/mod.user.inc");
  require_once(INIT_DIR . "smarty.inc");
  require_once(MODULE_DIR . "structure/mod.structure.inc");
  require_once(MODULE_DIR . "structure/mod.gallery.inc");


  $recFile = $objGalleryPicture->fnGetDataRecord("ID='" . (int)$_GET["ID"] . "'", "filename");
  if (is_object($recFile)) {
    header("Expires: ".gmdate("D, d M Y H:i:s")." GMT");
    header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
    header("Cache-Control: no-store, no-cache, must-revalidate");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: ");
    header("Cache-control: ");
    header("Content-type: application/octet-stream\n");
    header("Content-disposition: inline; filename=".$recFile->filename."\n");
    header("Content-transfer-encoding: binary\n");

    @readfile(GALLERY_DIR . $_GET["ID"]);
  }
?>