<?php use_helper('I18N', 'Date') ?>
<?php include_partial('parameter/assets') ?>

<div id="sf_admin_container">
  <h1><?php echo __('New Parameter', array(), 'messages') ?></h1>

  <?php include_partial('parameter/flashes') ?>

  <div id="sf_admin_header">
    <?php include_partial('parameter/form_header', array('parameter' => $parameter, 'form' => $form, 'configuration' => $configuration)) ?>
  </div>

  <div id="sf_admin_content">
    <?php include_partial('parameter/form', array('parameter' => $parameter, 'form' => $form, 'configuration' => $configuration, 'helper' => $helper)) ?>
  </div>

  <div id="sf_admin_footer">
    <?php include_partial('parameter/form_footer', array('parameter' => $parameter, 'form' => $form, 'configuration' => $configuration)) ?>
  </div>
</div>
