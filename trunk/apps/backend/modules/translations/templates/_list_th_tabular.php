<?php slot('sf_admin.current_header') ?>
<th class="sf_admin_text sf_admin_list_th_source">
  <?php if ('source' == $sort[0]): ?>
    <?php echo link_to(__('Source', array(), 'messages'), '@trans_unit', array('query_string' => 'sort=source&sort_type='.($sort[1] == 'asc' ? 'desc' : 'asc'))) ?>
    <?php echo image_tag(sfConfig::get('sf_admin_module_web_dir').'/images/'.$sort[1].'.png', array('alt' => __($sort[1], array(), 'sf_admin'), 'title' => __($sort[1], array(), 'sf_admin'))) ?>
  <?php else: ?>
    <?php echo link_to(__('Source', array(), 'messages'), '@trans_unit', array('query_string' => 'sort=source&sort_type=asc')) ?>
  <?php endif; ?>
</th>

<?php foreach($activeLangs as $lang):?>
<th><?php echo __('Value')?> (<?php echo $lang?>)</th>
<?php endforeach;?>

<?php end_slot(); ?>
<?php include_slot('sf_admin.current_header') ?>