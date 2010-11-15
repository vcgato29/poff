<div id="footer">
  <div>
    <!-- footer content -->
    <?php $form = new sfFormLanguage(
      $sf_user,
      array('languages' => $abr )
      )
    ?>
    <form action="<?php echo url_for('@structure_page?module=structure&action=changeLanguage') ?>">
      <?php echo $form ?>
      <input type="submit" value="ok" />
    </form>
  </div>
</div>