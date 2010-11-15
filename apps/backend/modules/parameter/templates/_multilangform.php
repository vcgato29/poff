
	
<?php echo $form['new_option']->renderHiddenFields(true)?>
<table>
	<tr>
		<?php foreach( $form->getLanguages() as $lang ):?>
			<td class="formLabel" align="center"> <?php echo $lang['title_est']?> </td>		
		<?php endforeach;?>
	</tr>
	
		<?php foreach( $form->getObject()->getParameterOptions() as $option ):?>
		<tr>
			<?php foreach( $form->getLanguages() as $lang ):?>
				<td>
					<?php echo $form['option_' . $option->getId()][$lang['abr']]['name']->render(array( 'class' => 'formInput' ))?>
					<?php echo $form['option_' . $option->getId()]->renderHiddenFields(true)?>
				</td>
			
		<?php endforeach;?>
		<td><a  href="<?php echo url_for('@admin_page?module=parameter&action=deleteOption&id=' . $option['id'])?>"><img  border="0" width="10px" alt="" src="/img/admin/delete.png"></a></td>
		</tr>
	<?php endforeach;?>
		
	<tr>
		<td> <?php echo $form['new_option'][$lang['abr']]['name']->renderLabel( 'New options ', array( 'class' => 'formLabel' )) ?>: </td>
	</tr>
	<tr>
		
		<?php foreach( $form->getLanguages() as $lang ):?>
			<td>   <?php echo $form['new_option'][$lang['abr']]['name']->render(array( 'class' => 'formInput' ))?> </td>		
		<?php endforeach;?>
	</tr>
</table>
