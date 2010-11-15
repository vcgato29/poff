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
				<td colspan="5">
					<input style="float:left" type="submit" name="Salvesta" value="<?php echo __('Save') ?>"  class="formInput" />
				</td>
			</tr>
		</tfoot>
	
		<tr>
			<td>
				<?php echo $form['name']->renderLabel('', array( 'class' => 'formLabel' )) ?>	
			</td>
			<td>
				<?php echo $form['name']->render( array( 'class'=>'formInput' ) ) ?>
			</td>
			<td><?php echo $form['name']->renderError() ?></td>
		</tr>
		<tr>
			<td>
				<?php echo $form['content']->renderLabel('Description', array( 'class' => 'formLabel' )) ?>	
			</td>
			<td>
				<?php echo $form['content']->render( array( 'class'=>'formInput' ) ) ?>
			</td>
			<td><?php echo $form['content']->renderError() ?></td>
		</tr>
		<?php if( $form->isNew() ):?>
		<tr>
			<td>
				<?php echo $form['type']->renderLabel('', array( 'class' => 'formLabel' )) ?>	
			</td>
			<td>
				<?php echo $form['type']->render( array( 'class'=>'formInput' ) ) ?>
			</td>
			<td><?php echo $form['type']->renderError() ?></td>
		</tr>
		<?php endif;?>
		<tr>
			<td>
				<?php echo $form['banner_group_id']->renderLabel('', array( 'class' => 'formLabel' )) ?>
			</td>
			<td>
				<?php echo $form['banner_group_id']->render( array( 'class'=>'formInput' ) ) ?>
			</td>
			<td><?php echo $form['banner_group_id']->renderError() ?></td>
		
		</tr>
		<tr>
			<td>
				<?php echo $form['link']->renderLabel('', array( 'class' => 'formLabel' )) ?>
			</td>
			
			<td>
				<?php echo $form['link']->render( array( 'class'=>'formInput' ) ) ?>
			</td>
			<td><?php echo $form['link']->renderError() ?></td>
		</tr>
		<tr>
			<td>
				<?php echo $form['width']->renderLabel('', array( 'class' => 'formLabel' )) ?>
			</td>
			
			<td>
				<?php echo $form['width']->render( array( 'class'=>'formInput' ) ) ?>
			</td>
			<td><?php echo $form['width']->renderError() ?></td>
		</tr>
		<tr>
			<td>
				<?php echo $form['height']->renderLabel('', array( 'class' => 'formLabel' )) ?>
			</td>
			
			<td>
				<?php echo $form['height']->render( array( 'class'=>'formInput' ) ) ?>
			</td>
			<td><?php echo $form['height']->renderError() ?></td>
		</tr>
		<tr>
			<td>
				<?php echo $form['file']->renderLabel('', array( 'class' => 'formLabel' )) ?>
			</td>
			<td>
				<?php echo $form['file']->render( array( 'class'=>'formInput' ) ) ?>
			</td>
			<td><?php echo $form['file']->renderError() ?></td>
		</tr>
		

	
	</table>

  </form>

