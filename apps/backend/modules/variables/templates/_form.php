<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<div class="sf_admin_form">
  <?php echo form_tag_for($form, '@trans_unit_variable') ?>
    <?php echo $form->renderHiddenFields(true) ?>

    <?php if ($form->hasGlobalErrors()): ?>
      <?php echo $form->renderGlobalErrors() ?>
    <?php endif; ?>

<fieldset id="sf_fieldset_none">
  
<div class="sf_admin_form_row sf_admin_text sf_admin_form_field_variable">
	<div>
      <label for="trans_unit_variable_variable"><?php echo __('Variable')?></label>
      <?php 
		$params = $form->isNew() ? array() :  array('readonly' => '1');      
      ?>
      <div class="content"><?php echo $form['variable']->render($params)?></div>
	</div>
</div>

<div class="sf_admin_form_row sf_admin_text sf_admin_form_field_variable">
	<div>
      <label for="trans_unit_variable_variable"><?php echo __('Multilanguage')?></label>
      <div class="content"><?php echo $form['multilang']->render()?></div>
	</div>
</div>

<?php if(!$form->isNew()):?>
	<?php if($form->getObject()->getMultilang()):?>
		<?php foreach($form->getLangs() as $lang):?>
			<div class="sf_admin_form_row sf_admin_text sf_admin_form_field_variable">
				<div>
			      <label for="trans_unit_variable_variable"> (<?php echo $lang?>)</label>
			      <div class="content"><?php echo $form[$lang]['target']->render()?></div>
				</div>
			</div>
		<?php endforeach;?>		
	<?php else:?>
<div class="sf_admin_form_row sf_admin_text sf_admin_form_field_variable">
	<div>
      <label for="trans_unit_variable_variable"><?php echo __('Value')?></label>
      <div class="content"><?php echo $form[TransUnitVariable::UNIVERSAL_LANG]['target']->render()?></div>
	</div>
</div>
	<?php endif;?>
<?php endif;?>

</fieldset>

    <?php include_partial('variables/form_actions', array('trans_unit_variable' => $trans_unit_variable, 'form' => $form, 'configuration' => $configuration, 'helper' => $helper)) ?>
  </form>
</div>
