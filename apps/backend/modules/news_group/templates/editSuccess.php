<?php use_helper('I18N', 'Date') ?>
<?php include_partial('news_group/assets') ?>

<div id="sf_admin_container">
  

  <?php include_partial('news_group/flashes') ?>

  <div id="sf_admin_header">
    <?php include_partial('news_group/form_header', array('news_group' => $news_group, 'form' => $form, 'configuration' => $configuration)) ?>
  </div>

  <div id="sf_admin_content">
    <?php include_partial('news_group/form', array('news_group' => $news_group, 'form' => $form, 'configuration' => $configuration, 'helper' => $helper)) ?>
  </div>

  <div id="sf_admin_footer">
    <?php include_partial('news_group/form_footer', array('news_group' => $news_group, 'form' => $form, 'configuration' => $configuration)) ?>
  </div>
</div>
