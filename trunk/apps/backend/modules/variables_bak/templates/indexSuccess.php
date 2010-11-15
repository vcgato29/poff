<?php use_helper('I18N', 'Date') ?>
<?php include_partial('variables/assets') ?>

<div id="sf_admin_container">
  <h1><?php echo __('Variables List', array(), 'messages') ?></h1>

  <div id="sf_admin_bar" style="float:none;width:250px;margin-left:0px;">
    <?php include_partial('variables/filters', array('form' => $filters, 'configuration' => $configuration)) ?>
  </div>
  <?php include_partial('variables/flashes') ?>

  <div id="sf_admin_header">
    <?php include_partial('variables/list_header', array('pager' => $pager)) ?>
  </div>



  <div id="sf_admin_content">
    <form action="<?php echo url_for('trans_unit_collection', array('action' => 'batch')) ?>" method="post">
    <?php include_partial('variables/list', array('pager' => $pager, 'sort' => $sort, 'helper' => $helper)) ?>
    <ul class="sf_admin_actions">
      <?php include_partial('variables/list_batch_actions', array('helper' => $helper)) ?>
      <?php include_partial('variables/list_actions', array('helper' => $helper)) ?>
    </ul>
    </form>
  </div>

  <div id="sf_admin_footer">
    <?php include_partial('variables/list_footer', array('pager' => $pager)) ?>
  </div>
</div>
