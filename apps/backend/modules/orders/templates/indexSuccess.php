<?php use_helper('I18N', 'Date') ?>
<?php include_partial('orders/assets') ?>

  
<div id="sf_admin_container">
  <h1><?php echo __('Orders List', array(), 'messages') ?></h1>

  <div id="sf_admin_bar" style="float:none;width:250px;margin-left:0px;">
    <?php include_partial('orders/filters', array('form' => $filters, 'configuration' => $configuration)) ?>
  </div>

    <form action="<?php echo url_for('product_order_collection', array('action' => 'batch')) ?>" method="post">
    <ul class="sf_admin_actions">
      <?php include_partial('orders/list_batch_actions', array('helper' => $helper)) ?>
    </ul>
  <?php include_partial('orders/flashes') ?>


  <div id="sf_admin_header">

    <?php include_partial('orders/list_header', array('pager' => $pager)) ?>
    

    
  </div>



  <div id="sf_admin_content">
    
    <?php include_partial('orders/list', array('pager' => $pager, 'sort' => $sort, 'helper' => $helper)) ?>
    
  </div>
  </form>

  <div id="sf_admin_footer">
    <?php include_partial('orders/list_footer', array('pager' => $pager)) ?>
  </div>
</div>
