<td class="sf_admin_text sf_admin_list_td_name">
  <?php echo $new_item->getName() ?>
</td>
<td class="sf_admin_date sf_admin_list_td_active_start">
  <?php echo false !== strtotime($new_item->getActiveStart()) ? $new_item->getActiveStart() : '&nbsp;' ?>
  <?php //echo false !== strtotime($new_item->getActiveStart()) ? format_date($new_item->getActiveStart(), "f") : '&nbsp;' ?>
</td>
<td class="sf_admin_date sf_admin_list_td_active_end">
  <?php echo false !== strtotime($new_item->getActiveEnd()) ? $new_item->getActiveEnd() : '&nbsp;' ?>
  <?php //echo false !== strtotime($new_item->getActiveEnd()) ? format_date($new_item->getActiveEnd(), "f") : '&nbsp;' ?>
</td>
<td class="sf_admin_text sf_admin_list_td_newGroupsForForm">
  <?php echo $new_item->getNewGroupsForForm() ?>
</td>
<td class="sf_admin_text sf_admin_list_td_pri_form">
  <?php echo $new_item->getPriForm() ?>
</td>
