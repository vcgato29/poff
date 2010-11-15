<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>


  <?php echo form_tag_for($form, '@news_group') ?>
    <?php echo $form->renderHiddenFields(false) ?>
    
    <?php if ($form->hasGlobalErrors()): ?>
      <?php echo $form->renderGlobalErrors() ?>
    <?php endif; ?>
    <fieldset>
    <legend class="formLabel"><?php echo __( 'Newsgroup' )?></legend>
	    <table>
	    	<tfoot>
	    		<tr>
	    			<td>
	    				<input type="submit" name="<?php echo __('Save')?>" value="Salvesta" class="formInput" />
	    			</td>
	    		</tr>
	    	</tfoot>
	    	<tbody>
		    	<tr>
		    		<td><?php echo $form['name']->renderLabel('', array( 'class' => 'formLabel' ))?></td>
		    		<td><?php echo $form['name']->render( array( 'class' => 'formInput', 'size' => 55 ) )?></td>
		    		<td><?php echo $form['name']->renderError() ?></td>
		    	</tr>
		    	<tr>
		    		<td><?php echo $form['type']->renderLabel('', array( 'class' => 'formLabel' ))?></td>
		    		<td><?php echo $form['type']->render( array( 'class' => 'formInput' ) )?></td>
		    		<td><?php echo $form['type']->renderError() ?></td>
		    	</tr>
		    	<tr>
		    		<td><?php echo $form['is_active']->renderLabel('', array( 'class' => 'formLabel' ))?></td>
		    		<td><?php echo $form['is_active']->render( array( 'class' => 'formInput' ) )?></td>
		    		<td><?php echo $form['is_active']->renderError() ?></td>
		    	</tr>
		    	<tr>
		    		<td><?php echo $form['link_to_struct']->renderLabel('', array( 'class' => 'formLabel' ))?></td>
		    		<td><?php echo $form['link_to_struct']->render( array( 'class' => 'formInput' ) )?></td>
		    		<td><?php echo $form['link_to_struct']->renderError() ?></td>
		    	</tr>
		    	<tr>
		    		<td><?php echo $form['connections']->renderLabel('', array( 'class' => 'formLabel' ))?></td>
		    		<td><?php echo $form['connections']->render( array( 'class' => 'formInput' ) )?></td>
		    		<td><?php echo $form['connections']->renderError() ?></td>
		    	</tr>
	    	</tbody>
	    
	    </table>
    </fieldset>

  </form>

