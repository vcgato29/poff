<?php
  /*
   * Functions for Importer
   * Project: poff.ee
   * Author: Robi-Steaven Bankier
   */
  function page_begin()
  {
    echo '<?xml version="1.0" encoding="UTF-8"?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"><html xmlns="http://www.w3.org/1999/xhtml" xml:lang="et" lang="et"><head><title>XML\'i importimine</title></head><body style="font-family: Verdana; font-size: 11px; margin: 4px;">';
  }
  function page_end()
  {
    echo '</body></html>';
  }
  function read_xml_file($domain = 'datakal.poff.ee', $port = 8080, $url = '')
  {
    $fp = fsockopen($domain, $port, $errno, $errstr);
    if ($fp)
    {
      $data = '';
      $out = "GET $url HTTP/1.1\r\n";
      $out .= "Host: ".$domain."\r\n";
      $out .= "Connection: Close\r\n\r\n";
      fwrite($fp, $out);
      while(!feof($fp)) 
      {
        $data .= fread($fp, 4096);
      }
      fclose($fp);
      $data = substr($data, strpos($data, "<?xml"));
      return $data;
    }
    else
    {
      return false;
    }
  }
  function save_to_file($data = '', $name = 'unknown')
  {
    $now = date('dmY_His');
    $f = @fopen('importer_backups/'.$now.'_'.$name.'.txt', 'w');
    @fwrite($f, json_encode($data));
    @fclose($f);
  }
  function simplexml2array($xml) 
  {
    if (get_class($xml) == 'SimpleXMLElement') 
    {
      $attributes = $xml->attributes();
      foreach($attributes as $k=>$v) 
      {
        if ($v) $a[$k] = (string) $v;
      }
      $x = $xml;
      $xml = get_object_vars($xml);
    }
    if (is_array($xml)) 
    {
      if (count($xml) == 0) return (string) $x;
      foreach($xml as $key=>$value) 
      {
        $r[$key] = simplexml2array($value);
      }
      //if (isset($a)) $r['@'] = $a;
        return $r;
    }
    return (string) $xml;
  }
  function get_variables_info()
  {
    global $engDB;
    $engDB->fnSendQuery('SELECT * FROM `newcms2_catalog_variable`;');
    $results = $engDB->fnGetResultAssocArray();
    if (is_array($results))
    {
      foreach($results as $result)
      {
        $variables[] = array('id' => $result['ID'], 'name' => $result['name'], 'type' => $result['type'], 'multiple' => ($result['multiple'] == 'Y')?1:0);
      }
      return $variables;
    }
    else
    {
      return false;
    }
  }
  function get_variables_ids()
  {
    global $engDB;
    $engDB->fnSendQuery('SELECT * FROM `newcms2_catalog_variable`;');
    $results = $engDB->fnGetResultAssocArray();
    if (is_array($results))
    {
      foreach($results as $result)
      {
        $variables[$result['name']] = $result['ID'];
      }
      return $variables;
    }
    else
    {
      return false;
    }
  }
  function get_id($key, $vars_info)
  {
    foreach($vars_info as $var)
    {
      if ($key == $var['name'])
        return $var['id'];
    }
  }
  function get_sql($key, $value, $film_id, $vars_info, $langs_num)
  {
    foreach($vars_info as $var)
    {
      //(`ID`, `productID`, `variableID`, `value_est`, `value_eng`, `value_boolean`)
      if ($key == $var['name'])
      {
        if ($var['type'] == 'text' && !$var['multiple'])
        {
          $sql = '(NULL,' . $film_id . ',' . $var['id'] . ',';
          $i = 1;
          while($i <= $langs_num)
          {
            $sqls[] = '"'.mysql_real_escape_string($value).'"';
            $i++;
          }
          $sql .= implode(',', $sqls) . ',"")';
        }
        elseif ($var['type'] == 'checkbox' && !$var['multiple'])
        {
          $sql = '(NULL,' . $film_id . ',' . $var['id'] . ',"","",'.(($value == 'No')?0:1).')';
        }
        return $sql;
      }
    }
  }
  function get_variables_values($ids = 0)
  {
    if (is_array($ids))
    {
      global $engDB;
      $engDB->fnSendQuery('SELECT * FROM `newcms2_catalog_product_value` WHERE `variableID` IN ('.implode(',', $ids).')');
      $results = $engDB->fnGetResultAssocArray();
      if (is_array($results))
      {
        $values = array();
        foreach($results as $result)
        {
          $values[$result['productID']][$result['variableID']] = array('value_est' => $result['value_est'], 'value_eng' => $result['value_eng'], 'value_rus' => $result['value_rus'], 'value_id' => $result['value_id'], 'value_boolean' => $result['value_boolean']);
        }
        save_to_file($values, 'products');
        return $values;
      }
    }
    return null;
  }
  function get_screenings()
  {
    global $engDB;
    $engDB->fnSendQuery('SELECT `id`,`buylink`,`subtitles`,`info_est`,`info_eng`,`code` FROM `newcms2_catalog_product_screenings`;');
    $results = $engDB->fnGetResultAssocArray();
    if (is_array($results))
    {
      $values = array();
      foreach($results as $result)
      {
        $values[$result['id']] = array('buylink' => mysql_real_escape_string($result['buylink']), 'subtitles' => mysql_real_escape_string($result['subtitles']), 'info_est' => mysql_real_escape_string($result['info_est']), 'info_eng' => mysql_real_escape_string($result['info_eng']), 'code' => mysql_real_escape_string($result['code']));
      }
      save_to_file($values, 'screenings');
      return $values;
    }
  }
  function get_sections()
  {
    global $engDB;
    $engDB->fnSendQuery('SELECT * FROM `newcms2_catalog_category`;');
    $results = $engDB->fnGetResultAssocArray();
    if (is_array($results))
    {
      $values = array();
      foreach($results as $result)
      {
        $values[$result['ID']] = array
        (
          'content_est' => mysql_real_escape_string($result['content_est']),
          'content_eng' => mysql_real_escape_string($result['content_eng']),
          'content_rus' => mysql_real_escape_string($result['content_rus'])
          /*
          'metatitle_est' => $result['metatitle_est'],
          'metatitle_eng' => $result['metatitle_eng'],
          'metatitle_rus' => $result['metatitle_rus'],
          'metadescription_est' => $result['metadescription_est'],
          'metadescription_eng' => $result['metadescription_eng'],
          'metadescription_rus' => $result['metadescription_rus'],
          'metakeywords_est' => $result['metakeywords_est'],
          'metakeywords_eng' => $result['metakeywords_eng'],
          'metakeywords_rus' => $result['metakeywords_rus']
          */
        );
      }
      save_to_file($values, 'categories');
      return $values;
    }
    return null;
  }
  function get_films_ids()
  {
    global $engDB;
    $engDB->fnSendQuery('SELECT `ID` FROM `newcms2_catalog_product`;');
    $results = $engDB->fnGetResultAssocArray();
    $films_ids = array();
    if (is_array($results) && count($results) > 0)
    {
      foreach($results as $result)
        if (!in_array($result['ID'], $films_ids))
          $films_ids[] = $result['ID'];
      return $films_ids;
    }
    return null;
  }
  function truncate_tables($list)
  {
    global $engDB;
    foreach ($list as $item)
      $engDB->fnSendQuery('TRUNCATE TABLE `'.$item.'`;');
  }
  function perform_queries($list)
  {
    global $engDB;
    foreach ($list as $item)
      $engDB->fnSendQuery($item);
  }
?>