<?php use_helper('I18N', 'Date') ?>
<?php include_partial('product/assets') ?>


<div id="sf_admin_container">

  
  <h1><?php echo __('Product List', array(), 'messages') ?></h1>
  
  <div id="sf_admin_bar" style="float:none;width:250px;margin-left:0px;">
    <?php include_partial('product/filters', array('form' => $filters, 'configuration' => $configuration,'helper' => $helper)) ?>
  </div>

<form action="<?php echo url_for($helper->getIndexRoute().'_collection', array('action' => 'batch')) ?>" method="post">
    <ul class="sf_admin_actions">
	<?php include_partial('product/list_actions', array('helper' => $helper)) ?>
      <?php include_partial('product/list_batch_actions', array('helper' => $helper)) ?>
    </ul>
  <?php include_partial('product/flashes') ?>


  <div id="sf_admin_header">
    <?php include_partial('product/list_header', array('pager' => $pager)) ?>
  </div>



  <div id="sf_admin_content">
    <?php include_partial('product/list', array('pager' => $pager, 'sort' => $sort, 'helper' => $helper)) ?>
	<div style="cursor:pointer;padding-bottom:20px;" id="save_priority"><?php echo __('Save priority')?></div>
   	<script type="text/javascript">
   		$('#save_priority').click(function(){
   	   		var form = $(this).parents('form'); 
   			form.find('[name=batch_action]').val('batchPriority');
   			form.submit();
   	   	});
   	</script>
  </div>
  </form>

  <div id="sf_admin_footer">
    <?php include_partial('product/list_footer', array('pager' => $pager)) ?>
  </div>
</div>
