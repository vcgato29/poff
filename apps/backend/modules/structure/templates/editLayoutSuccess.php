
<table cellspacing="0" cellpadding="0" border="0" align="center" width="600" class="tabellist">
<tbody>
<tr bgcolor="#cc1110">
	<td align="left" colspan="5" class="formLabel" style="height:15px"></td>
</tr>

<?php foreach( $groupedModules as $placeholder => $moduleGroup ):?>
<tr bgcolor="#f4f4f4" onmouseout="javascript:this.bgColor='#F4F4F4'" onmouseover="javascript:this.bgColor='#DFDFDF'">
	<td align="left" colspan="2" class="formLabel"><b><?php echo ucfirst( $placeholder )?></b></td>
	<td nowrap="" align="right">&nbsp;</td>
	<td align="left"><img height="1" border="0" width="15" src="/img/admin/spacer.gif"></td>
	<td nowrap="" align="right"></td>
</tr>
<tr>
	<td class="halljoon" colspan="5"><img height="1" border="0" width="15" src="/img/admin/spacer.gif"></td>
</tr>
<?php if( isset( $nodeModules[$placeholder] ) && !empty( $nodeModules[$placeholder] ) ):?>
	<?php foreach( $nodeModules[$placeholder] as $moduleRelID => $module ):?>
	<tr bgcolor="#f4f4f4" onmouseout="javascript:this.bgColor='#F4F4F4'" onmouseover="javascript:this.bgColor='#DFDFDF'">
		<td align="left"><img height="1" border="0" width="25" src="/img/admin/spacer.gif"></td>
		<td align="left" class="formLabel">
			<?php echo ucfirst( $module['name'] )?>
		</td>
		<td align="left"><img height="1" border="0" width="15" src="/img/admin/spacer.gif"></td>
		<td nowrap="" align="right">
			<a href="<?php echo url_for( '@structure_page?action=changeModulePriority&order=up&moduleID='.$moduleRelID )?>"><img border="0" alt="up" src="/img/admin/up.png"></a>
			<a href="<?php echo url_for( '@structure_page?action=changeModulePriority&order=down&moduleID='.$moduleRelID )?>"><img border="0" alt="up" src="/img/admin/down.png"></a>&nbsp;&nbsp;
		</td>
		<td nowrap="" align="right">
			<a onclick="if(!confirm('<?php echo __('Are you sure ?')?>')) return false;" class="textU" href="<?php echo url_for( '@structure_page?action=deleteLayoutModule&id='.$moduleRelID . "&moduleName=" . $module . "&placeholder=" . $placeholder)?>"><img border="0" alt="up" src="/img/admin/delete.png"></a>
		</td>
	</tr>
	<tr>
		<td class="halljoon" colspan="5"><img height="1" border="0" width="15" src="/img/admin/spacer.gif"></td>
	</tr>
	<?php endforeach;?>
<?php endif;?>

<tr bgcolor="#f4f4f4" onmouseout="javascript:this.bgColor='#F4F4F4'" onmouseover="javascript:this.bgColor='#DFDFDF'">
<form action="" method="post">
<input type="hidden" name="placeholder" value="<?php echo $placeholder?>" />
	<td align="left"><img height="1" border="0" width="25" src="/img/admin/spacer.gif"></td>
	<td nowrap="" align="left" class="formLabel"><i><?php echo __('Add new')?></i>
			<select class="formInput" name="frontend_module_id">
				<?php $nmoduleGroup= array(); foreach( $moduleGroup as $module ):?>
				<!--<option value="<?php echo $module['id']?>"><?php echo ucfirst( $module )?></option>-->
				<?php  $ntemp = ucfirst( $module ); $nmoduleGroup[$ntemp] = $module['id']?>
				<?php endforeach; ksort($nmoduleGroup); ?>


				<?php foreach( $nmoduleGroup as $key => $value ):?>
				<option value="<?php echo $value?>"><?php echo $key ?></option>
				<?php endforeach;?>
			</select>

	</td>
	<td align="left" width="100%" style="padding:5px">
		<input type="submit" value="ok" class="formSubmit">
	</td>
	<td align="right" colspan="3">&nbsp;</td>
</form>
</tr>

<tr>
	<td class="halljoon" colspan="5"><img height="1" border="0" width="15" src="/img/admin/spacer.gif"></td>
</tr>
<?php endforeach;?>

<tr bgcolor="#cc1110">
	<td align="left" colspan="5" class="formLabel" style="height:15px"></td>
</tr>
</tbody>
</table>