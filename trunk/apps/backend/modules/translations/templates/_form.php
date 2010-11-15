<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<div class="sf_admin_form">
  <?php echo form_tag_for($form, '@trans_unit') ?>
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
      <div class="content"><?php echo $form['source']->render($params)?></div>
	</div>
</div>

<?php if(!$form->isNew()):?>
		<?php foreach($form->getLangs() as $lang):?>
			<div class="sf_admin_form_row sf_admin_text sf_admin_form_field_variable">
				<div>
			      <label for="trans_unit_variable_variable"> <?php echo __('Value')?> (<?php echo $lang?>)</label>
			      <div class="content"><?php echo $form[$form->getEmbedFieldName($form->getObject()->getSource(),$lang)]['target']->render()?></div>
				</div>
			</div>
		<?php endforeach;?>		
<?php endif;?>

</fieldset>
    <?php include_partial('translations/form_actions', array('trans_unit' => $trans_unit, 'form' => $form, 'configuration' => $configuration, 'helper' => $helper)) ?>
    
  </form>
</div>
