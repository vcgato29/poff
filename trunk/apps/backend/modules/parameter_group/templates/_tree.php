<div id="contentlist" style=" width: 65%" class="div">
	<table cellspacing="0" cellpadding="0" border="0" width="70%" class="data">
		<tbody>
			<tr style="padding: 0pt 10px 5px;">
				<td colspan="2">
				 <a style="padding-right:50px" href="<?php echo url_for('@admin_page?module=parameter_group&action=toggleAll&toggle=1')?>"><?php echo __('Open tree')?></a>
				 <a href="<?php echo url_for('@admin_page?module=parameter_group&action=toggleAll&toggle=0')?>"><?php echo __('Close tree')?></a>
				</td>
				
		    </tr>
			  <tr>
			  <td></td>
			  	<td>
					<?php include_partial('parameter_group/treeComponent', array('parameterGroups' => $parameterGroups,'selectedGroups' => $selectedGroups))?>
			   </td>
		    </tr>
		</tbody>
	</table>
</div>