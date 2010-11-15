<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>



<?php echo form_tag_for($form, '@shipping_zone') ?>
<?php include_partial('shipping/form_actions', array('shipping_zone' => $shipping_zone, 'form' => $form, 'configuration' => $configuration, 'helper' => $helper)) ?>
<div class="sf_admin_form">
  
    <?php echo $form->renderHiddenFields(false) ?>

    <?php if ($form->hasGlobalErrors()): ?>
      <?php echo $form->renderGlobalErrors() ?>
    <?php endif; ?>

	<?php echo $form->renderHiddenFields()?>
	<table style="width:250px">
	<?php foreach( $form->getLanguages() as $lang ):?>
		<tr>
			<td>
			<?php echo $form[$lang]['name']->renderLabel() ?> (<?php echo $lang?>)
			</td>
			<td>
			<?php echo $form[$lang]['name']->render()?>
			</td>
		</tr>
	<?php endforeach;?>
	</table>
	

	
	<?php if( !$form->isNew() ):?>
		<?php include_partial('shipping/intervals', array('form' => $form, 'intervals' => $form->getObject()->getIntervals() ) )?>
	<?php endif;?>
	
	<br /><br /><br />

    <?php include_partial('shipping/form_actions', array('shipping_zone' => $shipping_zone, 'form' => $form, 'configuration' => $configuration, 'helper' => $helper)) ?>
    
  
</div>
</form>
