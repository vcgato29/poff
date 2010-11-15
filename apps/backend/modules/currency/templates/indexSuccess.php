<?php use_helper('I18N', 'Date') ?>
<?php include_partial('currency/assets') ?>

<div id="sf_admin_container">
  <h1><?php echo __('Currency List', array(), 'messages') ?></h1>

    <form action="<?php echo url_for('currency_collection', array('action' => 'batch')) ?>" method="post">
    <ul class="sf_admin_actions">
      <?php include_partial('currency/list_actions', array('helper' => $helper)) ?>
      <?php include_partial('currency/list_batch_actions', array('helper' => $helper)) ?>
    </ul>

  <?php include_partial('currency/flashes') ?>

  <div id="sf_admin_header">
    <?php include_partial('currency/list_header', array('pager' => $pager)) ?>
  </div>

  <div id="sf_admin_bar">
    <?php include_partial('currency/filters', array('form' => $filters, 'configuration' => $configuration)) ?>
  </div>

  <div id="sf_admin_content">
    
    <?php include_partial('currency/list', array('pager' => $pager, 'sort' => $sort, 'helper' => $helper)) ?>

    
  </div>
  </form>

  <div id="sf_admin_footer">
    <?php include_partial('currency/list_footer', array('pager' => $pager)) ?>
  </div>
</div>
