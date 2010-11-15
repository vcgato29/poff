<?php include_component( 'product', 'popuptabs' )?>

<style>
/* -- Form Styles ------------------------------- */
div.fieldset {
	border:  1px solid #afe14c;
	margin: 10px 0;
	padding: 20px 10px;
}
div.fieldset span.legend {
	position: relative;
	padding: 3px;
	top: -30px;
	font: 700 14px Arial, Helvetica, sans-serif;
	color: #73b304;
}

div.flash {
	width: 375px;
	margin: 10px 5px;
	border-color: #D9E4FF;

	-moz-border-radius-topleft : 5px;
	-webkit-border-top-left-radius : 5px;
    -moz-border-radius-topright : 5px;
    -webkit-border-top-right-radius : 5px;
    -moz-border-radius-bottomleft : 5px;
    -webkit-border-bottom-left-radius : 5px;
    -moz-border-radius-bottomright : 5px;
    -webkit-border-bottom-right-radius : 5px;

}



#btnSubmit { margin: 0 0 0 155px ; }



.progressWrapper {
	width: 357px;
	overflow: hidden;
}

.progressContainer {
	margin: 5px;
	padding: 4px;
	border: solid 1px #E8E8E8;
	background-color: #F7F7F7;
	overflow: hidden;
}
/* Message */
.message {
	margin: 1em 0;
	padding: 10px 20px;
	border: solid 1px #FFDD99;
	background-color: #FFFFCC;
	overflow: hidden;
}
/* Error */
.red {
	border: solid 1px #B50000;
	background-color: #FFEBEB;
}

/* Current */
.green {
	border: solid 1px #DDF0DD;
	background-color: #EBFFEB;
}

/* Complete */
.blue {
	border: solid 1px #CEE2F2;
	background-color: #F0F5FF;
}

.progressName {
	font-size: 8pt;
	font-weight: 700;
	color: #555;
	width: 323px;
	height: 14px;
	text-align: left;
	white-space: nowrap;
	overflow: hidden;
}

.progressBarInProgress,
.progressBarComplete,
.progressBarError {
	font-size: 0;
	width: 0%;
	height: 2px;
	background-color: blue;
	margin-top: 2px;
}

.progressBarComplete {
	width: 100%;
	background-color: green;
	visibility: hidden;
}

.progressBarError {
	width: 100%;
	background-color: red;
	visibility: hidden;
}

.progressBarStatus {
	margin-top: 2px;
	width: 337px;
	font-size: 7pt;
	font-family: Arial;
	text-align: left;
	white-space: nowrap;
}

a.progressCancel {
	font-size: 0;
	display: block;
	height: 14px;
	width: 14px;
	background-image: url(../images/cancelbutton.gif);
	background-repeat: no-repeat;
	background-position: -14px 0px;
	float: right;
}

a.progressCancel:hover {
	background-position: 0px 0px;
}


/* -- SWFUpload Object Styles ------------------------------- */
.swfupload {
	vertical-align: top;
}

</style>
<script type="text/javascript" src="/js/swfupload/samples/demos/swfupload/swfupload.js"></script>
<script type="text/javascript" src="/js/swfupload/samples/demos/swfupload/swfupload.queue.js"></script>
<script type="text/javascript" src="/js/swfupload/samples/demos/simpledemo/js/fileprogress.js"></script>
<script type="text/javascript" src="/js/swfupload/samples/demos/simpledemo/js/handlers.js"></script>
<script type="text/javascript">
		var swfu;

		window.onload = function() {
			var settings = {
				flash_url : "/js/swfupload/samples/demos/swfupload/swfupload.swf",
				flash9_url : "/js/swfupload/samples/demos/swfupload/swfupload_fp9.swf",
				upload_url: "<?php echo url_for("@admin_page?module=product_file&action=swfupload"); ?>?<?php echo ini_get('session.name') ?>=<?php echo session_id() ?>",
				post_params: {"product_id" : "<?php echo $sf_request->getParameter('id')?>"},
				file_size_limit : "100 MB",
				file_types : "*",
				file_types_description : "Pildid",
				file_upload_limit : 100,
				file_queue_limit : 0,
				custom_settings : {
					progressTarget : "fsUploadProgress",
					cancelButtonId : "btnCancel"
				},
				debug: false,

				// Button settings
				button_image_url: "/js/swfupload/samples/demos/simpledemo/images/TestImageNoText_65x29.png",
				button_width: "65",
				button_height: "29",
				button_placeholder_id: "spanButtonPlaceHolder",
				button_text: '<span class="inputLabel"><?php echo __('Upload')?></span>',
				button_text_style: ".theFont { font-size: 16; }",
				button_text_left_padding: 12,
				button_text_top_padding: 3,

				// The event handler functions are defined in handlers.js
				swfupload_preload_handler : preLoad,
				swfupload_load_failed_handler : loadFailed,
				file_queued_handler : fileQueued,
				file_queue_error_handler : fileQueueError,
				file_dialog_complete_handler : fileDialogComplete,
				upload_start_handler : uploadStart,
				upload_progress_handler : uploadProgress,
				upload_error_handler : uploadError,
				upload_success_handler : uploadSuccess,
				upload_complete_handler : uploadComplete,
				queue_complete_handler : queueComplete	// Queue plugin event
			};

			swfu = new SWFUpload(settings);
	     };
