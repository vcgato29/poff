<?php echo $form->renderHiddenFields(true) ?>
<div class="formsbox">
	<div class="formname"><?php echo __('Nimi') ?>:</div>
	<div class="forminputp">
		<?php echo $form['nimi']->render(array('class' => 'registerforms'))?>
	</div>
	<div class="clear"></div>
</div>
<div class="formsbox">
	<div class="formname"><b><?php echo __('E-mail') ?>:</b></div>
	<div class="forminputp">
		<?php echo $form['email']->render(array('class' => 'registerforms'))?>
	</div>
	<div class="clear"></div>
</div>

<div class="formsbox">
	<div class="formname"><?php echo  __('Aadress') ?>:</div>
	<div class="forminputp">
		<?php echo $form['aadress']->render(array('class' => 'registerforms'))?>
	</div>
	<div class="clear"></div>
</div>
<div class="formsbox">
	<div class="formname"><?php echo __('Indeks') ?>:</div>
	<div class="forminputp">
		<?php echo $form['indeks']->render(array('class' => 'registerforms'))?>
	</div>
	<div class="clear"></div>
</div>
<div class="formsbox">
	<div class="formname"><?php echo __('Maakond') ?>:</div>
	<div class="forminputp">
		<?php echo $form['maakond']->render(array('class' => 'registerforms'))?>
	</div>
	<div class="clear"></div>
</div>
<div class="formsbox">
	<div class="formname"><?php echo __('Telefon') ?>:</div>
	<div class="forminputp">
		<?php echo $form['telefon']->render(array('class' => 'registerforms'))?>
	</div>
	<div class="clear"></div>
</div>
<div class="formsbox">
	<div class="formname"><?php echo  __('Lisainfo') ?>:</div>
	<div class="formtext">
		<?php echo $form['lisainfo']->render(array('class' => 'formarea',
			'rows' => 4, 'cols' => 20)) ?>
	</div>
	<div class="clear"></div>
</div>

