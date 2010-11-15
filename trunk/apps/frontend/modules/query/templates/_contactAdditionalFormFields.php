<?php include_partial('query/contactMethod', array('form' => $form)) ?>

<div class="soov">
	<p><?php echo __('Soovin PDF koopia emailile') ?>:</p>
	<div class="radiobuttonsf">

		<?php include_partial('global/radiobutton', array(
			'field' => $form['send_copy'],
			'active' => $form['send_copy']->getValue() == '1',
			'defaultValue' => '1'
			))
		?>

		<div class="rbtext"><b><?php echo __('Jah') ?></b></div>
	</div>
	<div class="clear"></div>
	<div class="radiobuttonsf">

		<?php include_partial('global/radiobutton', array(
			'field' => $form['send_copy'],
			'active' => $form['send_copy']->getValue() == '0',
			'defaultValue' => '0'
			))
		?>

		<div class="rbtext"><b><?php echo  __('Ei') ?></b></div>
	</div>
</div>
<div class="clear"></div>
<div class="blackbuttonbox" id="attachpicturesbutton">
	<div class="blackbutton">
		<div class="blackbuttontext"><a href="#"><?php echo __('Lisa pildid ') ?>(<span id="attachments"><?php echo count($attachments) ?></span> <?php echo __('lisatud') ?>)</a></div>
	</div>
</div>
<div class="clear"></div>


<script type="text/javascript">
// attach pictures iframe
$("#attachpicturesbutton").fancybox({
		'autoScale'     	: false,
		'transitionIn'		: 'none',
	'transitionOut'		: 'fade',
	'type'			: 'iframe',
	'width'			: '50%',
	'height'		: '50%',
	'href'			: '<?php echo $helper->link('attachPictures') ?>'
});
</script>
