<?php slot('sf_admin.current_header') ?>
<th class="sf_admin_text sf_admin_list_th_code">
  <?php if ('code' == $sort[0]): ?>
    <?php echo link_to(__('Code', array(), 'messages'), '@'.$helper->getIndexRoute(), array('query_string' => 'sort=code&sort_type='.($sort[1] == 'asc' ? 'desc' : 'asc'))) ?>
    <?php echo image_tag(sfConfig::get('sf_admin_module_web_dir').'/images/'.$sort[1].'.png', array('alt' => __($sort[1], array(), 'sf_admin'), 'title' => __($sort[1], array(), 'sf_admin'))) ?>
  <?php else: ?>
    <?php echo link_to(__('Code', array(), 'messages'), '@'.$helper->getIndexRoute(), array('query_string' => 'sort=code&sort_type=asc')) ?>
  <?php endif; ?>
</th>
<?php end_slot(); ?>
<?php include_slot('sf_admin.current_header') ?><?php slot('sf_admin.current_header') ?>
<th class="sf_admin_text sf_admin_list_th_name">
  <?php echo __('Name', array(), 'messages') ?>
</th>
<?php end_slot(); ?>
<?php include_slot('sf_admin.current_header') ?>



<?php slot('sf_admin.current_header') ?>
<th class="sf_admin_text sf_admin_list_th_pri_form">
	<?php if('pri' == $sort[0]):?>
    <?php echo link_to(__('Priority', array(), 'messages'), '@'.$helper->getIndexRoute(), array('query_string' => 'sort=pri&sort_type='.($sort[1] == 'asc' ? 'desc' : 'asc'))) ?>
    <?php echo image_tag(sfConfig::get('sf_admin_module_web_dir').'/images/'.$sort[1].'.png', array('alt' => __($sort[1], array(), 'sf_admin'), 'title' => __($sort[1], array(), 'sf_admin'))) ?>
  <?php else: ?>
    <?php echo link_to(__('Priority', array(), 'messages'), '@'.$helper->getIndexRoute(), array('query_string' => 'sort=pri&sort_type=asc')) ?>
	<?php endif;?>
  
</th>
<?php end_slot(); ?>




<?php include_slot('sf_admin.current_header') ?><?php slot('sf_admin.current_header') ?>
<th class="sf_admin_text sf_admin_list_th_price">
  <?php if ('price' == $sort[0]): ?>
    <?php echo link_to(__('Price', array(), 'messages'), '@'.$helper->getIndexRoute(), array('query_string' => 'sort=price&sort_type='.($sort[1] == 'asc' ? 'desc' : 'asc'))) ?>
    <?php echo image_tag(sfConfig::get('sf_admin_module_web_dir').'/images/'.$sort[1].'.png', array('alt' => __($sort[1], array(), 'sf_admin'), 'title' => __($sort[1], array(), 'sf_admin'))) ?>
  <?php else: ?>
    <?php echo link_to(__('Price', array(), 'messages'), '@'.$helper->getIndexRoute(), array('query_string' => 'sort=price&sort_type=asc')) ?>
  <?php endif; ?>
</th>
<?php end_slot(); ?>
<?php include_slot('sf_admin.current_header') ?>


<?php slot('sf_admin.current_header') ?>
<th class="sf_admin_text sf_admin_list_th_productGroupsForList">
  <?php echo __('Groups', array(), 'messages') ?>
</th>
<?php end_slot(); ?>
<?php include_slot('sf_admin.current_header') ?>
