<div class="soov">
	<p><?php echo __('Soovin, et minuga võetaks ühendust') ?>:</p>
	<div class="radiobuttonsf">

		<?php include_partial('global/radiobutton', array(
			'field' => $form['ühenduse meetod'],
			'active' => $form['ühenduse meetod']->getValue() == 'phone',
			'defaultValue' => 'phone'
			))
		?>


		<div class="rbtext"><b> <?php echo  __('Telefoni teel') ?></b></div>
	</div>
	<div class="clear"></div>
	<div class="radiobuttonsf">

		<?php include_partial('global/radiobutton', array(
			'field' => $form['ühenduse meetod'],
			'active' => $form['ühenduse meetod']->getValue() == 'email',
			'defaultValue' => 'email'
			))
		?>

		<div class="rbtext"><b><?php echo  __('Emailitsi') ?></b></div>
	</div>
</div>
<div class="clear"></div>