<?php include_component( 'product', 'popuptabs' )?>
<fieldset>
<legend class="formLabel"><?php echo __('Select languages')?></legend>
	<form method="post" action="">
	
	<input type="hidden" name="multilang" value="1" />
	<input type="hidden" name="id" value="<?php echo $sf_request->getParameter('id') ?>" />
	
		<table>
			<tfoot>
				<tr>
					<td> <input class="formSubmit" type="submit" name="Tõlgi" value="<?php echo __('Translate')?>" /></td>
				</tr>
			</tfoot>
			<tbody>
			<?php foreach( $langs as $lang ):?>
				<tr>
					<td>
						<label class="formLabel"> <?php echo $lang->title_est ?> </label>
					</td>
					<td>
						<input type="checkbox" name="langs[]" value="<?php echo $lang['id']?>" /> <br />
					</td>
				</tr>
			<?php endforeach;?>
			</tbody>
		</table>
	</form>
	
</fieldset>