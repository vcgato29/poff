<td class="sf_admin_text sf_admin_list_td_id">
  <?php echo link_to($structure->getId(), 'structure_edit', $structure) ?>
</td>
<td class="sf_admin_text sf_admin_list_td_title">
  <?php echo $structure->getTitle() ?>
</td>
<td class="sf_admin_text sf_admin_list_td_parameter">
  <?php echo $structure->getParameter() ?>
</td>
<td class="sf_admin_text sf_admin_list_td_picture">
  <?php echo $structure->getPicture() ?>
</td>
<td class="sf_admin_text sf_admin_list_td_content">
  <?php echo $structure->getContent() ?>
</td>
<td class="sf_admin_boolean sf_admin_list_td_inherits_layout">
  <?php echo get_partial('structure/list_field_boolean', array('value' => $structure->getInheritsLayout())) ?>
</td>
<td class="sf_admin_text sf_admin_list_td_type">
  <?php echo $structure->getType() ?>
</td>
<td class="sf_admin_text sf_admin_list_td_description">
  <?php echo $structure->getDescription() ?>
</td>
<td class="sf_admin_text sf_admin_list_td_pageTitle">
  <?php echo $structure->getPageTitle() ?>
</td>
<td class="sf_admin_text sf_admin_list_td_layout">
  <?php echo $structure->getLayout() ?>
</td>
<td class="sf_admin_text sf_admin_list_td_metaDescription">
  <?php echo $structure->getMetaDescription() ?>
</td>
<td class="sf_admin_text sf_admin_list_td_metaKeywords">
  <?php echo $structure->getMetaKeywords() ?>
</td>
<td class="sf_admin_text sf_admin_list_td_status">
  <?php echo $structure->getStatus() ?>
</td>
<td class="sf_admin_boolean sf_admin_list_td_is_first">
  <?php echo get_partial('structure/list_field_boolean', array('value' => $structure->getIsFirst())) ?>
</td>
<td class="sf_admin_text sf_admin_list_td_lang">
  <?php echo $structure->getLang() ?>
</td>
<td class="sf_admin_text sf_admin_list_td_pri">
  <?php echo $structure->getPri() ?>
</td>
<td class="sf_admin_foreignkey sf_admin_list_td_parentID">
  <?php echo $structure->getParentID() ?>
</td>
<td class="sf_admin_boolean sf_admin_list_td_isHidden">
  <?php echo get_partial('structure/list_field_boolean', array('value' => $structure->getIsHidden())) ?>
</td>
<td class="sf_admin_text sf_admin_list_td_slug">
  <?php echo $structure->getSlug() ?>
</td>
<td class="sf_admin_date sf_admin_list_td_created_at">
  <?php echo false !== strtotime($structure->getCreatedAt()) ? format_date($structure->getCreatedAt(), "f") : '&nbsp;' ?>
</td>
<td class="sf_admin_date sf_admin_list_td_updated_at">
  <?php echo false !== strtotime($structure->getUpdatedAt()) ? format_date($structure->getUpdatedAt(), "f") : '&nbsp;' ?>
</td>
<td class="sf_admin_text sf_admin_list_td_lft">
  <?php echo $structure->getLft() ?>
</td>
<td class="sf_admin_text sf_admin_list_td_rgt">
  <?php echo $structure->getRgt() ?>
</td>
<td class="sf_admin_text sf_admin_list_td_level">
  <?php echo $structure->getLevel() ?>
</td>
<td class="sf_admin_text sf_admin_list_td_created_by">
  <?php echo $structure->getCreatedBy() ?>
</td>
<td class="sf_admin_text sf_admin_list_td_updated_by">
  <?php echo $structure->getUpdatedBy() ?>
</td>
