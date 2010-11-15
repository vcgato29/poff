<?php use_helper('I18N', 'Date') ?>
<?php include_partial('translations/assets') ?>

<div id="sf_admin_container">
  <h1><?php echo __('Translations List', array(), 'messages') ?></h1>

  <div id="sf_admin_bar" style="float:none;width:550px;margin-left:0px;">
    <div style="float:left;margin-right:10px;"><?php include_partial('translations/filters', array('form' => $filters, 'configuration' => $configuration)) ?></div>
    <div class="clear"></div>
  </div>

<form action="<?php echo url_for('trans_unit_collection', array('action' => 'batch')) ?>" method="post">
<?php echo $quickForm->renderHiddenFields(true)?>
    <ul class="sf_admin_actions">
    <?php include_partial('translations/list_actions', array('helper' => $helper)) ?>
      <?php include_partial('translations/list_batch_actions', array('helper' => $helper)) ?>
    </ul>
    
  <?php include_partial('translations/flashes') ?>

<div><?php include_partial('translations/languages_selection', array('activeLangs' => $activeLangs,'langs' => $langs)) ?></div>
  <div id="sf_admin_header">
    <?php include_partial('translations/list_header', array('pager' => $pager)) ?>
  </div>



  <div id="sf_admin_content">
    <?php include_partial('translations/list', array('pager' => $pager, 'sort' => $sort, 'helper' => $helper, 'quickForm' => $quickForm, 'langs' =>$langs, 'activeLangs' => $activeLangs)) ?>
    
	<div style="cursor:pointer;padding-bottom:20px;" id="save_priority"><?php echo __('Save Translations')?></div>
   	<script type="text/javascript">
   		$('#save_priority').click(function(){
   	   		var form = $(this).parents('form'); 
   			form.find('[name=batch_action]').val('batchSave');
   			form.submit();
   	   	});
   	</script>
  </div>
  </form>

  <div id="sf_admin_footer">
    <?php include_partial('translations/list_footer', array('pager' => $pager)) ?>
  </div>
</div>
