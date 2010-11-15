
<?php echo $form['new_option']->renderHiddenFields(false)?>
<table>

	<?php foreach( $form->getObject()->getParameterOptions() as $option ):?>
		<tr>
			<td>
				<?php echo $form['option_' . $option->getId()]['title']->render(array( 'class' => 'formInput' ))?>
				<a  href="<?php echo url_for('@admin_page?module=parameter&action=deleteOption&id=' . $option['id'])?>"><img  border="0" width="10px" alt="" src="/img/admin/delete.png"></a>
				<?php echo $form['option_' . $option->getId()]->renderHiddenFields(true)?>
			</td>
		</tr>
	<?php endforeach;?>
	<tr>
		<td>
	<?php echo $form['new_option']['title']->renderLabel('New option:', array( 'class' => 'formLabel' ))?>			<?php echo $form['new_option']['title']->render(array( 'class' => 'formInput' ))?>
		</td>
	</tr>
</table>
