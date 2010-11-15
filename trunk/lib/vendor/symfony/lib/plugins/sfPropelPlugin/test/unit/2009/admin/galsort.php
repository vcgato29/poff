<?php
  require_once("../cfg/pre.inc");
  require_once(CONFIG_DIR . "access.inc");
  require_once(MODULE_DIR . "access/class.IPAccess.inc");
  require_once(INIT_DIR . "env.inc");
  require_once(INIT_DIR . "lang.inc");
  require_once(INIT_DIR . "db.inc");
  require_once(INIT_DIR . "smarty.inc");
  require_once(MODULE_DIR . "structure/mod.structure.inc");
  require_once(MODULE_DIR . "user/mod.user.inc");
  require_once(MODULE_DIR . "user/mod.usergroup.inc");
  require_once(MODULE_DIR . "statistics/mod.query.inc");
?>
<html>
<body onLoad="javascript:doclose();">
<script>
  function doclose()
  {
    opener.location.reload();
    window.close()
  }
</script>
<?php
  function getItem($id)
  {
      $get_q = mysql_query("SELECT * FROM newcms2_gallerypicture WHERE ID = ".$id." LIMIT 1")or die(mysql_error());
      $get = mysql_fetch_array($get_q);
      return $get;
  }

  function getUpperItem($item)
  {
      $parent_id = $item["parentID"];
      $cursort = $item["sort"];

      $galitems_q = mysql_query("SELECT * FROM newcms2_gallerypicture WHERE parentID = ".$parent_id."")or die(mysql_error());
      $nearestup = -1;
      while($galitem = mysql_fetch_array($galitems_q))
      {
          if($galitem["sort"] < $cursort && $galitem["sort"] > $nearestup)
          {
              $nearestup = $galitem["sort"];
              $found = $galitem["ID"];
          }
      }
      if(isSet($found) && $found > 0)
      {
          return getItem($found);
      }
      else{return 0;}
  }

  function getLowerItem($item)
  {
      $parent_id = $item["parentID"];
      $cursort = $item["sort"];
      print "cursort: ".$cursort."<br>";

      $galitems_q = mysql_query("SELECT * FROM newcms2_gallerypicture WHERE parentID = ".$parent_id."")or die(mysql_error());
      $nearestlow = 999999999999;
      while($galitem = mysql_fetch_array($galitems_q))
      {
          print "isort: ".$galitem["sort"]."<br>";
          if($galitem["sort"] > $cursort && $galitem["sort"] < $nearestlow)
          {
              $nearestlow = $galitem["sort"];
              $found = $galitem["ID"];
          }
      }
      if(isSet($found) && $found > 0)
      {
          return getItem($found);
      }
      else{return 0;}
  }

  function moveUp($item)
  {
      $upperitem = getUpperItem($item);
      print "got upperitem: ".$upperitem."<br>";
      if(is_array($upperitem))
      {
          mysql_query("UPDATE newcms2_gallerypicture SET sort = '".$upperitem["sort"]."' WHERE ID = '".$item["ID"]."'")or die(mysql_error());
          mysql_query("UPDATE newcms2_gallerypicture SET sort = '".$item["sort"]."' WHERE ID = '".$upperitem["ID"]."'")or die(mysql_error());
      }
  }

  function moveDown($item)
  {
      $loweritem = getLowerItem($item);
      print "got loweritem: ".$loweritem."<br>";
      if(is_array($loweritem))
      {
          mysql_query("UPDATE newcms2_gallerypicture SET sort = '".$loweritem["sort"]."' WHERE ID = '".$item["ID"]."'");
          mysql_query("UPDATE newcms2_gallerypicture SET sort = '".$item["sort"]."' WHERE ID = '".$loweritem["ID"]."'")or die(mysql_error());
      }
  }

  if(isSet($_REQUEST["action"]) && isSet($_REQUEST["itemID"]))
  {
      $item = getItem($_REQUEST["itemID"]);
      $action = $_REQUEST["action"];

      print "item: ".$item."<br>";

      if("up" == $action)
      {
          print "moveing up<br>";
          moveUp($item);
      }
      else if("down" == $action)
      {
          print "moveing down<br>";
          moveDown($item);
      }
  }
  print "done";
?>
</body>
</html>