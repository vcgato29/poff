<?php use_helper('I18N', 'Date') ?>
<?php include_partial('new_item/assets') ?>

<div id="sf_admin_container">
<div style="width:100px;float:right;position:relative;padding-top:-100px">
	<?php include_partial('new_item/filters', array('form' => $filters, 'configuration' => $configuration)) ?>
	
</div>
  <h1>
  	<?php echo __('New item List', array(), 'messages') ?>
  	
  </h1>

  <?php include_partial('new_item/flashes') ?>

  <div id="sf_admin_content">
    <form action="<?php echo url_for('new_item_collection', array('action' => 'batch')) ?>" method="post">
    <?php include_partial('new_item/list', array('pager' => $pager, 'sort' => $sort, 'helper' => $helper)) ?>
    <ul class="sf_admin_actions" style="float:right">
    <?php include_partial('new_item/list_actions', array('helper' => $helper)) ?>
    <?php include_partial('new_item/list_batch_actions', array('helper' => $helper)) ?>
      
    </ul>
    </form>
  </div>

  <div id="sf_admin_footer">
    <?php include_partial('new_item/list_footer', array('pager' => $pager)) ?>
  </div>
</div>
