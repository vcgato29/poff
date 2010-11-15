<?php use_helper('I18N', 'Date') ?>
<?php include_partial('product/assets') ?>


<?php include_component( 'productManagement', 'popuptabs' )?>



<div id="sf_admin_container">

  <?php include_partial('product/flashes') ?>

  <div id="sf_admin_header">
    <?php include_partial('product/form_header', array('product' => $product, 'form' => $form, 'configuration' => $configuration)) ?>
  </div>

  <div id="sf_admin_content">
    <?php include_partial('product/form', array('product' => $product, 'form' => $form, 'configuration' => $configuration, 'helper' => $helper)) ?>
  </div>

  <div id="sf_admin_footer">
    <?php include_partial('product/form_footer', array('product' => $product, 'form' => $form, 'configuration' => $configuration)) ?>
  </div>
</div>
