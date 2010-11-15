<?php use_helper('I18N', 'Date') ?>
<?php include_partial('sfGuardUser/assets') ?>

<div id="sf_admin_container">
  <h1><?php echo __('User list', array(), 'messages') ?></h1>

    <ul class="sf_admin_actions">
    <?php include_partial('sfGuardUser/list_actions', array('helper' => $helper)) ?>
      <?php include_partial('sfGuardUser/list_batch_actions', array('helper' => $helper)) ?>
    </ul>
  <?php include_partial('sfGuardUser/flashes') ?>


  <div id="sf_admin_content">
    <form action="<?php echo url_for('sf_guard_user_collection', array('action' => 'batch')) ?>" method="post">
    <?php include_partial('sfGuardUser/list', array('pager' => $pager, 'sort' => $sort, 'helper' => $helper)) ?>

    </form>
  </div>


</div>
