<td colspan="26">
  <?php echo __('%%id%% - %%title%% - %%parameter%% - %%picture%% - %%content%% - %%inherits_layout%% - %%type%% - %%description%% - %%pageTitle%% - %%layout%% - %%metaDescription%% - %%metaKeywords%% - %%status%% - %%is_first%% - %%lang%% - %%pri%% - %%parentID%% - %%isHidden%% - %%slug%% - %%created_at%% - %%updated_at%% - %%lft%% - %%rgt%% - %%level%% - %%created_by%% - %%updated_by%%', array('%%id%%' => link_to($structure->getId(), 'structure_edit', $structure), '%%title%%' => $structure->getTitle(), '%%parameter%%' => $structure->getParameter(), '%%picture%%' => $structure->getPicture(), '%%content%%' => $structure->getContent(), '%%inherits_layout%%' => get_partial('structure/list_field_boolean', array('value' => $structure->getInheritsLayout())), '%%type%%' => $structure->getType(), '%%description%%' => $structure->getDescription(), '%%pageTitle%%' => $structure->getPageTitle(), '%%layout%%' => $structure->getLayout(), '%%metaDescription%%' => $structure->getMetaDescription(), '%%metaKeywords%%' => $structure->getMetaKeywords(), '%%status%%' => $structure->getStatus(), '%%is_first%%' => get_partial('structure/list_field_boolean', array('value' => $structure->getIsFirst())), '%%lang%%' => $structure->getLang(), '%%pri%%' => $structure->getPri(), '%%parentID%%' => $structure->getParentID(), '%%isHidden%%' => get_partial('structure/list_field_boolean', array('value' => $structure->getIsHidden())), '%%slug%%' => $structure->getSlug(), '%%created_at%%' => false !== strtotime($structure->getCreatedAt()) ? format_date($structure->getCreatedAt(), "f") : '&nbsp;', '%%updated_at%%' => false !== strtotime($structure->getUpdatedAt()) ? format_date($structure->getUpdatedAt(), "f") : '&nbsp;', '%%lft%%' => $structure->getLft(), '%%rgt%%' => $structure->getRgt(), '%%level%%' => $structure->getLevel(), '%%created_by%%' => $structure->getCreatedBy(), '%%updated_by%%' => $structure->getUpdatedBy()), 'messages') ?>
</td>