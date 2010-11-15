<?php
  require_once("../cfg/admin/pre.inc");
  require_once(INIT_DIR . "env.inc");
  require_once(INIT_DIR . "smarty.inc");
  require_once(INIT_DIR . "db.inc");
  require_once(MODULE_DIR . "user/mod.user.inc");
  require_once(MODULE_DIR . "structure/mod.structure.inc");

  require_once(MODULE_DIR . "user/mod.usergroup.inc");
  require_once(MODULE_DIR . "statistics/mod.query.inc");


/*****
  $recData->name = "objUser SQL creation";
  $recData->value = ($objUser->fnCreateTable()) ? "Success": "Failure";
  $arrData[] = $recData;


  $recUser->ID = 1;
  $recUser->realname = "Mastermind";
  $recUser->username = "root";
  $recUser->password = md5("pass");
  $recUser->usertype = "admin";

  $recData->name = "User 'root' creation";
  $recData->value = ($objUser->fnInsertData($recUser)) ? "Success": "Failure";
  $arrData[] = $recData;


  $recUser->ID = 2;
  $recUser->realname = "anonymous";
  $recUser->username = "anonymous";
  $recUser->password = "anonymous";
  $recUser->usertype = "client";

  $recData->name = "User 'anonymous' creation";
  $recData->value = ($objUser->fnInsertData($recUser)) ? "Success": "Failure";
  $arrData[] = $recData;


  $recUser->ID = 3;
  $recUser->realname = "loggeduser";
  $recUser->username = "loggeduser";
  $recUser->password = "loggeduser";
  $recUser->usertype = "client";

  $recData->name = "User 'loggeduser' creation";
  $recData->value = ($objUser->fnInsertData($recUser)) ? "Success": "Failure";
  $arrData[] = $recData;


  $recData->name = "objUserGroup SQL creation";
  $recData->value = ($objUserGroup->fnCreateTable()) ? "Success": "Failure";
  $arrData[] = $recData;

  $recData->name = "objUGRelation SQL creation";
  $recData->value = ($objUGRelation->fnCreateTable()) ? "Success": "Failure";
  $arrData[] = $recData;

  $recData->name = "objUserLog SQL creation";
  $recData->value = ($objUserLog->fnCreateTable()) ? "Success": "Failure";
  $arrData[] = $recData;

/*****/

/*****/
  $objStructure->fnInclude();
  $objStructure->classStructure();
/*
  $recData->name = "objStructure SQL creation";
  $recData->value = ($objStructure->fnCreateTable()) ? "Success": "Failure";
  $arrData[] = $recData;

  $recStructure->ID = 1;
  $recStructure->title = "root";
  $recStructure->parentID = 0;
  $recStructure->type = "root";
  $recStructure->validNodes = "documents:1;settings:1;statistics:1";
  $recStructure->modified = date("Y-m-d H:i:s");

  $recData->name = "Structure 'root' creation";
  $recData->value = ($objStructure->fnInsertData($recStructure)) ? "Success": "Failure";
  $arrData[] = $recData;


  $recStructure->ID = 2;
  $recStructure->title = "Dokumendid";
  $recStructure->parentID = 1;
  $recStructure->type = "documents";
  $recStructure->validNodes = "lang:*;article:1";
  $recStructure->modified = date("Y-m-d H:i:s");

  $recData->name = "Structure 'documents' creation";
  $recData->value = ($objStructure->fnInsertData($recStructure)) ? "Success": "Failure";
  $arrData[] = $recData;


  $recStructure->ID = 3;
  $recStructure->title = "Seadistused";
  $recStructure->parentID = 1;
  $recStructure->type = "settings";
  $recStructure->validNodes = "users:1;usergroups:1";
  $recStructure->modified = date("Y-m-d H:i:s");

  $recData->name = "Structure 'settings' creation";
  $recData->value = ($objStructure->fnInsertData($recStructure)) ? "Success": "Failure";
  $arrData[] = $recData;


  $recStructure->ID = 4;
  $recStructure->title = "Kasutajad";
  $recStructure->parentID = 3;
  $recStructure->type = "users";
  $recStructure->validNodes = "";
  $recStructure->modified = date("Y-m-d H:i:s");

  $recData->name = "Structure 'users' creation";
  $recData->value = ($objStructure->fnInsertData($recStructure)) ? "Success": "Failure";
  $arrData[] = $recData;


  $recStructure->ID = 5;
  $recStructure->title = "Kasutajagrupid";
  $recStructure->parentID = 3;
  $recStructure->type = "usergroups";
  $recStructure->validNodes = "";
  $recStructure->modified = date("Y-m-d H:i:s");

  $recData->name = "Structure 'usergroups' creation";
  $recData->value = ($objStructure->fnInsertData($recStructure)) ? "Success": "Failure";
  $arrData[] = $recData;

**/
  $recStructure->ID = 6;
  $recStructure->title = "V&auml;lised kasutajad";
  $recStructure->parentID = 3;
  $recStructure->type = "clients";
  $recStructure->validNodes = "";
  $recStructure->modified = date("Y-m-d H:i:s");

  $recData->name = "Structure 'clients' creation";
  $recData->value = ($objStructure->fnInsertData($recStructure)) ? "Success": "Failure";
  $arrData[] = $recData;

