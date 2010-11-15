<?php use_helper('I18N', 'Date') ?>
<?php include_partial('news_group/assets') ?>

<div id="sf_admin_container">
<div style="width:100px;float:right;position:relative;padding-top:-100px">
	<?php include_partial('news_group/filters', array('form' => $filters, 'configuration' => $configuration)) ?>
	
</div>
  <h1><?php echo __('News group List', array(), 'messages') ?>

  </h1>

  <?php include_partial('news_group/flashes') ?>

  <div id="sf_admin_header">
    <?php include_partial('news_group/list_header', array('pager' => $pager)) ?>
  </div>



  <div id="sf_admin_content">
    <form action="<?php echo url_for('news_group_collection', array('action' => 'batch')) ?>" method="post">
    <?php include_partial('news_group/list', array('pager' => $pager, 'sort' => $sort, 'helper' => $helper)) ?>
    <ul class="sf_admin_actions" style="float:right">
      <?php include_partial('news_group/list_actions', array('helper' => $helper)) ?>
      <?php include_partial('news_group/list_batch_actions', array('helper' => $helper)) ?>
    </ul>
    </form>
  </div>

  <div id="sf_admin_footer">
    <?php include_partial('news_group/list_footer', array('pager' => $pager)) ?>
  </div>
</div>
