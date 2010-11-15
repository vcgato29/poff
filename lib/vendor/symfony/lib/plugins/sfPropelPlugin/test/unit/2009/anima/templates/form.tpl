text_box=~<input type="text" name="$name$" value="$value$" style="width: $form_controls_with$px" $property$ class="textBox">~
button=~<input type=button value="$label$" class=button onClick="this.blur(); document.$form_name$.FormCmd.value='$cmd$'; document.$form_name$.submit();">~
cancel=~<input type=button value="Tagasi" class=button onClick="this.blur(); document.location='$href$';">~
text_area=~<textarea name="$name$" class="textBox" style="width: 400px; height: 400px" rows="5">$value$</textarea>~
select_box=~<select name="$_01$" style="width: $form_controls_with$px" class="textBox" onChange="$_03$">$_02$</select>~

wysiwyg_box=
~
<script type="text/javascript"  src="$base_url$/fckeditor/fckeditor.js" ></script>
<textarea style="display: none" name="$name$1">$value$</textarea>
<script type="text/javascript">

sBasePath = "$base_url$/fckeditor/";
var oFCKeditor = new FCKeditor('$name$');
// Set the custom configurations file path

oFCKeditor.Config['CustomConfigurationsPath'] = "$fck_conf$";

oFCKeditor.ToolbarSet = "HelpCms";
oFCKeditor.BasePath	= sBasePath;
oFCKeditor.Height	= 300;
oFCKeditor.Width	= 400;
oFCKeditor.Value	= document.$form_name$.$name$1.value;
document.$form_name$.$name$1.value = '';
oFCKeditor.Create();
</script>
~

list_row=~
<tr>
	<td width=150>$_01</td>
	<td>$_02</td>
</tr>
~

form=
~<form name="$name$" method="post" action="$main_script$" enctype="multipart/form-data">
	<input type=hidden name="$record_id_name$" value="$record_id_value$">
	<input type=hidden name=FormCmd value="">
	$hiddens$
	<table cellpadding="0" cellspacing="0" width="400" border="0" class="FormBorder">
	<tr height="20"> 
		<td colspan="2"> 
		</td>
	</tr>
	<tr> 
		<td colspan="2" height="1" class="blackLine"></td>
	</tr>
	$rows$
	<tr class="oddListRow" height=20> 
		<td colspan=2> 
			<table border="0" cellpadding="0" cellspacing="0" width="100%">
				<tr> 
					<td align=right style="padding:3px,7px,3px,3px"><br>$buttons$</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
</form>
~

edit_field_row=~
<tr  class=oddListRow> 
	<td valign="top" width="90" style="padding:3px">$label$:</td>
	<td width="310" style="padding:3px 7px 3px 3px;" align="right"> 
		$control$
	</td>
</tr>
<tr> 
	<td colspan="2" height="1" class="blackLine"></td>
</tr>
~