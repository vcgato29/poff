<?php
  require_once("../cfg/pre.inc");
  require_once(CONFIG_DIR . "access.inc");
  require_once(CONFIG_DIR . "template.inc");
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

<head>
  <title>Arens</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <link rel="stylesheet" href="/style/style.css">
</head>
<body style="background:#FFB3B3">
<script>
  function doclose()
  {
    opener.location.reload();
    window.close()
  }
</script>

<?
  if(isSet($_POST["item_id"]))
  {
      //print "descript: ".nl2br($_POST["descript"])."<br>";
      //print "thumbdescript: ".nl2br($_POST["thumb_descript"])."<br>";
      $descript = str_replace("\n","",$_POST["descript"]);
      //$descript = preg_replace(Array('/<BR>$/', '/$<BR>/', '/^<BR>/', '/<BR>^/'), Array('<BR>', '<BR>', '<BR>', '<BR>'), $descript);
      //$descript = nl2br($_POST["descript"]);
      $descript = "<DIV>".$descript."</DIV>";
      $thumb_descript = str_replace("\n","<BR>",$_POST["thumb_descript"]);
      $thumb_descript = preg_replace(Array('/<BR>$/', '/$<BR>/', '/^<BR>/', '/<BR>^/'), Array('<BR>', '<BR>', '<BR>', '<BR>'), $thumb_descript);
      //$thumb_descript = nl2br($_POST["thumb_descript"]);
      $thumb_descript = "<DIV>".$thumb_descript."</DIV>";
      mysql_query("UPDATE newcms2_gallerypicture SET descript = '".$descript."', thumb_descript = '".$thumb_descript."' WHERE ID = '".$_POST["item_id"]."'")or die(mysql_error());
  ?>
      <table>
           <tr>
               <td>Andmed salvestatud</td>
           </tr>
           <tr>
               <td><input type="button" value="Sulge" onClick="javascript:doclose();"></td>
           </tr>
      </table>
  <?
  }
  else
  {

  if(isSet($_REQUEST["itemID"]))
  {
      $query = mysql_query("SELECT * FROM newcms2_gallerypicture WHERE ID = '".$_REQUEST["itemID"]."' LIMIT 1");
      $item = mysql_fetch_array($query);

      $descript = $item["descript"];

      $descript = str_replace("<BR>", "\n", $descript);

      $descript = str_replace("<DIV>", "", $descript);
      $descript = str_replace("</DIV>", "", $descript);
      $descript = str_replace("<", "", $descript);
      $descript = str_replace(">", "", $descript);

      $descript = strip_tags($descript);

      $thumb_descript = $item["thumb_descript"];

      $thumb_descript = str_replace("<BR>", "\n", $thumb_descript);

      $thumb_descript = str_replace("<DIV>", "", $thumb_descript);
      $thumb_descript = str_replace("</DIV>", "", $thumb_descript);
      $thumb_descript = str_replace("<", "", $thumb_descript);
      $thumb_descript = str_replace(">", "", $thumb_descript);

      $thumb_descript = strip_tags($thumb_descript);
  ?>
      <form method="post">
          <input type="hidden" name="item_id" value="<?=$_REQUEST["itemID"]?>">
          <table>
              <tr><td>Pildi kirjeldus:</td></tr>
              <tr>
                  <td><textarea cols="30" rows="7" name="descript"><?=$descript?></textarea></td>
              </tr>
              <tr><td></td></tr>
              <tr><td>Thumbnaili kirjeldus:</td></tr>
              <tr>
                  <td><textarea cols="30" rows="7" name="thumb_descript"><?=$thumb_descript?></textarea></td>
              </tr>
              <tr>
                  <td><input type="submit" value="Salvesta"></td>
              </tr>
          </table>
      </form>
  <?
  }

  }
?>
</body>
</html>
