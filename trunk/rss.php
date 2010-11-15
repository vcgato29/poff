<?php
  /*
   * PHP script for importing data from RSS (PÖFF's blog information)
   * Project: poff.ee
   * Author: Robi-Steaven Bankier
   */

  require_once("importer_functions.inc");

  class Blog
  {
    public $server = 'poff.epl.ee';
    public $port = '80';
    public $url = '/feed/';
    public $nr_of_posts = 3;
    public $decodeUTF = true;

    public $blog;

    function __construct()
    {
      $this->blog = $this->readContent();
    }
    function readContent()
    {
      $data = read_xml_file($this->server, $this->port, $this->url);
      if (strlen($data) > 0)
      {
        $dom = new domDocument;
        $dom->loadXML(substr($data, 0, strrpos($data, '>') + 1));
        $arrFeeds = array();
        $count = 0;
        foreach ($dom->getElementsByTagName('item') as $node)
        {
          if (function_exists('date_parse'))
          {
            $date_raw = date_parse($node->getElementsByTagName('pubDate')->item(0)->nodeValue);
            //$date = date('H:i j.m.Y', mktime($date_raw['hour'], $date_raw['minute'], $date_raw['second'], $date_raw['month'], $date_raw['day'], $date_raw['year']));
            $date = date('j.m', mktime($date_raw['hour'], $date_raw['minute'], $date_raw['second'], $date_raw['month'], $date_raw['day'], $date_raw['year']));
          }
          else
          {
            $date1 = explode(' ', $node->getElementsByTagName('pubDate')->item(0)->nodeValue);
            $months = array('Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec');
            $months_n = array('01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12');
            $time = explode(':', $date1[4]);
            //$date = $time[0] . ':' . $time[1] . ' ' . intval($date1[1]) . '.' . str_replace($months, $months_n, $date1[2]) . '.' . $date1[3];
            $date = intval($date1[1]) . '.' . str_replace($months, $months_n, $date1[2]);
          }
          $itemRSS = array
          (
            'title' => mb_convert_case((!$this->decodeUTF)?utf8_decode($node->getElementsByTagName('title')->item(0)->nodeValue):$node->getElementsByTagName('title')->item(0)->nodeValue, MB_CASE_UPPER, "UTF-8"),
            'description' => substr((!$this->decodeUTF)?utf8_decode($node->getElementsByTagName('description')->item(0)->nodeValue):$node->getElementsByTagName('description')->item(0)->nodeValue, 0, 60),
            'link' => $node->getElementsByTagName('link')->item(0)->nodeValue
          );
          $itemRSS['date'] = $date;
          array_push($arrFeeds, $itemRSS);
          $count++;
          if ($count == $this->nr_of_posts)
            break;
        }
        return $arrFeeds;
      }
      return null;
    }
  }
?>