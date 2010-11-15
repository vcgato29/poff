<?php use_helper('I18N', 'Date') ?>
<?php include_partial('translations/assets') ?>

<div id="sf_admin_container">
  <h1><?php echo __('Edit Translations', array(), 'messages') ?></h1>

  <?php include_partial('translations/flashes') ?>

  <div id="sf_admin_header">
    <?php include_partial('translations/form_header', array('trans_unit' => $trans_unit, 'form' => $form, 'configuration' => $configuration)) ?>
  </div>

  <div id="sf_admin_content">
    <?php include_partial('translations/form', array('trans_unit' => $trans_unit, 'form' => $form, 'configuration' => $configuration, 'helper' => $helper)) ?>
  </div>

  <div id="sf_admin_footer">
    <?php include_partial('translations/form_footer', array('trans_unit' => $trans_unit, 'form' => $form, 'configuration' => $configuration)) ?>
  </div>
</div>
