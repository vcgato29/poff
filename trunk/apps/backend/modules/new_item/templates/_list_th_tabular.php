<?php slot('sf_admin.current_header') ?>
<th class="sf_admin_text sf_admin_list_th_name">
  <?php if ('name' == $sort[0]): ?>
    <?php echo link_to(__('Name', array(), 'messages'), '@new_item', array('query_string' => 'sort=name&sort_type='.($sort[1] == 'asc' ? 'desc' : 'asc'))) ?>
    <?php echo image_tag(sfConfig::get('sf_admin_module_web_dir').'/images/'.$sort[1].'.png', array('alt' => __($sort[1], array(), 'sf_admin'), 'title' => __($sort[1], array(), 'sf_admin'))) ?>
  <?php else: ?>
    <?php echo link_to(__('Name', array(), 'messages'), '@new_item', array('query_string' => 'sort=name&sort_type=asc')) ?>
  <?php endif; ?>
</th>
<?php end_slot(); ?>
<?php include_slot('sf_admin.current_header') ?><?php slot('sf_admin.current_header') ?>
<th class="sf_admin_date sf_admin_list_th_active_start">
  <?php if ('active_start' == $sort[0]): ?>
    <?php echo link_to(__('Active start', array(), 'messages'), '@new_item', array('query_string' => 'sort=active_start&sort_type='.($sort[1] == 'asc' ? 'desc' : 'asc'))) ?>
    <?php echo image_tag(sfConfig::get('sf_admin_module_web_dir').'/images/'.$sort[1].'.png', array('alt' => __($sort[1], array(), 'sf_admin'), 'title' => __($sort[1], array(), 'sf_admin'))) ?>
  <?php else: ?>
    <?php echo link_to(__('Active start', array(), 'messages'), '@new_item', array('query_string' => 'sort=active_start&sort_type=asc')) ?>
  <?php endif; ?>
</th>
<?php end_slot(); ?>
<?php include_slot('sf_admin.current_header') ?><?php slot('sf_admin.current_header') ?>
<th class="sf_admin_date sf_admin_list_th_active_end">
  <?php if ('active_end' == $sort[0]): ?>
    <?php echo link_to(__('Active end', array(), 'messages'), '@new_item', array('query_string' => 'sort=active_end&sort_type='.($sort[1] == 'asc' ? 'desc' : 'asc'))) ?>
    <?php echo image_tag(sfConfig::get('sf_admin_module_web_dir').'/images/'.$sort[1].'.png', array('alt' => __($sort[1], array(), 'sf_admin'), 'title' => __($sort[1], array(), 'sf_admin'))) ?>
  <?php else: ?>
    <?php echo link_to(__('Active end', array(), 'messages'), '@new_item', array('query_string' => 'sort=active_end&sort_type=asc')) ?>
  <?php endif; ?>
</th>
<?php end_slot(); ?>
<?php include_slot('sf_admin.current_header') ?>

<?php slot('sf_admin.current_header') ?>
<th class="sf_admin_text sf_admin_list_th_newGroupsForForm">
  <?php echo __('Groups', array(), 'messages') ?>
</th>
<?php end_slot(); ?>
<?php include_slot('sf_admin.current_header') ?>


<?php slot('sf_admin.current_header') ?>
<th class="sf_admin_text sf_admin_list_th_pri_form">
	<?php if('pri' == $sort[0]):?>
    <?php echo link_to(__('Priority', array(), 'messages'), '@new_item', array('query_string' => 'sort=pri&sort_type='.($sort[1] == 'asc' ? 'desc' : 'asc'))) ?>
    <?php echo image_tag(sfConfig::get('sf_admin_module_web_dir').'/images/'.$sort[1].'.png', array('alt' => __($sort[1], array(), 'sf_admin'), 'title' => __($sort[1], array(), 'sf_admin'))) ?>
  <?php else: ?>
    <?php echo link_to(__('Priority', array(), 'messages'), '@new_item', array('query_string' => 'sort=pri&sort_type=asc')) ?>
	<?php endif;?>
  
</th>
<?php end_slot(); ?>



<?php include_slot('sf_admin.current_header') ?>