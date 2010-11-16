<?php

ini_set('display_errors','0');
ini_set('pcre.backtrack_limit','1000000');

require_once("cfg/pre.inc");
require_once(CONFIG_DIR . "access.inc");
require_once(MODULE_DIR . "access/class.IPAccess.inc");
require_once(INIT_DIR . "env.inc");
require_once(INIT_DIR . "lang.inc");
require_once(INIT_DIR . "db.inc");
require_once(INIT_DIR . "smarty.inc");
require_once(MODULE_DIR . "structure/mod.structure.inc");
require_once(MODULE_DIR . "user/mod.user.inc");
require_once(MODULE_DIR . "user/mod.usergroup.inc");
require_once(MODULE_DIR . "productcatalog/mod.category.inc");
require_once(MODULE_DIR . "statistics/mod.query.inc");
require_once(MODULE_DIR . "ind_functions.inc");
require_once(MODULE_DIR . "comments.inc");
require_once(MODULE_DIR . "phpmailer/class.phpmailer.php");
//require_once(MODULE_DIR . "productcatalog/mod.productamounts.inc");

//check if user IP has rights to see the page
if (!$objIPAccess->fnValidate($arrAllowIP["access"], $_SERVER["REMOTE_ADDR"]) or $objIPAccess->fnValidate($arrAllowIP["deny"], $_SERVER["REMOTE_ADDR"]))
{
}
else
{
  if (@$_POST['method'] == 'ajax' && @$_POST['module'] == 'myscreenings')
  {
    require_once(MODULE_DIR . "poffuser.inc");
    $POFF_user = new POFF_user;
    $POFF_user->ajax_action_listener($_POST['action']);
    exit();
  }
	$objStructure->fnInclude();
	if (!isset($_SESSION["lang"]))
	{
		$_SESSION["lang"] = DEFAULT_LANG;
	}
	// Get list of all available languages.
	$languages = $objStructure->fnGetDataList('type="lang" order by position', '*');
	foreach($languages as $lang)
	{
		$arrLanguageSelect[] = $objLang->fnGetDataRecord("parentID ='".$lang->ID."'");
	}
	$arrLanguageSelect[sizeof($arrLanguageSelect) - 1]->last = 1;
	$engSmarty->assign('arrLanguageSelect', $arrLanguageSelect);
	$_SERVER["REQUEST_URI"] = str_replace('?'.$_SERVER['QUERY_STRING'], '',$_SERVER['REQUEST_URI']);
	//get current requested node
	$recNode = $objStructure->fnGetNodeByPath($_SERVER["REQUEST_URI"]);
	require_once(MODULE_DIR . "structure/actions.userinit.inc");
	if (is_object($recNode) and ($arrGlobalRights[$recNode->rightID] == "read"))
	{
		$_SESSION["lang"] = $recNode->lang;
		$strTemplate = "mainpage.tpl";
		//node exists, get its language and language settings instead of default
		require_once(CONFIG_DIR . $_SESSION["lang"] . ".translation.inc");
		$engSmarty->assign("arrTranslation", $arrTranslation);
		require_once(MODULE_DIR . "structure/actions.banner.inc");
		require_once(MODULE_DIR . "structure/actions.sitevariables.public.inc");
		$arrTree = $objStructure->fnGetNode($recNode->ID, "menu", $recNode->langNodeID, "", $arrGlobalRights);
		$arrTree = menu_markPathSelected($recNode->path, $arrTree, 6);
		$arrPath = getNavigation($arrTree);
		include(MODULE_DIR . "structure/actions.content.inc");
		if(($recNode->ID != $arrContent[0]->parentFolderID) && $arrContent[0]->parentFolderID != '' && $arrContent[0]->parentFolderID != 0)
		{
			$curItem = menu_findItemById($arrContent[0]->parentFolderID, $arrTree);
			header("location:".$curItem->link);
			exit;
		}
		//include(MODULE_DIR . "structure/actions.comments.public.inc");
		//include(MODULE_DIR . "structure/actions.meta.inc");
    
    $engSmarty->assign("datetime", date('j.m.Y | H:i'));
    
		if ($strError)
			$engSmarty->assign("strError", $strError);
    
    $_SESSION['comment_lang'] = $_SESSION["lang"];
    
    if ($_SESSION["lang"] == 'rus')
      $_SESSION["lang"] = 'eng';
      
    $_SESSION['link_to_programs'] = getItemByFolderParameter($arrTree, 'products-programs')->link;  
    $_SESSION['link_to_myscreenings'] = getItemByFolderParameter($arrTree, 'products-selftimes')->link;
    
    // FILMID A-Z / FILMS A-Z
    if ($recNode->parameters == 'products-filmsAZ')
    {
      $engSmarty->assign("filmsAZ_linktoprograms", getItemByFolderParameter($arrTree, 'products-programs')->link);
      $engSmarty->assign("filmsAZ_alphabet", receiveAlphabet());
      $engSmarty->assign("filmsAZ_dropmenus", receiveFilmsAZ_dropmenus());
      $engSmarty->assign("filmsAZ", receiveFilmsAZ($recNode->lang));
    }
    // ---------------------------------------------------------------------
    
    // PROGRAMMID / PROGRAMS & PROGAMMID: VALITUD PROGRAMM / PROGRAMS: SELECTED PROGRAM
    elseif ($recNode->parameters == 'products-programs')
    {
      $filmsPrograms = getItemByFolderParameter($arrTree, 'products-programs')->arrNode;
      
      foreach($filmsPrograms as &$program)
      {
        $program->title_list = mb_convert_case($program->title, MB_CASE_UPPER, "UTF-8");
      }
      $engSmarty->assign("filmsPrograms", $filmsPrograms);
      $directors = getDirectors();
      $countries = getCountries();
      if (isset($arrContent[0]->products))
      {
        // modification: for better speed - getDirectors
        foreach($arrContent[0]->products as $product)
        {
          foreach($product->arrVariable as $key => &$var)
          {
            if ($key == 'director')
            {
              $cs = @explode(',', $var->value->strValue);
              foreach($cs as &$c)
                $c = $directors[trim($c)];
              $var->value->strValue = implode(', ', $cs);
            }
            elseif ($key == 'country')
            {
              $cs = @explode(',', $var->value->strValue);
              $cs = array_unique($cs);
              foreach($cs as &$c)
                $c = $countries[trim($c)];
              $var->value->strValue = implode(', ', $cs);
            }
          }
        }
      }
      if (isset($arrContent[0]->active_product))
      {
        $engSmarty->assign("linkto_filmAZ", getItemByFolderParameter($arrTree, 'products-filmsAZ')->link);
        $arrContent[0]->active_product->title = mb_convert_case($arrContent[0]->active_product->title, MB_CASE_UPPER, "UTF-8");
        $arrContent[0]->active_product->title_eng = mb_convert_case($arrContent[0]->active_product->title_eng, MB_CASE_UPPER, "UTF-8");
        $arrContent[0]->active_product->screenings = receiveScreenings($arrContent[0]->active_product->ID);
        $arrContent[0]->active_product->category = getCategoriesForProducts(array($arrContent[0]->active_product->ID));
        foreach($arrContent[0]->active_product->arrVariable as $key => &$var)
        {
          if ($key == 'title_original')
          {
            $var->value->strValue = mb_convert_case($var->value->strValue, MB_CASE_UPPER, "UTF-8");
          }
          elseif ($key == 'director')
          {
            $cs = @explode(',', $var->value->strValue);
            foreach($cs as &$c)
            {
              $directors_list[] = $c;
              $c = $directors[trim($c)];
            }
            $var->value->strValue = implode(', ', $cs);
          }
          elseif ($key == 'country')
          {
            $cs = @explode(',', $var->value->strValue);
            $cs = array_unique($cs);
            foreach($cs as &$c)
              $c = $countries[trim($c)];
            $var->value->strValue = implode(', ', $cs);
          }
          elseif ($key == 'keywords')
          {
            $ks = @explode(',', $var->value->strValue);
            foreach($ks as &$c)
              $c = trim($c);
            $var->value->strValue = $ks;
          }
        }
        if (isset($directors_list) && count($directors_list) > 0)
          $engSmarty->assign('directors_data', getDirectorsData($directors_list));
          
        // COMMENTS
        require_once(MODULE_DIR . "poffcomments.inc");
        $POFF_comments = new POFF_comments;
        $action_listener = $POFF_comments->action_listener();
        $_SESSION['comment'] = array('time' => time(), 'name' => 'time');
        if ($action_listener === true)
          header('Location: '.$SYSTEM_PATH.'/'.$recNode->path.'/?productID='.$_GET['productID'].'&comments=show&lang='.$_SESSION['comment_lang'].'#comments');
        $engSmarty->assign('comments_status', $action_listener);
        $engSmarty->assign('comments_total', $POFF_comments->comments_total($_GET['productID']));
        if (@$_GET['comments'] == 'show')
          $engSmarty->assign('comments', $POFF_comments->get_comments($_GET['productID'], $_GET['lang']));
      }
    }
    // ---------------------------------------------------------------------
    
    // LINASTUSTE AJAKAVA / SCREENINGS
    elseif ($recNode->parameters == 'products-times')
    {
      $engSmarty->assign("filmsAZ_dropmenus", receiveFilmsAZ_dropmenus());
      $engSmarty->assign("screenings", findScreenings());
    }
    // ---------------------------------------------------------------------
    
    // OMA KAVA / MY SCREENINGS
    elseif ($recNode->parameters == 'products-selftimes')
    {
      require_once(MODULE_DIR . "poffuser.inc");
      $POFF_user = new POFF_user;
      $status = $POFF_user->action_listener($_POST['action']);
      $engSmarty->assign("screenings", $POFF_user->getScreenings());
      $engSmarty->assign("myscreenings_status", $status);
    }
    // ---------------------------------------------------------------------
    
    // AVALEHT / FIRST PAGE
    elseif ($recNode->parameters == 'firstpage' && empty($_GET['search']))
    {
      $arrNews = getItemByFolderParameter($arrTree, 'news')->arrNode;
      $countedNews = array();
      for ($i = 0; $i < 2; $i++)
      {
        $countedNews[] = $arrNews[$i];
      }
      foreach($countedNews as &$newsNode)
      {
        $newsNode->news = content_getByPath(str_replace(SYSTEM_PATH, '', $newsNode->link), $arrTree, $arrGlobalRights)->arrContent;
      }
      $engSmarty->assign('arrNews', $countedNews);
      $arrTabs = content_getByPath(str_replace(SYSTEM_PATH, '', getItemByFolderParameter($arrTree, 'tabs')->link), $arrTree, $arrGlobalRights)->arrContent;
      $engSmarty->assign('arrTabs', $arrTabs);
    }
    // ---------------------------------------------------------------------
    
    // OTSINGU TULEMUSED / SEARCH RESULTS
    elseif ($recNode->parameters == 'firstpage' && !empty($_GET['search']))
    {
      foreach($arrContent[0]->arrResult as &$result)
      {
        $result->title = mb_convert_case($result->title, MB_CASE_UPPER, "UTF-8");
        $result->searchContent = ucfirst(strip_tags(html_entity_decode($result->searchContent), '<b>'));
      }
    }
    // ---------------------------------------------------------------------
    
    // Banners
    if (is_array($arrBanner['left_top']))
    {
      $randomBanners['left_top'] = array($arrBanner['left_top'][rand(0, count($arrBanner['left_top']) - 1)]);
    }
    if (is_array($arrBanner['left_bottom']))
    {
      $left_bottom_1_rand = rand(0, count($arrBanner['left_bottom']) - 1);
      $randomBanners['left_bottom_1'] = array($arrBanner['left_bottom'][$left_bottom_1_rand]);
      $temp_array = array();
      foreach($arrBanner['left_bottom'] as $key => $banner)
      {
        if ($key != $left_bottom_1_rand)
          $temp_array[] = $banner;
      }
      $left_bottom_2_rand = rand(0, count($temp_array) - 1);
      if (count($temp_array) > 0)
        $randomBanners['left_bottom_2'] = array($temp_array[$left_bottom_2_rand]);
    }
    if (is_array($randomBanners))
      $engSmarty->assign('randomBanners', $randomBanners);
      
    // Ticker
    if (is_array($arrBanner['firstpage_ticker']))
    {
      foreach($arrBanner['firstpage_ticker'] as &$selBanner)
        if ($selBanner->title) $selBanner->title = mb_convert_case($selBanner->title, MB_CASE_UPPER, "UTF-8");
      $engSmarty->assign('countTicker', (count($arrBanner['firstpage_ticker']) - 1));
    }
    
    // RSS (PÖFF's blog data)
    if ($_SESSION['lang'] == 'est')
    {
      require_once('rss.php');
      $rss = new Blog;
      $engSmarty->assign('Blog', $rss->blog);
    }
    
    // MAILLIST
    if ($_SESSION['lang'] == 'est')
    {
      $maillist = content_getByPath(str_replace(SYSTEM_PATH, '', getItemByFolderParameter($arrTree, 'maillist')->link), $arrTree, $arrGlobalRights)->arrContent;
      foreach($maillist as &$m)
        $m->content = strip_tags($m->content, '<br><b><u><i><strong><em><underline><ul><li>'); 
      $engSmarty->assign('maillist', $maillist);
    }
    if (isset($_POST['show_options']) &&
        !empty($_POST['show_options']) &&
        $_POST['show_options'] != 'Sisesta e-posti aadress' &&
        $_SESSION['lang'] == 'est')
    {
      // CSI URL
      $api_url = 'http://csi.poff.ee/csi_connect.php?';
      
      // posted e-mail address
      $email = urlencode($_POST['show_options']);
      $api_url .= 'email='.$email;
      
      // groups' IDs on CSI
      $csi_ids = array
      (
        'ad' => 4,
        'hoff' => 6,
        'justfilm' => 5,
        'kumu' => 8,
        'poff' => 2,
        'sleepwalkers' => 3,
        'tartuff' => 7
      );
      
      // array for festivals' IDs
      $festivals = array();
      $count = 0;
      
      // determining which festivals were selected
      foreach($_POST as $k => $p)
      {
        if (substr($k, 0, 9) == 'festival_' && $p == 1)
        {
          $f = @explode('_', $k);
          if ($f[1] != 'all')
            $festivals[] = $csi_ids[$f[1]];
          $count++;
        }
      }
      
      // joining festivals' IDs with CSI URL
      $api_url .= '&groups='.implode(':', $festivals);
      
      // making request and expecting answer-result
      if ($count)
      {
        $result = file_get_contents($api_url);
        if($result != '' && $result != 'Error: e-mail incorrect')
          $msg = 0;
        else
          $msg = 1;
      }
      else
      {
        $msg = 1;
      }
      $engSmarty->assign('maillist_result', $msg);
    }
    
    $engSmarty->assign('arrNewsRight', content_getByPath(str_replace(SYSTEM_PATH, '', getItemByFolderParameter($arrTree, 'newsright')->link), $arrTree, $arrGlobalRights));
		$engSmarty->assign('arrTopMenu', content_getByPath(str_replace(SYSTEM_PATH, '', getItemByFolderParameter($arrTree, 'topmenu')->link), $arrTree, $arrGlobalRights)->arrContent[0]);
    $engSmarty->assign('arrArchive', content_getByPath(str_replace(SYSTEM_PATH, '', getItemByFolderParameter($arrTree, 'archive')->link), $arrTree, $arrGlobalRights)->arrContent[0]->arrLink);
		$engSmarty->assign("arrLeftMenu", flattenTree($arrTree));
    $engSmarty->assign('SYSTEM_PATH', SYSTEM_PATH);
		$engSmarty->assign("arrContent", $arrContent);
		//$engSmarty->assign("arrPath", $arrPath);
		$engSmarty->assign("siteVariables", $siteVariables);
		$engSmarty->assign('arrLanguageSelect', $arrLanguageSelect);
		$engSmarty->assign("recNode", $recNode);
		//$engSmarty->assign("strPath", SYSTEM_PATH . "/" . $recNode->path);
	}
	elseif (!is_object($recNode))
	{
		header("Location: ".SYSTEM_PATH."/" . DEFAULT_LANG);
		exit;
	}
	else
	{
		$strTemplate = "content.noaccess.tpl";
	}
}

$engSmarty->debugging = false;
if (!$engSmarty->debugging)
{
  $output = $engSmarty->fetch($strTemplate);
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
  $engSmarty->display($strTemplate);
}

?>