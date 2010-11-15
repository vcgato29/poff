<td class="sf_admin_text sf_admin_list_td_code">
  <?php echo $product->getCode() ?>
</td>
<td class="sf_admin_text sf_admin_list_td_name">
  <a class="struct_node" onclick="javascript:return false;" href="<?php echo url_for( $helper->getEditRoute(), $helper->getEditRouteParams($product))?>"><?php echo $product->getName() ?></a>
</td>
<td class="sf_admin_text sf_admin_list_td_pri_form">
  <?php echo $product->getPriForm() ?>
</td>
<td class="sf_admin_text sf_admin_list_td_price">
  <?php echo $product->getPrice() ?>
</td>
<td class="sf_admin_text sf_admin_list_td_productGroupsForList">
  <?php echo $product->getProductGroupsForList() ?>
</td>
