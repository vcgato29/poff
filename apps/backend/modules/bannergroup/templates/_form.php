<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

  <?php echo form_tag_for($form, '@banner_group') ?>
    <?php echo $form->renderHiddenFields(false) ?>

    <?php if ($form->hasGlobalErrors()): ?>
      <?php echo $form->renderGlobalErrors() ?>
    <?php endif; ?>

<table>

	<tfoot align="left">
		<tr align="left">
			<td align="left" colspan="10" ><input style="float:left;" type="submit" name="Salvesta" value="<?php echo __('Save')?>" class="formInput" /></td>
		</tr>		
	</tfoot>
	<tbody>
		<tr>
			<td><?php echo $form['name']->renderLabel('', array( 'class' => 'formLabel' ))?></td>
			<td> <?php echo $form['name']->render(array( 'class' => 'formInput' ))?> </td>
			<td><?php echo $form['name']->renderError()?></td>
		</tr>
		
		<tr>
			<td><?php echo $form['type']->renderLabel('', array( 'class' => 'formLabel' ))?></td>
			<td> <?php echo $form['type']->render(array( 'class' => 'formInput' ))?> </td>
			<td><?php echo $form['type']->renderError()?></td>
		</tr>
		
		<tr>
			<td><?php echo $form['height']->renderLabel('', array( 'class' => 'formLabel' ))?></td>
			<td> <?php echo $form['height']->render(array( 'class' => 'formInput' ))?> </td>
			<td><?php echo $form['height']->renderError()?></td>
		</tr>
		<tr>
			<td><?php echo $form['width']->renderLabel('', array( 'class' => 'formLabel' ))?></td>
			<td> <?php echo $form['width']->render(array( 'class' => 'formInput' ))?> </td>
			<td><?php echo $form['width']->renderError()?></td>
		</tr>
		
		<tr>
			<td><?php echo $form['is_active']->renderLabel('', array( 'class' => 'formLabel' ))?></td>
			<td> <?php echo $form['is_active']->render(array( 'class' => 'formInput' ))?> </td>
			<td><?php echo $form['is_active']->renderError()?></td>
		</tr>
		
		<tr>
			<td><?php echo $form['banners_limit']->renderLabel('', array( 'class' => 'formLabel' ))?></td>
			<td> <?php echo $form['banners_limit']->render(array( 'class' => 'formInput' ))?> </td>
			<td><?php echo $form['banners_limit']->renderError()?></td>
		</tr>
		
		<tr>
			<td><?php echo $form['connections']->renderLabel('', array( 'class' => 'formLabel' ))?></td>
			<td> <?php echo $form['connections']->render(array( 'class' => 'formInput' ))?> </td>
			<td><?php echo $form['connections']->renderError()?></td>
		</tr>
		
		<tr>
			<td><?php echo $form['product_group_connections']->renderLabel('', array( 'class' => 'formLabel' ))?></td>
			<td> <?php echo $form['product_group_connections']->render(array( 'class' => 'formInput' ))?> </td>
			<td><?php echo $form['product_group_connections']->renderError()?></td>
		</tr>
	</tbody>
	
</table>


</form>
