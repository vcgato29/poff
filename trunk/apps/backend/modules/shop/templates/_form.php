<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>



<div class="sf_admin_form">
  <?php echo form_tag_for($form, '@shop') ?>
  <?php include_partial('shop/form_actions', array('shop' => $shop, 'form' => $form, 'configuration' => $configuration, 'helper' => $helper)) ?>
  
    <?php echo $form->renderHiddenFields(true) ?>

    <?php if ($form->hasGlobalErrors()): ?>
      <?php echo $form->renderGlobalErrors() ?>
    <?php endif; ?>

	<table style="width:250px;">
		<tr>
			<td>
				<?php echo $form['title']->renderLabel()?>
			</td>
			<td>
				<?php echo $form['title']->render()?>
			</td>
		</tr>
	</table>

	
	<?php if(!$form->isNew()):?>
		<?php include_partial('shop/address_translations', array('form' => $form))?>
	<?php endif;?>

    <?php include_partial('shop/form_actions', array('shop' => $shop, 'form' => $form, 'configuration' => $configuration, 'helper' => $helper)) ?>
  </form>
</div>
