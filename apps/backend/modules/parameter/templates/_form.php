<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>




<div class="sf_admin_form">
  <?php echo form_tag_for($form, '@parameter') ?>
    <?php echo $form->renderHiddenFields(false) ?>

    <?php if ($form->hasGlobalErrors()): ?>
      <?php echo $form->renderGlobalErrors() ?>
    <?php endif; ?>

	<table>

		<tr>
			<td> <?php echo $form['title']->renderLabel( 'Name', array( 'class' => 'formLabel' ) )?> </td>
			<td><?php echo $form['title']->render(array( 'class' => 'formInput' ))?></td>
			<td><?php echo $form['title']->renderError()?></td>
		</tr>
			
			<?php foreach( $form->languages as $lang ):?>
					<?php echo $form[$lang['abr']]->renderHiddenFields(true) ?>			
			<?php endforeach;?>
			
		<?php foreach( $form->multiLangFields as $field ):?>
			<?php foreach( $form->languages as $lang ):?>
			<tr>
				<td>
					<?php echo $form[$lang['abr']][$field]->renderLabel( $field . ' ' . $lang['abr'], array( 'class' => 'formLabel' ))?>
				</td>
				<td>
					<?php echo $form[$lang['abr']][$field]->render(array( 'class' => 'formInput' ))?>
				</td>
			</tr>
			<?php endforeach;?>
		<?php endforeach;?>
		<tr>
			<td> <?php echo $form['type']->renderLabel('Type', array( 'class' => 'formLabel' ))?> </td>
			<td><?php echo $form['type']->render(array( 'class' => 'formInput' ))?></td>
		</tr>
		<tr>
			<td> <?php echo $form['group_id']->renderLabel( 'Group', array( 'class' => 'formLabel' ) )?> </td>
			<td><?php echo $form['group_id']->render(array( 'class' => 'formInput' ))?></td>
		</tr>
		<tr>
			<td colspan="2"> <?php echo $form['multilang']->renderLabel('Translatable ?', array( 'class' => 'formLabel' ))?> <?php echo $form['multilang']?></td>
			
		</tr>
		
	</table>
	

    <?php if( !$form->isNew() && $form->getSubTemplate() ):?>
    	<br />
    	<?php include_partial( $form->getSubTemplate(), array( 'form' => $form ) )?>
    <?php endif;?>
    

    <table>
		<tfoot>
			<tr>
				<td colspan="2">
					<input style="float:left;" class="formInput" type="submit" name="Salvesta" value="<?php echo __('Save')?>" />
				</td>
			</tr>
		</tfoot>
    </table>
    
  </form>
</div>
