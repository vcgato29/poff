<?php
  /* 
   * PHP script for importing data from XMLs
   * Project: poff.ee
   * Author: Robi-Steaven Bankier
   */
  ini_set('display_errors', "1");
  ini_set("memory_limit", "128M");
  ini_set("max_execution_time", "2400");
  
  require_once("./cfg/pre.inc");
  require_once(INIT_DIR . "db.inc");
  require_once(MODULE_DIR . "ind_functions.inc");
  require_once("importer_functions.inc");
  
  page_begin();
  
  if (@strcmp($_GET['accesskey'], 'crwdNuv4o6VfnytZFa82HEfRr97yMndhVxASjUBc'))
    die('Ligipääs keelatud!');
    
  if (@$_GET['mode'] == 'screenings')
    $mode = 'screenings';
  elseif (@$_GET['mode'] == 'all')
    $mode = 'all';
  else
    die('Importija režiim polnud valitud! XML\'i importimine katkestati.');
  
  if (!@$_GET['debug'])
  {
    $host = 'datakal.poff.ee';
    $port = '8080';
    // real information
    // NOTE: do not change items order
    $url_list = array
    (
      /* Countries                  */ '/xml?sql=xml_web_countries&root=root',
      /* Sections (productcategory) */ '/xml?sql=xml_web_sections&root=root',
      /* Cinemas                    */ '/xml?sql=xml_web_cinemas&root=root',
      /* Films (product)            */ '/xml?sql=xml_web_films&root=root',
      /* Screenings                 */ '/xml?sql=xml_web_screenings&root=root',
      /* Directors                  */ '/xml?sql=xml_web_directors&root=root'
    );
    $debug = 0;
  }
  else
  {
    $host = 'localhost';
    $port = '80';
    // testing information
    // NOTE: do not change items order
    $url_list = array
    (
      /* Countries                  */ '/xml_test/countries.xml',
      /* Sections (productcategory) */ '/xml_test/sections.xml',
      /* Cinemas                    */ '/xml_test/cinemas.xml',
      /* Films (product)            */ '/xml_test/films.xml',
      /* Screenings                 */ '/xml_test/screenings.xml',
      /* Directors                  */ '/xml_test/directors.xml'
    );
    $debug = 1;
  }
  
  if ($debug)
  {
    echo '<strong>TESTIMISE REŽIIM KÄIVITATUD.</strong><br /><br />';
  }
  
  if ($mode == 'screenings')
  {
    echo 'Valitud režiim: ajakava/linastused (screenings)<br /><br />';
    $data = read_xml_file($host, $port, $url_list[4]);
    if ($data)
    {
      $dom = new domDocument;
      $dom->loadXML($data);
      if (!$dom)
      {
        echo '<span style="font-weight: bold; color: red;">Tekkis viga XML\'i parsimisel.</span><br /><br />';
        echo '<span style="font-weight: bold; color: red;">XML\'i importimine ebaõnnestus.</span><br /><br />';
        exit;
      }
    }
    else
    {
      echo '<span style="font-weight: bold; color: red;">Ühenduse loomine ebaõnnestus. Info vastuvõtmine ebaõnnestus.</span><br /><br />';
      echo '<span style="font-weight: bold; color: red;">XML\'i importimine ebaõnnestus.</span><br /><br />';
      exit;
    }
    $import = @simplexml2array(simplexml_import_dom($dom));
    if ($debug)
    {
      echo '<strong>$import</strong>:<br /><br />';
      print_r($import);
      echo '<div style="margin-top: 4px; border-bottom: 1px solid grey;"></div>';
    }
    
    $data = read_xml_file($host, $port, $url_list[2]);
    if ($data)
    {
      $dom = new domDocument;
      $dom->loadXML($data);
      if (!$dom)
      {
        echo '<span style="font-weight: bold; color: red;">Tekkis viga XML\'i parsimisel.</span><br /><br />';
        echo '<span style="font-weight: bold; color: red;">XML\'i importimine ebaõnnestus.</span><br /><br />';
        exit;
      }
    }
    else
    {
      echo '<span style="font-weight: bold; color: red;">Ühenduse loomine ebaõnnestus. Info vastuvõtmine ebaõnnestus.</span><br /><br />';
      echo '<span style="font-weight: bold; color: red;">XML\'i importimine ebaõnnestus.</span><br /><br />';
      exit;
    }
    $import_cinemas = @simplexml2array(simplexml_import_dom($dom));
    if ($debug)
    {
      echo '<strong>$import_cinemas</strong>:<br /><br />';
      print_r($import_cinemas);
      echo '<div style="margin-top: 4px; border-bottom: 1px solid grey;"></div>';
    }
    
    $sql_screenings = 'INSERT INTO `newcms2_catalog_product_screenings` (`id`,`film_id`, `date`, `time`, `cinema_id`, `ID_AKCE`, `buylink`, `subtitles`, `info_est`, `info_eng`, `code`) VALUES ';
    $old_screenings = get_screenings();
    if ($debug)
    {
      echo '<strong>$old_screenings:</strong><br /><br />';
      print_r($old_screenings);
      echo '<div style="margin-top: 4px; border-bottom: 1px solid grey;"></div>';
    }
    
    $films_ids = get_films_ids();
    if ($debug)
    {
      echo '<strong>$films_ids:</strong><br /><br />';
      print_r($films_ids);
      echo '<div style="margin-top: 4px; border-bottom: 1px solid grey;"></div>';
    }
    
    $related_cinemas = array();
    $unique_screenings = array();
    
    // (`id`,`film_id`, `date`, `time`, `cinema_id`, `ID_AKCE`, `buylink`, `subtitles`, `info_est`, `info_eng`, `code`)
    foreach($import['POFF_SCREENINGS'] as $screening)
    {
      if ($screening['ID_AKCE'] == '8')
      {
        if (in_array($screening['film_id'], $films_ids) && !in_array($screening['screening_id'], $unique_screenings))
        {
          // trimming and escaping all array values
          foreach($screening as &$param)
          $param = mysql_real_escape_string(trim($param));

          $date_raw = explode('.', $screening['date']);
          $date = $date_raw[2] . '-' . $date_raw[1] . '-' . $date_raw[0];
          $time_raw = explode(':', $screening['time']);
          $time = $time_raw[0] . ':' . $time_raw[1] . ':' . '00';
          
          $screenings_temp = '('.$screening['screening_id'].', "'.$screening['film_id'].'", "'.$date.'", "'.$time.'", "'.$screening['cinema'].'", "'.$screening['ID_AKCE'].'"';
          
          if (is_array($old_screenings))
          {
            if (array_key_exists($screening['screening_id'], $old_screenings))
            {
              $screenings_temp .= ',"'.$old_screenings[$screening['screening_id']]['buylink'].'","'.$old_screenings[$screening['screening_id']]['subtitles'].'","'.$old_screenings[$screening['screening_id']]['info_est'].'","'.$old_screenings[$screening['screening_id']]['info_eng'].'","'.$old_screenings[$screening['screening_id']]['code'].'"';
            }
            else
              $screenings_temp .= ',"'.mysql_real_escape_string('http://piletilevi.ee/est/piletid/film/poff/?show=14696').'","'.mysql_real_escape_string('{"est":0,"eng":0,"rus":0,"more":{"est":"","eng":""}}').'","","",""';
          }
          else
            $screenings_temp .= ',"'.mysql_real_escape_string('http://piletilevi.ee/est/piletid/film/poff/?show=14696').'","'.mysql_real_escape_string('{"est":0,"eng":0,"rus":0,"more":{"est":"","eng":""}}').'","","",""';
          
          $screenings_temp .= ')';
          
          $screenings[] = $screenings_temp;
          
          if (!in_array($screening['cinema'], $related_cinemas))
            $related_cinemas[] = $screening['cinema'];
            
          $unique_screenings[] = $screening['screening_id'];
        }
      }
    }
    
    if ($debug)
    {
      echo '<strong>$related_cinemas:</strong><br /><br />';
      print_r($related_cinemas);
      echo '<div style="margin-top: 4px; border-bottom: 1px solid grey;"></div>';
    }
    
    $sql_cinemas = 'INSERT INTO `newcms2_catalog_product_cinemas` (`id`,`title_eng`,`title_est`) VALUES ';
    foreach($import_cinemas['POFF_CINEMAS'] as $cinema)
    {
      if (in_array($cinema['@attributes']['CINEMA_ID'], $related_cinemas))
        $cinemas[] = '(' . $cinema['@attributes']['CINEMA_ID'] . ',"'.mysql_real_escape_string($cinema['@attributes']['CINEMA_ENGLISH']).'","'.mysql_real_escape_string($cinema['@attributes']['CINEMA_ESTONIAN']).'")';
    }
    
    if (isset($cinemas))
      $sql_cinemas .= implode(',', $cinemas) . ';';
    else
      $sql_cinemas = '';
    
    if (isset($screenings))
      $sql_screenings .= implode(',', $screenings) . ';';
    else
      $sql_screenings = '';
      
    if ($debug)
    {
      echo '<strong>$sql_screenings:</strong><br /><br />';
      print_r($sql_screenings);
      echo '<div style="margin-top: 4px; border-bottom: 1px solid grey;"></div>';
      echo '<strong>$sql_cinemas:</strong><br /><br />';
      print_r($sql_cinemas);
      echo '<div style="margin-top: 4px; border-bottom: 1px solid grey;"></div>';
    }
    
    if (strlen($sql_screenings) > 0)
    {
      truncate_tables(array('newcms2_catalog_product_screenings', 'newcms2_catalog_product_cinemas'));
      perform_queries(array($sql_screenings, $sql_cinemas));
    }
    else
    {
      echo 'Päring <em>$sql_screenings</em> oli tühi.<br />Tabelit `<em>newcms2_catalog_product_screenings</em>` ei tühjendatud.<br />Salvestamise päringut ei sooritatud.<br /><br />';
    }
  }
  elseif ($mode == 'all')
  {
    echo 'Valitud režiim: kogu info<br /><br />';
    foreach ($url_list as $key => $url)
    {
      $data = read_xml_file($host, $port, $url);
      if ($data)
      {
        $dom[$key] = new domDocument;
        $dom[$key]->loadXML($data);
        if (!$dom[$key])
        {
          echo '<span style="font-weight: bold; color: red;">Tekkis viga XML\'i parsimisel. ['.$key.']</span>';
          exit;
        }
      }
      else
      {
        echo '<span style="font-weight: bold; color: red;">Ühenduse loomine ebaõnnestus. Info vastuvõtmine ebaõnnestus. ['.$key.']</span>';
        exit;
      }
    }
    
    foreach($dom as $key => $d)
      $imports[$key] = @simplexml2array(simplexml_import_dom($d));
    
    // receiving IDs about all variables in array
    $id = get_variables_ids();
    
    if (!$id)
    {
      echo '<span style="font-weight: bold; color: red;">Tekkis viga muutujate informatsiooni leidmisel.</span>';
      exit;
    }
  
    $sql_countries = 'INSERT INTO `newcms2_catalog_variable_selection` (`ID`,`parentID`,`name_eng`,`name_est`) VALUES ';
    $sql_sections = 'INSERT INTO `newcms2_catalog_category` (`ID`,`parentID`,`title_eng`,`title_est`,`name_eng`,`name_est`,`title_rus`,`name_rus`,`content_eng`,`content_est`) VALUES ';
    $sql_cinemas = 'INSERT INTO `newcms2_catalog_product_cinemas` (`id`,`title_eng`,`title_est`) VALUES ';
    
    $sql_films = 'INSERT INTO `newcms2_catalog_product` (`ID`,`parentID`,`title_est`,`title_eng`,`title_rus`,`name`,`title_visible`,`last_modified`,`modifier`) VALUES ';
    $sql_films_variables = 'INSERT INTO `newcms2_catalog_product_value` (`productID`,`variableID`,`value_est`,`value_eng`,`value_boolean`,`value_id`) VALUES ';
    $sql_films_categoris = 'INSERT INTO `newcms2_catalog_product_category` (`productID`,`categoryID`) VALUES ';
    
    $sql_directors = 'INSERT INTO `newcms2_catalog_product_directors` (`id`,`name`,`surname`,`filmography_eng`,`filmography_est`,`bio_eng`,`bio_est`,`statement_eng`,`statement_est`) VALUES ';
    $sql_screenings = 'INSERT INTO `newcms2_catalog_product_screenings` (`id`,`film_id`, `date`, `time`, `cinema_id`, `ID_AKCE`, `buylink`, `subtitles`, `info_est`, `info_eng`, `code`) VALUES ';
    
    // receiving non-removable variables and their values
    $old_values = get_variables_values(array($id['youtube'], $id['keywords'], $id['webpage']));
    $old_screenings = get_screenings();
    $old_sections = get_sections();
    
    $films_ids = array();
    $related_categories = array();
    $related_countries = array();
    $related_directors = array();
    $related_cinemas = array();
    
    $credits_estonian_replaceable = array('Prod:','Sts:','Op:','Muusika:','Mont:','Os:','Tootja:','Maailma müük:','Levitaja:','Filmikoopia:','<BR>');
    $credits_estonian_replacement = array('<b>Produtsent</b>:','<b>Stsenarist</b>:','<b>Operaator</b>:','<b>Muusika</b>:','<b>Montaaž</b>:','<b>Osatäitjad</b>:','<b>Tootja</b>:','<b>Maailma müük</b>:','<b>Levitaja</b>:','<b>Filmikoopia</b>:','<br />');
    $credits_english_replaceable = array('Prod:','Scr:','DoP:','Music:','Ed:','Cast:','Production:','World Sales:','Distributor:','Print:','<BR>');
    $credits_english_replacement = array('<b>Producer</b>:','<b>Scriptwriter</b>:','<b>Director of Photography</b>:','<b>Music</b>:','<b>Editor</b>:','<b>Cast</b>:','<b>Production</b>:','<b>World Sales</b>:','<b>Distributor</b>:','<b>Print</b>:','<br />');
  
    $unique_films = array();
    
    foreach($imports[3]['POFF_FILMS'] as $film)
    {
      if (!in_array($film['film_id'], $unique_films))
      {
        // trimming and escaping all array values
        foreach($film as &$param)
          $param = mysql_real_escape_string(htmlspecialchars(trim($param)));
        
        // (`ID`,`parentID`,`title_est`,`title_eng`,`title_rus`,`name`,`title_visible`,`last_modified`,`modifier`)
        $films[] = '(' .
          $film['film_id'] . ', ' .
          '0, ' .
          '"' . $film['title_estonian'] . '", ' .
          '"' . $film['title_english'] . '", ' .
          '"' . $film['title_english'] . '", ' .
          '"' . $film['film_id'] . '", ' .
          '"Y", ' .
          'CURRENT_TIMESTAMP, ' .
          '"XML"' . ')';
          
        // checking error ": " at the beginning of the string
        if (!strcmp(substr($film['credits_estonian'], 0, 2),': '))
          $credits_estonian_raw = substr($film['credits_estonian'], 2);
        else
          $credits_estonian_raw = $film['credits_estonian'];
        if (!strcmp(substr($film['credits_english'], 0, 2),': '))
          $credits_english_raw = substr($film['credits_english'], 2);
        else
          $credits_english_raw = $film['credits_english'];
        
        // replacing short tags
        $credits_estonian = mysql_real_escape_string(str_replace($credits_estonian_replaceable, $credits_estonian_replacement, $credits_estonian_raw));
        $credits_english = mysql_real_escape_string(str_replace($credits_english_replaceable, $credits_english_replacement, $credits_english_raw));
          
        // (`productID`,`variableID`,`value_est`,`value_eng`,`value_boolean`,`value_id`)
        $variables[] = '('.$film['film_id'].','.$id['title_original'].',"'.$film['title_original'].'","'.$film['title_original'].'","","")';
        $variables[] = '('.$film['film_id'].','.$id['color'].',"'.$film['color'].'","'.$film['color'].'","","")';
        $variables[] = '('.$film['film_id'].','.$id['format'].',"'.$film['format'].'","'.$film['format'].'","","")';
        $variables[] = '('.$film['film_id'].','.$id['country'].',"'.($film['country']?$film['country']:0).'","'.($film['country']?$film['country']:0).'","","")';
        $variables[] = '('.$film['film_id'].','.$id['year'].',"'.$film['year'].'","'.$film['year'].'","","")';
        $variables[] = '('.$film['film_id'].','.$id['runtime'].',"'.$film['runtime'].'","'.$film['runtime'].'","","")';
        $variables[] = '('.$film['film_id'].','.$id['premiere'].',"","","'.(($film['premiere'] == 'No')?0:1).'","")';
        $variables[] = '('.$film['film_id'].','.$id['synopsis'].',"'.$film['synopsis_estonian'].'","'.$film['synopsis_english'].'","","")';
        //$variables[] = '('.$film['film_id'].','.$id['cast'].',"'.$film['cast_estonian'].'","'.$film['cast_english'].'","","")';
        $variables[] = '('.$film['film_id'].','.$id['credits'].',"'.$credits_estonian.'","'.$credits_english.'","","")';
        $variables[] = '('.$film['film_id'].','.$id['director'].',"'.$film['director'].'","'.$film['director'].'","","")';
        $variables[] = '('.$film['film_id'].','.$id['language'].',"'.$film['language_estonian'].'","'.$film['language_english'].'","","")';
        $variables[] = '('.$film['film_id'].','.$id['history'].',"'.$film['festival_history'].'","'.$film['festival_history'].'","","")';
        $variables[] = '('.$film['film_id'].','.$id['datakal_id'].',"'.$film['datakal_id'].'","","","")';
        
        // adding non-removable variables' values
        if (is_array($old_values))
        {
          if (array_key_exists($film['film_id'], $old_values))
          {
            $variables[] = '('.$film['film_id'].','.$id['youtube'].',"'.$old_values[$film['film_id']][$id['youtube']]['value_est'].'","'.$old_values[$film['film_id']][$id['youtube']]['value_eng'].'","","")';
            $variables[] = '('.$film['film_id'].','.$id['keywords'].',"'.$old_values[$film['film_id']][$id['keywords']]['value_est'].'","'.$old_values[$film['film_id']][$id['keywords']]['value_eng'].'","","")';
            $variables[] = '('.$film['film_id'].','.$id['webpage'].',"'.$old_values[$film['film_id']][$id['webpage']]['value_est'].'","'.$old_values[$film['film_id']][$id['webpage']]['value_eng'].'","","")';
          }
        }
        
        // (`productID`,`categoryID`)
        $categories[] = '('.$film['film_id'].','.$film['section'].')';
        
        $films_ids[] = $film['film_id'];
        
        if (!in_array($film['section'], $related_categories))
          $related_categories[] = $film['section'];
  
        $film_countries = @explode(',', $film['country']);
        if (is_array($film_countries) && count($film_countries) > 0)
          foreach($film_countries as $c)
            if (!in_array($c, $related_countries))
              $related_countries[] = trim($c);
              
        $film_directors = @explode(',', $film['director']);
        if (is_array($film_directors) && count($film_directors) > 0)
          foreach($film_directors as $c)
            if (!in_array($c, $related_directors))
              $related_directors[] = trim($c);
              
        $unique_films[] = $film['film_id'];
      }
    }
    
    foreach($imports as $import)
    {
      if (is_array($import))
      {
        foreach($import as $key => $i)
        {
          if ($key == 'POFF_COUNTRIES')
          {
            foreach($i as $country)
              if (in_array($country['@attributes']['COUNTRY_ID'], $related_countries))
                $countries[] = '(' . $country['@attributes']['COUNTRY_ID'] . ','.$id['country'].',"'.mysql_real_escape_string($country['@attributes']['COUNTRY_ENGLISH']).'","'.mysql_real_escape_string($country['@attributes']['COUNTRY_ESTONIAN']).'")';
          }
          elseif ($key == 'POFF_SECTIONS')
          {
            // (`ID`,`parentID`,`title_eng`,`title_est`,`name_eng`,`name_est`,`title_rus`,`name_rus`,`content_eng`,`content_est`)
            $links_est[] = array();
            $links_eng[] = array();
            foreach($i as $section)
            {
              if (in_array($section['@attributes']['SECTION_ID'], $related_categories))
              {
                $link_est = mysql_real_escape_string(flattenName($section['@attributes']['SECTION_ESTONIAN']));
                if (!in_array($link_est, $links_est))
                {
                  $links_est[] = $link_est;
                }
                else
                {
                  $link_est .= $section['@attributes']['SECTION_ID'];
                  $links_est[] = $link_est;
                }
                $link_eng = mysql_real_escape_string(flattenName($section['@attributes']['SECTION_ENGLISH']));
                if (!in_array($link_eng, $links_eng))
                {
                  $links_eng[] = $link_eng;
                }
                else
                {
                  $link_eng .= $section['@attributes']['SECTION_ID'];
                  $links_eng[] = $link_eng;
                }
                
                foreach($section['@attributes'] as &$param)
                  $param = htmlspecialchars(trim($param));
                
                $sections_temp = '(' . $section['@attributes']['SECTION_ID'] . ',0,"'.mysql_real_escape_string($section['@attributes']['SECTION_ENGLISH']).'","'.mysql_real_escape_string($section['@attributes']['SECTION_ESTONIAN']).'","'.$link_eng.'","'.$link_est.'","'.mysql_real_escape_string($section['@attributes']['SECTION_ENGLISH']).'","'.$link_eng.'"';
                
                if (is_array($old_sections))
                {
                  if (array_key_exists($section['@attributes']['SECTION_ID'], $old_sections))
                  {
                    $sections_temp .= ',"'.$old_sections[$section['@attributes']['SECTION_ID']]['content_eng'].'","'.$old_sections[$section['@attributes']['SECTION_ID']]['content_est'].'"';
                  }
                  else
                    $sections_temp .= ',"",""';
                }
                else
                  $sections_temp .= ',"",""';
                  
                $sections_temp .= ')';
                
                $sections[] = $sections_temp;
              }
            }
          }
          elseif ($key == 'POFF_DIRECTORS')
          {
            $unique_directors = array();
            // (`id`,`name`,`surname`,`filmography_eng`,`filmography_est`,`bio_eng`,`bio_est`,`statement_eng`,`statement_est`)
            foreach($i as $director)
            {
              if (in_array($director['DIRECTOR_ID'], $related_directors) && !in_array($director['DIRECTOR_ID'], $unique_directors))
              {
                // trimming and escaping all array values
                foreach($director as &$param)
                  $param = mysql_real_escape_string(htmlspecialchars(trim($param)));
                
                // (`id`,`name`,`surname`,`filmography_eng`,`filmography_est`,`bio_eng`,`bio_est`,`statement_eng`,`statement_est`)
                $directors[] = '('.$director['DIRECTOR_ID'].',"'.$director['NAME'].'","'.$director['SURNAME'].'","'.((array_key_exists('filmography_english', $director))?$director['filmography_english']:'').'","'.((array_key_exists('filmography_english', $director))?$director['filmography_english']:'').'","'.((array_key_exists('director_bio_english', $director))?$director['director_bio_english']:'').'","'.((array_key_exists('director_bio_estonian', $director))?$director['director_bio_estonian']:'').'","'.((array_key_exists('director_statement_english', $director))?$director['director_statement_english']:'').'","'.((array_key_exists('director_statement_estonian', $director))?$director['director_statement_estonian']:'').'")';
                
                $unique_directors[] = $director['DIRECTOR_ID'];
              }
            }
          }
          elseif ($key == 'POFF_SCREENINGS')
          {
            $unique_screenings = array();
            // (`id`, `film_id`, `date`, `time`, `cinema_id`, `ID_AKCE`, `buylink`, `subtitles`)
            foreach($i as $screening)
            {
              if ($screening['ID_AKCE'] == '8')
              {
                if (in_array($screening['film_id'], $films_ids) && !in_array($screening['screening_id'], $unique_screenings))
                {
                  // trimming and escaping all array values
                  foreach($screening as &$param)
                  $param = mysql_real_escape_string(trim($param));
  
                  $date_raw = explode('.', $screening['date']);
                  $date = $date_raw[2] . '-' . $date_raw[1] . '-' . $date_raw[0];
                  $time_raw = explode(':', $screening['time']);
                  $time = $time_raw[0] . ':' . $time_raw[1] . ':' . '00';
                  
                  $screenings_temp = '('.$screening['screening_id'].', "'.$screening['film_id'].'", "'.$date.'", "'.$time.'", "'.$screening['cinema'].'", "'.$screening['ID_AKCE'].'"';
                  
                  if (is_array($old_screenings))
                  {
                    if (array_key_exists($screening['screening_id'], $old_screenings))
                    {
                      $screenings_temp .= ',"'.$old_screenings[$screening['screening_id']]['buylink'].'","'.$old_screenings[$screening['screening_id']]['subtitles'].'","'.$old_screenings[$screening['screening_id']]['info_est'].'","'.$old_screenings[$screening['screening_id']]['info_eng'].'","'.$old_screenings[$screening['screening_id']]['code'].'"';
                    }
                    else
                      $screenings_temp .= ',"'.mysql_real_escape_string('http://piletilevi.ee/est/piletid/film/poff/?show=14696').'","'.mysql_real_escape_string('{"est":0,"eng":0,"rus":0,"more":{"est":"","eng":""}}').'","","",""';
                  }
                  else
                    $screenings_temp .= ',"'.mysql_real_escape_string('http://piletilevi.ee/est/piletid/film/poff/?show=14696').'","'.mysql_real_escape_string('{"est":0,"eng":0,"rus":0,"more":{"est":"","eng":""}}').'","","",""';
                  
                  $screenings_temp .= ')';
                  
                  $screenings[] = $screenings_temp;
                  
                  if (!in_array($screening['cinema'], $related_cinemas))
                    $related_cinemas[] = $screening['cinema'];
                    
                  $unique_screenings[] = $screening['screening_id'];
                }
              }
            }  
          }
        }
      }
    }
    
    foreach($imports[2]['POFF_CINEMAS'] as $cinema)
    {
      if (in_array($cinema['@attributes']['CINEMA_ID'], $related_cinemas))
        $cinemas[] = '(' . $cinema['@attributes']['CINEMA_ID'] . ',"'.mysql_real_escape_string($cinema['@attributes']['CINEMA_ENGLISH']).'","'.mysql_real_escape_string($cinema['@attributes']['CINEMA_ESTONIAN']).'")';
    }
    
    $sql_countries .= implode(',', $countries) . ';';
    $sql_sections .= implode(',', $sections) . ';';
    if (isset($cinemas))
      $sql_cinemas .= implode(',', $cinemas) . ';';
    else
      $sql_cinemas = '';
    $sql_films .= implode(',', $films) . ';';
    $sql_films_variables .= implode(',', $variables) . ';';
    $sql_films_categoris .= implode(',', $categories) . ';';
    $sql_directors .= implode(',', $directors) . ';';
    if (isset($screenings))
      $sql_screenings .= implode(',', $screenings) . ';';
    else
      $sql_screenings = '';
    
    $tables = array
    (
      'newcms2_catalog_variable_selection',
      'newcms2_catalog_category',
      'newcms2_catalog_product_cinemas',
      'newcms2_catalog_product',
      'newcms2_catalog_product_value',
      'newcms2_catalog_product_category',
      'newcms2_catalog_product_directors',
      'newcms2_catalog_product_screenings'
    );
    
    truncate_tables($tables);
    perform_queries(array($sql_countries, $sql_sections, $sql_cinemas, $sql_films, $sql_films_variables, $sql_films_categoris, $sql_directors, $sql_screenings));
  }
  
  echo '<span style="font-weight: bold; color: green;">XML\'i importimine oli edukas!</span>';
  page_end();
?>