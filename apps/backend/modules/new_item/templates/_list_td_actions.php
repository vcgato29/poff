<td>
  <ul class="sf_admin_td_actions">
  	<li class="sf_admin_action_edit"><a class="struct_node" onclick="javascript:return false;" href="<?php echo url_for('@new_item_edit?id='.$new_item['id'])?>"> Edit </a></li>
    <?php echo $helper->linkToDelete($new_item, array(  'params' =>   array(  ),  'confirm' => 'Are you sure?',  'class_suffix' => 'delete',  'label' => 'Delete',)) ?>
  </ul>
</td>
