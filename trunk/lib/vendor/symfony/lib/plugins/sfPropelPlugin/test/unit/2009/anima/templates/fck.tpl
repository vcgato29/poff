browse_image_row=~
<tr> 
	<td>$image_link$</td>
	<td align="right" width="20px">$del_link$</td>
</tr>~;

del_image_link=~<a href="javascript:confirm_and_go('Kustutada','$url$')"><img src="img/bttn_del.gif" border="0" align="absmiddle">~;

table=~
<table cellpadding="0" cellspacing="0" width="450" border="0" style="border-type: solid; border-color: #000; border-width: 1px">
	$rows$
</table>~;
~

trtd=~<tr height="21" class="$style$"><td  style="padding:0px 3px 0px 3px;">$value$</td></tr>~

image_trtd=~<tr height="21" class="$style$"><td  style="padding:0px 3px 0px 3px;">$link$</td><td style="padding:0px 3px 0px 3px;" align="right">$del_button$</td></tr>~

select_image_link=~<a href="#" onDblClick="javascript:setUrl('$image_url$');" onClick="javascript:setPreview('$image_url$');">$filename$</a>~

