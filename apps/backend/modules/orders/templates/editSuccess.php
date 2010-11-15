<?php use_helper('I18N', 'Date') ?>
<?php include_partial('orders/assets') ?>

<div id="sf_admin_container">
  <h1><?php echo __('Edit Order', array(), 'messages') ?> "<?php echo $product_order->order_number?>"</h1>

  <?php include_partial('orders/flashes') ?>

  <div id="sf_admin_header">
    <?php include_partial('orders/form_header', array('product_order' => $product_order, 'form' => $form, 'configuration' => $configuration)) ?>
  </div>

  <div id="sf_admin_content">
    <?php include_partial('orders/form', array('product_order' => $product_order, 'form' => $form, 'configuration' => $configuration, 'helper' => $helper)) ?>
  </div>
  
  <div>
      <?php include_partial('orders/billing', array('billing' => $product_order->BillingAddress,'product_order' => $product_order, 'form' => $form, 'configuration' => $configuration, 'helper' => $helper)) ?>
  </div>
  
  <div>
    <?php include_partial('orders/shipping', array('shipping' => $product_order->Shippings,'product_order' => $product_order, 'form' => $form, 'configuration' => $configuration, 'helper' => $helper)) ?>
  </div>

  <div id="sf_admin_footer">
    <?php include_partial('orders/form_footer', array('product_order' => $product_order, 'form' => $form, 'configuration' => $configuration)) ?>
  </div>
</div>