/**
  $recStructure->ID = 7;
  $recStructure->title = "Statistika";
  $recStructure->parentID = 1;
  $recStructure->type = "statistics";
  $recStructure->validNodes = "query:1";
  $recStructure->modified = date("Y-m-d H:i:s");

  $recData->name = "Structure 'statistics' creation";
  $recData->value = ($objStructure->fnInsertData($recStructure)) ? "Success": "Failure";
  $arrData[] = $recData;


  $recStructure->ID = 8;
  $recStructure->title = "Otsingumootor";
  $recStructure->parentID = 7;
  $recStructure->type = "query";
  $recStructure->validNodes = "";
  $recStructure->modified = date("Y-m-d H:i:s");

  $recData->name = "Structure 'query' creation";
  $recData->value = ($objStructure->fnInsertData($recStructure)) ? "Success": "Failure";
  $arrData[] = $recData;


  $recStructure->ID = 9;
  $recStructure->title = "&Uuml;ldised moodulid";
  $recStructure->parentID = 1;
  $recStructure->type = "generic";
  $recStructure->validNodes = "";
  $recStructure->modified = date("Y-m-d H:i:s");

  $recData->name = "Structure 'generic' creation";
  $recData->value = ($objStructure->fnInsertData($recStructure)) ? "Success": "Failure";
  $arrData[] = $recData;


  $recStructure->ID = 10;
  $recStructure->title = "B&auml;nnerid";
  $recStructure->parentID = 9;
  $recStructure->type = "banner";
  $recStructure->validNodes = "";
  $recStructure->modified = date("Y-m-d H:i:s");

  $recData->name = "Structure 'banner' creation";
  $recData->value = ($objStructure->fnInsertData($recStructure)) ? "Success": "Failure";
  $arrData[] = $recData;

/*****/

/*****
  $recData->name = "objLang SQL creation";
  $recData->value = ($objLang->fnCreateTable()) ? "Success": "Failure";
  $arrData[] = $recData;

  $recData->name = "objFolder SQL creation";
  $recData->value = ($objFolder->fnCreateTable()) ? "Success": "Failure";
  $arrData[] = $recData;

  $recData->name = "objArticle SQL creation";
  $recData->value = ($objArticle->fnCreateTable()) ? "Success": "Failure";
  $arrData[] = $recData;

  $recData->name = "objContactform SQL creation";
  $recData->value = ($objContactform->fnCreateTable()) ? "Success": "Failure";
  $arrData[] = $recData;

  $recData->name = "objIndex SQL creation";
  $recData->value = ($objIndex->fnCreateTable()) ? "Success": "Failure";
  $arrData[] = $recData;

  $recData->name = "objFile SQL creation";
  $recData->value = ($objFile->fnCreateTable()) ? "Success": "Failure";
  $arrData[] = $recData;

  $recData->name = "objGallery SQL creation";
  $recData->value = ($objGallery->fnCreateTable()) ? "Success": "Failure";
  $arrData[] = $recData;

  $objGalleryPicture = @new classGalleryPicture;
  $recData->name = "objGalleryPicture SQL creation";
  $recData->value = ($objGalleryPicture->fnCreateTable()) ? "Success": "Failure";
  $arrData[] = $recData;

  $recData->name = "objNews SQL creation";
  $recData->value = ($objNews->fnCreateTable()) ? "Success": "Failure";
  $arrData[] = $recData;

  $recData->name = "objQuery SQL creation";
  $recData->value = ($objQuery->fnCreateTable()) ? "Success": "Failure";
  $arrData[] = $recData;

  $recData->name = "objBannercategory SQL creation";
  $recData->value = ($objBannercategory->fnCreateTable()) ? "Success": "Failure";
  $arrData[] = $recData;

  $recData->name = "objBannerpicture SQL creation";
  $recData->value = ($objBannerpicture->fnCreateTable()) ? "Success": "Failure";
  $arrData[] = $recData;

  $recData->name = "objForum SQL creation";
  $recData->value = ($objForum->fnCreateTable()) ? "Success": "Failure";
  $arrData[] = $recData;

  $recData->name = "objForumsection SQL creation";
  $recData->value = ($objForumsection->fnCreateTable()) ? "Success": "Failure";
  $arrData[] = $recData;

  $recData->name = "objForumtopic SQL creation";
  $recData->value = ($objForumtopic->fnCreateTable()) ? "Success": "Failure";
  $arrData[] = $recData;

  $recData->name = "objForummessage SQL creation";
  $recData->value = ($objForummessage->fnCreateTable()) ? "Success": "Failure";
  $arrData[] = $recData;

/*****/

/*****
  $recData->name = "objUserRights SQL creation";
  $recData->value = ($objUserRights->fnCreateTable()) ? "Success": "Failure";
  $arrData[] = $recData;

  $recRights->userID = 1;
  $recRights->type = "user";
  $recRights->structureID = 1;
  $recRights->rights = "write";

  $recData->name = "grant full access to user 'root'";
  $recData->value = ($objUserRights->fnInsertData($recRights)) ? "Success": "Failure";
  $arrData[] = $recData;


  $recRights->userID = 2;
  $recRights->type = "user";
  $recRights->structureID = 1;
  $recRights->rights = "read";

  $recData->name = "grant read access to user 'anonymous'";
  $recData->value = ($objUserRights->fnInsertData($recRights)) ? "Success": "Failure";
  $arrData[] = $recData;


  $recRights->userID = 3;
  $recRights->type = "user";
  $recRights->structureID = 1;
  $recRights->rights = "read";

  $recData->name = "grant read access to user 'loggeduser'";
  $recData->value = ($objUserRights->fnInsertData($recRights)) ? "Success": "Failure";
  $arrData[] = $recData;
/*****/


  $engSmarty->assign("arrData", $arrData);
  $engSmarty->display("constructor.tpl");
?>