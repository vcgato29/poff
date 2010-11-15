<?php use_helper('I18N', 'Date') ?>
<?php include_partial('product_exemplar/assets') ?>

<div id="sf_admin_container">
  <h1><?php echo __('Product exemplar List', array(), 'messages') ?></h1>

   <div id="sf_admin_bar"  style="float:none;width:250px;margin-left:0px;">
    <?php include_partial('product_exemplar/filters', array('form' => $filters, 'configuration' => $configuration)) ?>
  </div>

  <form action="<?php echo url_for('product_exemplar_collection', array('action' => 'batch')) ?>" method="post">
    <ul class="sf_admin_actions">
      <?php include_partial('product_exemplar/list_batch_actions', array('helper' => $helper)) ?>
      <?php include_partial('product_exemplar/list_actions', array('helper' => $helper)) ?>
    </ul>

  <?php include_partial('product_exemplar/flashes') ?>

  <div id="sf_admin_header">
    <?php include_partial('product_exemplar/list_header', array('pager' => $pager)) ?>
  </div>



  <div id="sf_admin_content">
    <?php include_partial('product_exemplar/list', array('pager' => $pager, 'sort' => $sort, 'helper' => $helper)) ?>

    
  </div>
</form>

  <div id="sf_admin_footer">
    <?php include_partial('product_exemplar/list_footer', array('pager' => $pager)) ?>
  </div>
</div>
