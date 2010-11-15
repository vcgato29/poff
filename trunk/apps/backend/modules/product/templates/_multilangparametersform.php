<form action="<?php echo url_for('@admin_page?module='.$helper->getModuleName().'&multilang=1&action=parametersUpdate&id='. $sf_request->getParameter('id') )  ?>" method="post" enctype="multipart/form-data">
<?php echo $form->renderHiddenFields(true)?>
<table width="100%">
  <thead>
    <tr>
		<?php foreach( $langs as $lang ):?>
		<th>
			<?php echo $lang['abr']?>
		</th>
		<?php endforeach;?>
    </tr>
</thead>
<tfoot>
    <tr>
	<td>
	    <input type="submit" class="formSubmit" name="<?php echo __('Save')?>" value="<?php echo __('Save')?>" />
	</td>
    </tr>
</tfoot>
	<tbody>
		<tr>
			<?php foreach( $langs as $lang ):?>
				<td align="center">
					<table>
					<?php foreach( $form->getParams() as $index => $param ):?>
						<tr>
							<td>
								<?php include_partial('product/' . $param->getParamValueForm()->getEditFormRendereringTemplate(), 
												array( 'form' => $form, 'index' => 'param_' . $param['id'],  'parameter' => $param, 'lang' => $lang) )?>
							</td>
						</tr>
					<?php endforeach;?>
					</table>
				</td>
			<?php endforeach;?>
		</tr>
	</tbody>
</table>
</form>