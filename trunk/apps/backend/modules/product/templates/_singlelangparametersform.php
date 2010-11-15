<form action="<?php echo url_for('@admin_page?module=product&multilang=0&action=parametersUpdate&id='. $sf_request->getParameter('id') )  ?>" method="post" enctype="multipart/form-data">
<?php echo $form->renderHiddenFields(true)?>
	<table  cellpadding="5px">
		<tfoot>
			<tr>
				<td>
					<input type="submit" class="formSubmit" name="<?php echo __('Save')?>" value="<?php echo __('Save')?>" />
				</td>
			</tr>
		</tfoot>
		<tbody>
			<?php foreach( $form->getParams() as $index => $param ):?>
				<tr>
					<td>
						<?php include_partial('product/' . $param->getParamValueForm()->getEditFormRendereringTemplate(), 
										array( 'form' => $form, 'index' => 'param_' . $param['id'],  'parameter' => $param) )?>
					</td>
				</tr>
			<?php endforeach;?>
		</tbody>
	</table>
</form>