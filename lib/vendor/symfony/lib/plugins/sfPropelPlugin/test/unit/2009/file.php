<?php
/**
 * Rakendus: faili genereerimine
 *
 * <i>CMS ADMIN</i> süsteemist ülesse laetud faili edastamine <i>CMS CLIENT</i>
 * kasutajale vastavalt päringule
 * @package CMS_PAGE
 * @subpackage public
 */

  require_once("cfg/pre.inc");
  require_once(CONFIG_DIR . "access.inc");
  require_once(MODULE_DIR . "access/class.IPAccess.inc");
  require_once(INIT_DIR . "env.inc");
  require_once(INIT_DIR . "db.inc");
  require_once(MODULE_DIR . "user/mod.user.inc");
  require_once(INIT_DIR . "smarty.inc");
  require_once(MODULE_DIR . "structure/mod.structure.inc");



  $objStructure->fnInclude();

  if ($_SESSION["user"]) {
    $arrUserRights = $objUserRights->fnGetRights("", $_SESSION["user"]->ID);

    if ($_SESSION["user"]->realname != "anonymous") {
      $recUser = $objUser->fnGetDataRecord("username='loggeduser' and usertype='client'", "ID");
      if (is_object($recUser)) {
        $arrCommonRights = $objUserRights->fnGetRights("", $recUser->ID);

        if (is_array($arrCommonRights)) {
          foreach($arrCommonRights as $key => $item) {
            if (!$arrUserRights[$key]) {
              $arrUserRights[$key] = $item;
            }
          }
        }
      }
    }

    $arrGlobalRights = $objStructure->fnGetNode(1, "rights", "", "", $arrUserRights);
  }

  if ($arrGlobalRights[$_GET["ID"]] != "read") {
    if ($_SESSION["lang"]) {
      include_once(CONFIG_DIR . $_SESSION["lang"] . ".translation.inc");
      die($arrTranslation["file"]["error"]["noaccess"]);
    }
  }


  $recFile = $objFile->fnGetDataRecord("parentID='" . $_GET["ID"] . "'", "filename");
  if (is_object($recFile)) {
    header("Expires: ".gmdate("D, d M Y H:i:s")." GMT");
    header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
    header("Cache-Control: no-store, no-cache, must-revalidate");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: ");
    header("Cache-control: ");
    header("Content-type: application/octet-stream\n");
    header("Content-disposition: attachment; filename=".$recFile->filename."\n");
    header("Content-transfer-encoding: binary\n");

    @readfile(FILE_DIR . $_GET["ID"]);
  }
?>