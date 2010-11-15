test_value1=~whatever value1 $test$~

test_value2=
~whatever value2 $test$~

list_table=
~
<table cellpadding="0" cellspacing="0" border="0">
	<tr> 
		<td  valign="top">

<table cellpadding="0" cellspacing="0" width="$width$" border="0" class="FormBorder">
	<tr height="20"> 
		<td>$title$</td>
		<td align="right" style="padding:0px 3px 0px 3px;">$add_new_link$</td>
	</tr>
	<tr>
		<td colspan="2" height="1" class="blackBg"></td>
	</tr>
	<tr>
		<td colspan="2">
		
<table border="0" cellpadding="0" cellspacing="0" width="$width$">
	$rows$
</table>			
		
		</td>
	</tr>
	<tr>
		<td colspan="2" height="1" class="blackBg"></td>
	</tr>
	<tr height="20"> 
		<td></td>
		<td align=right>$footer$</td>
	</tr>
	
		</td>
		<td valign="top" style="padding-left: 10px">
			$restriction_form$
		</td>
	</tr>
</table>
~

data_row=~<tr height=20 class="$style$">$cols$</tr>~
row_col=~<td height="21" width="$width$" style="padding:0px 3px 0px 3px;">$value$</td>~
message_row=~<tr><td height=20 class="oddListRow">&nbsp;$msg$</td></tr>~
col_separator=~<td width="1" class="blackBg"></td>~

button_command=~<a href="$link$"><img border=0 title="$title$" src="$base_url$/img/$img$"></a>~

add_new_link=~<a href="$link$"><img border=0 src="$base_url$/img/bttn_add.gif"></a>~
button_new=~<a href="$_01"><img border=0 title="uus" src="$base_url$/img/bttn_add.gif"></a>~
button_edit=~<a href="$_01"><img border=0 title="muuda" src="$base_url$/img/bttn_edit.gif"></a>~
button_up=~<a href="$_01"><img border=0 title="üles" src="$base_url$/img/bttn_up.gif"></a>~
button_up_dis=~<img border=0 src="$base_url$/img/bttn_up_dis.gif">~
button_down=~<a href="$_01"><img border=0 title="alla" src="$base_url$/img/bttn_down.gif"></a>~
button_down_dis=~<img border=0 src="$base_url$/img/bttn_down_dis.gif">~
button_del=~<a href="$_01"><img border=0 title="kustuta" $_02 src="$base_url$/img/bttn_del.gif"></a>~

button_edit_page=~<a href="$link$"><img border=0 title="muuda lehte" src="$base_url$/img/bttn_edit_page.gif"></a>~

button_upload=~<a href="$_01"><img border=0 title="upload" src="$base_url$/img/bttn_upload.gif"></a>~