<td class="sf_admin_text sf_admin_list_td_order_number">
  <?php echo link_to($product_order->getOrderNumber(), 'product_order_edit', $product_order) ?>
</td>
<td class="sf_admin_enum sf_admin_list_td_status">
  <?php echo link_to($product_order->getStatus(), 'product_order_edit', $product_order) ?>
</td>
<td class="sf_admin_text sf_admin_list_td_has_notes">
  <?php echo __($product_order->getHasNotes()) ?>
</td>
<td class="sf_admin_date sf_admin_list_td_created_at">
  <?php echo false !== strtotime($product_order->getCreatedAt()) ? format_date($product_order->getCreatedAt(), "f") : '&nbsp;' ?>
</td>
<td class="sf_admin_boolean sf_admin_list_td_is_archived">
  <?php echo get_partial('orders/list_field_boolean', array('value' => $product_order->getIsArchived())) ?>
</td>