</script>

<form action="<?php echo url_for( '@admin_page?module=product_file&action=update&id=' . $sf_request->getParameter('id') )?>" method="post">
<?php echo $form->renderHiddenFields(true) ?>

<br />
<br />
<fieldset style="float:right;">
	<legend class="formLabel"><?php echo __('Files uploading')?></legend>
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



<fieldset>
    <legend class="formLabel"><?php echo __('Failid')?></legend>
    <div  class="">
	    <table cellspacing="0" cellpadding="10" border="1" width="100%"  style="border: 1px solid rgb(223, 223, 223); border-collapse: collapse;">
	          <tbody>
		          <tr>
		            <th align="center" class="formLabel"><?php echo __('Filename')?></th>
		            <th align="center" class="formLabel"><?php echo __('Translated')?></th>
		            <th align="center" class="formLabel"><?php echo __('Parameter')?></th>
		            <th align="center" class="formLabel"><?php echo __('Priority')?></th>
		            <th align="center" class="formLabel"><?php echo __('Delete')?> <input onclick="checkAll()" id="sf_admin_list_batch_checkbox" type="checkbox" /></th>
		          </tr>
		      <?php foreach( $files as  $index => $pict ):?>
				<tr>
					<td align="center" style="padding-right: 10px;" class="formLabel"><?php echo $pict['original_filename']?></td>
					<td align="center">
								<table>
								<?php foreach( $form->getLanguages() as $lang ):?>
									<tr>
										<td>
										<?php echo $form['file_'.$pict['id']][$lang['abr']]['name']->renderLabel( $lang['abr'], array( 'class' => 'formLabel' ) )?>
											<?php echo $form['file_'.$pict['id']][$lang['abr']]['name']->render(array( 'class' => 'formInput' ) )  ?>
										</td>
									</tr>
								<?php endforeach;?>
								</table>
					</td>
					<td align="center">
						<?php echo $form['file_'.$pict['id']]['parameter']->render(array( 'class' => 'formInput', 'size'=>1 ))?><br />
					</td>

					<td align="center" class="formLabel">
						<?php if( $index != 0 ):?>
							<a href="<?php echo url_for( '@admin_page?module=product_file&action=priority&order=up&id=' . $pict['id'] )?>">
								<img src="/img/admin/sort_up.gif" style="padding:5px" border="0" alt="Up">
							</a>
						<?php endif;?>
						<?php if( $index + 1 != count($files) ):?>
							<a href="<?php echo url_for( '@admin_page?module=product_file&action=priority&order=down&id=' . $pict['id'] )?>">
								<img src="/img/admin/sort_down.gif" style="padding:5px" border="0" alt="Down">
							</a>
						<?php endif;?>
					</td>
					<td align="center" ><input type="checkbox" name="deletepics[]" class="sf_admin_batch_checkbox" value="<?php echo $pict['id']?>" /></td>
				</tr>
			<?php endforeach;?>

			</tbody>
		</table>
		<br />
		<input class="formInput" type="submit" name="Salvesta" value="<?php echo __('Save')?>" />
	</div>

</fieldset>
<script type="text/javascript">
/* <![CDATA[ */
function checkAll()
{
  var boxes = document.getElementsByTagName('input'); for(var index = 0; index < boxes.length; index++) { box = boxes[index]; if (box.type == 'checkbox' && box.className == 'sf_admin_batch_checkbox') box.checked = document.getElementById('sf_admin_list_batch_checkbox').checked } return true;
}
/* ]]> */
</script>


</form>