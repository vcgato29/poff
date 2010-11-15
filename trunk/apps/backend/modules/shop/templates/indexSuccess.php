<?php use_helper('I18N', 'Date') ?>
<?php include_partial('shop/assets') ?>

<div id="sf_admin_container">
  <h1><?php echo __('Shop List', array(), 'messages') ?></h1>

    <form action="<?php echo url_for('shop_collection', array('action' => 'batch')) ?>" method="post">
    <ul class="sf_admin_actions">
      <?php include_partial('shop/list_actions', array('helper' => $helper)) ?>
      <?php include_partial('shop/list_batch_actions', array('helper' => $helper)) ?>
    </ul>
  <?php include_partial('shop/flashes') ?>

  <div id="sf_admin_header">
    <?php include_partial('shop/list_header', array('pager' => $pager)) ?>
  </div>

  <div id="sf_admin_bar">
    <?php include_partial('shop/filters', array('form' => $filters, 'configuration' => $configuration)) ?>
  </div>

  <div id="sf_admin_content">
    <?php include_partial('shop/list', array('pager' => $pager, 'sort' => $sort, 'helper' => $helper)) ?>
    
  </div>
  </form>

  <div id="sf_admin_footer">
    <?php include_partial('shop/list_footer', array('pager' => $pager)) ?>
  </div>
</div>
