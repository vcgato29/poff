<style>
.formInput{
width:150px !important;
}
</style>
<br />
<br />

	
<fieldset style="float:right;width:700px">
    <legend class="formLabel"><?php echo __('Pictures')?></legend>
    <div  class="">
	    <table cellspacing="0" cellpadding="10" border="1" width="100%"  style="border: 1px solid rgb(223, 223, 223); border-collapse: collapse;">
	          <tbody>
		          <tr>
		            <th align="center" class="formLabel"><?php echo __('Filename')?></th>
		            <th align="center" class="formLabel"><?php echo __('Translated')?></th>
		            <th align="center" class="formLabel"><?php echo __('Parameter')?></th>
		            <th align="center" class="formLabel"><?php echo __('Priority')?></th>
		            <th align="center" class="formLabel"><?php echo __('Preview')?></th>
		            <th align="center" class="formLabel"><?php echo __('Delete')?> <input onclick="checkAll()" id="sf_admin_list_batch_checkbox" type="checkbox" /></th>
		          </tr>
		      <?php foreach( $pictures as  $index => $pict ):?>
				<tr>
					<td align="center" style="padding-right: 10px;" class="formLabel"><?php echo $pict['original_filename']?></td>
					<td align="center">
								<table>
								<?php foreach( $form->getLanguages() as $lang ):?>
									<tr>
										<td>
										<?php echo $form['picture_'.$pict['id']][$lang['abr']]['name']->renderLabel( $lang['abr'], array( 'class' => 'formLabel' ) )?>
											<?php echo $form['picture_'.$pict['id']][$lang['abr']]['name']->render(array( 'class' => 'formInput' ) )  ?>
										</td>
									</tr>
								<?php endforeach;?>
								</table>
					</td>
					<td align="center">
						<?php echo $form['picture_'.$pict['id']]['parameter']->render(array( 'class' => 'formInput', 'size'=>1 ))?><br />
					</td>
					
					<td align="center" class="formLabel">  
						<?php if( $index != 0 ):?>
							<a href="<?php echo url_for( '@admin_page?module=product&action=productpicspriority&order=up&id=' . $pict['id'] )?>">
								<img src="/img/admin/sort_up.gif" style="padding:5px" border="0" alt="Up">
							</a>
						<?php endif;?>
						<?php if( $index + 1 != count($pictures) ):?>
							<a href="<?php echo url_for( '@admin_page?module=product&action=productpicspriority&order=down&id=' . $pict['id'] )?>">
								<img src="/img/admin/sort_down.gif" style="padding:5px" border="0" alt="Down">
							</a>
						<?php endif;?>
					</td>
					<td align="center" class="formLabel"><img src="<?php echo Picture::getInstance( '', $pict['file'], '', 70, 70 )->getRawLink('resize')?>" /></td>
					<td align="center" ><input type="checkbox" name="deletepics[]" class="sf_admin_batch_checkbox" value="<?php echo $pict['id']?>" /></td>
				</tr>
			<?php endforeach;?>

			</tbody>
		</table> 
		<br />
		<input class="formInput" type="submit" name="Salvesta" value="<?php echo __('Save')?>" />
	</div>
	
</fieldset>


<fieldset>
	<legend class="formLabel"><?php echo __('Pictures uploading (500kb max)')?></legend>
		<table>
			<tr>
				<td>
					<form id="form1" action="" method="post" enctype="multipart/form-data">
							<div class="fieldset flash" id="fsUploadProgress">
							<span class="legend"><?php echo __('Upload Queue')?></span>
							</div>
						<!--  <div id="divStatus">0 Files Uploaded</div> -->
							<div>
								<span id="spanButtonPlaceHolder"></span>
								<input id="btnCancel" type="button" value="<?php echo __('Cancel All Uploads')?>" onclick="swfu.cancelQueue();" disabled="disabled" style="margin-left: 2px; font-size: 8pt; height: 29px;" />
							</div>
					</form>
				</td>

			</tr>
		</table>
</fieldset>

<script type="text/javascript">
/* <![CDATA[ */
function checkAll()
{
  var boxes = document.getElementsByTagName('input'); for(var index = 0; index < boxes.length; index++) { box = boxes[index]; if (box.type == 'checkbox' && box.className == 'sf_admin_batch_checkbox') box.checked = document.getElementById('sf_admin_list_batch_checkbox').checked } return true;
}
/* ]]> */
</script>


