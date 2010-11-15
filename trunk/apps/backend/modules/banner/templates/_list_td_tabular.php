<td class="sf_admin_text sf_admin_list_td_name">
<a href="<?php echo url_for('@banner_edit?id='.$banner['id'])?>">  <?php echo $banner->getName() ?></a>
</td>
<td class="sf_admin_text sf_admin_list_td_type">
  <?php echo $banner->getType() ?>
</td>
<td class="sf_admin_text sf_admin_list_td_banner_group_name">
  <?php echo $banner->getBannerGroupName() ?>
</td>
<td class="sf_admin_text sf_admin_list_td_pictureImg">
  <?php echo $banner->getPictureImg() ?>
</td>
<td class="sf_admin_text sf_admin_list_td_pri_form">
  <?php echo $banner->getPriForm() ?>
</td>
