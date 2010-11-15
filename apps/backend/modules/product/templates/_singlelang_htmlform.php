<fieldset>
<legend class="formLabel"><?php echo $parameter['title']?></legend>
	<table>
		<tr>
				<td>
					<?php echo $form[$index]['common_value']->render(array( 'id' => $parameter->id, 'class' => 'formInput'))?>
				</td>

		</tr>
	</table>
</fieldset>

<script type="text/javascript">
//<![CDATA[

	// This call can be placed at any point after the
	// <textarea>, or inside a <head><script> in a
	// window.onload event handler.

	// Replace the <textarea id="editor"> with an CKEditor
	// instance, using default configurations.
	var editor_<?php echo $parameter->id?> = CKEDITOR.replace( '<?php echo $parameter->id ?>' );
	// Just call CKFinder.SetupCKEditor and pass the CKEditor instance as the first argument.
	// The second parameter (optional), is the path for the CKFinder installation (default = "/ckfinder/").
	CKFinder.SetupCKEditor( editor_<?php echo $parameter->id?>, '/js/ckfinder/'  ) ;

	// It is also possible to pass an object with selected CKFinder properties as a second argument.
	// CKFinder.SetupCKEditor( editor, { BasePath : '../../', RememberLastFolder : false } ) ;

//]]>
</script>

