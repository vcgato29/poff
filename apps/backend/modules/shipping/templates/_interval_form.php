<?php 
$params = $form->isNew() ? array( 'action' => 'createInterval', 'module' => 'shipping' ) : array( 'action' => 'updateInterval', 'module' => 'shipping', 'intervalID' => $form->getObject()->getId() )
?>

<?php include_partial('shipping/flashes')?>

<form action="<?php echo url_for('admin_page', $params ) ?>" method="post">
<?php echo $form->renderHiddenFields()?>
	<table>
		<tr>
			<td><?php echo $form['start']->renderLabel()?></td>
			<td><?php echo $form['start']->render()?></td>
		</tr>
		<tr>
			<td><?php echo $form['end']->renderLabel()?></td>
			<td><?php echo $form['end']->render()?></td>
		</tr>
		<tr>
			<td><?php echo $form['price']->renderLabel()?></td>
			<td><?php echo $form['price']->render()?></td>
		</tr>
		<tr>
			<td colspan="3"><input type="submit" name="submit" value="submit" /></td>
		</tr>
	</table>
</form>