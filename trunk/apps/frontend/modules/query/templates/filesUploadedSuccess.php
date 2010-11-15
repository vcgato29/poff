<?php echo __('%1 faili on üles laetud', array('%1' => count($files))) ?>

<input type="button" name="" onclick="parent.$.fancybox.close();return false;" value="<?php echo __('Pane aken kinni') ?>" />

<script type="text/javascript">
    parent.$('#attachments').html(<?php echo count($files) ?>);
</script>