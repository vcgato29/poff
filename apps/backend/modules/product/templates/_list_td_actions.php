<td>
  <ul class="sf_admin_td_actions">
  <li class="sf_admin_action_edit">
      <a class="struct_node" onclick="javascript:return false;" href="<?php echo url_for( $helper->getEditRoute(), $helper->getEditRouteParams($product))?>"> <?php echo __('Edit')?></a></li>
    <?php echo $helper->linkToDelete($product, array(  'params' =>   array(),  'confirm' => 'Are you sure?',  'class_suffix' => 'delete',  'label' => 'Delete',)) ?>
  </ul>
</td>
