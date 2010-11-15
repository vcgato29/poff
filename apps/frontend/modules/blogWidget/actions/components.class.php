<?php
class blogWidgetComponents extends myComponents
{
  public function executeRender()
  {
       require_once(dirname(__FILE__) . "/../../../../../rss.php");
        $rss = new Blog;
        $this->blog = $rss->blog;
  }

}