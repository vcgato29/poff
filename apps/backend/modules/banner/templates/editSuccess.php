<?php use_helper('I18N', 'Date') ?>
<?php include_partial('banner/assets') ?>

<div id="sf_admin_container">
  <h1><?php echo __('Edit Banner', array(), 'messages') ?></h1>

  <?php include_partial('banner/flashes') ?>

  <div id="sf_admin_header">
    <?php include_partial('banner/form_header', array('banner' => $banner, 'form' => $form, 'configuration' => $configuration)) ?>
  </div>

  <div id="sf_admin_content">
    <?php include_partial('banner/' . $form->getRenderTemplate(), array('banner' => $banner, 'form' => $form, 'configuration' => $configuration, 'helper' => $helper)) ?>
  </div>

  <div id="sf_admin_footer">
    <?php include_partial('banner/form_footer', array('banner' => $banner, 'form' => $form, 'configuration' => $configuration)) ?>
  </div>
</div>
