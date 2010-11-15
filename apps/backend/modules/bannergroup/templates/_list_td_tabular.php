<td class="sf_admin_text sf_admin_list_td_name">
  <a  href="<?php echo url_for('@banner_group_edit?id='.$banner_group['id'])?>"><?php echo $banner_group->getName() ?></a>
</td>
<td class="sf_admin_text sf_admin_list_td_type">
  <?php echo $banner_group->getType() ?>
</td>
<td class="sf_admin_boolean sf_admin_list_td_is_active">
  <?php echo get_partial('bannergroup/list_field_boolean', array('value' => $banner_group->getIsActive())) ?>
</td>
