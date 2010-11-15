<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

  <?php echo form_tag_for($form, '@banner') ?>
    <?php echo $form->renderHiddenFields(false) ?>

    <?php if ($form->hasGlobalErrors()): ?>
      <?php echo $form->renderGlobalErrors() ?>
    <?php endif; ?>


	<table>
		<tfoot>
			<tr>
				<td>
					<input type="submit" name="Salvesta" value="<?php echo __('Save')?>"  class="formInput" />
				</td>
			</tr>
		</tfoot>
	
		<tr>
			<td>
				<?php echo $form['name']->renderError() ?>
				<?php echo $form['name']->renderLabel('', array( 'class' => 'formLabel' )) ?>	
			</td>
			<td>
				<?php echo $form['name']->render( array( 'class'=>'formInput' ) ) ?>
			</td>
		</tr>
		<tr>
			<td>
				<?php echo $form['banner_group_id']->renderError() ?>
				<?php echo $form['banner_group_id']->renderLabel('', array( 'class' => 'formLabel' )) ?>
			</td>
			<td>
				<?php echo $form['banner_group_id']->render( array( 'class'=>'formInput' ) ) ?>
			</td>
		
		</tr>

		<tr>
			<td>
				<?php echo $form['width']->renderError() ?>
				<?php echo $form['width']->renderLabel('', array( 'class' => 'formLabel' )) ?>
			</td>
			
			<td>
				<?php echo $form['width']->render( array( 'class'=>'formInput' ) ) ?>
			</td>
		</tr>
		<tr>
			<td>
				<?php echo $form['height']->renderError() ?>
				<?php echo $form['height']->renderLabel('', array( 'class' => 'formLabel' )) ?>
			</td>
			
			<td>
				<?php echo $form['height']->render( array( 'class'=>'formInput' ) ) ?>
			</td>
		</tr>		
		<tr>
			<td>
				<?php echo $form['content']->renderError() ?>
				<?php echo $form['content']->renderLabel('', array( 'class' => 'formLabel' )) ?>
			</td>
			<td>
				<?php echo $form['content']->render( array( 'class'=>'formInput' ) ) ?>
			</td>
		</tr>
		<tr>
			<td colspan="2">		      	
				<?php if( !$form->isNew() ):?>
		      		<?php echo $form->getObject()->renderForEditForm()?>
		      	<?php endif;?>
		    </td>
		</tr>
		

	
	</table>

  </form>

