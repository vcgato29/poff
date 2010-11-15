<?php use_helper('I18N', 'Date') ?>
<?php include_partial('structure/assets') ?>

<div id="sf_admin_container">
  <h1><?php echo __('New Structure', array(), 'messages') ?></h1>

  <?php include_partial('structure/flashes') ?>

  <div id="sf_admin_header">
    <?php include_partial('structure/form_header', array('structure' => $structure, 'form' => $form, 'configuration' => $configuration)) ?>
  </div>

  <div id="sf_admin_content">
    <?php include_partial('structure/form', array('structure' => $structure, 'form' => $form, 'configuration' => $configuration, 'helper' => $helper)) ?>
  </div>

  <div id="sf_admin_footer">
    <?php include_partial('structure/form_footer', array('structure' => $structure, 'form' => $form, 'configuration' => $configuration)) ?>
  </div>
</div>
