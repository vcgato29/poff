<td>
  <ul class="sf_admin_td_actions">
  	<li class=""><a href="<?php echo url_for('@new_item?group_id=' . $news_group['id'])?>">News</a></li>
    <li class="sf_admin_action_edit"><a class="struct_node" onclick="javascript:return false;" href="<?php echo url_for('@news_group_edit?id='.$news_group['id'])?>"> Edit </a></li>
    <?php echo $helper->linkToDelete($news_group, array(  'params' =>   array(  ),  'confirm' => 'Are you sure?',  'class_suffix' => 'delete',  'label' => 'Delete',)) ?>
  </ul>
</td>
