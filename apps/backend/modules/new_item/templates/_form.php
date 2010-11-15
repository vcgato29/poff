<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>



  <?php echo form_tag_for($form, '@new_item') ?>

    <?php echo $form->renderHiddenFields(false) ?>

    <?php if ($form->hasGlobalErrors()): ?>
      <?php echo $form->renderGlobalErrors() ?>
    <?php endif; ?>

  <table style="float:left">
	   <tbody>
	    	<tr>
	    		<td><?php echo $form['name']->renderLabel('', array( 'class' => 'formLabel' ))?></td>
	    		<td><?php echo $form['name']->render( array( 'class' => 'formInput', 'size' => '40' ))?></td>
	    		<td><?php echo $form['name']->renderError()?></td>
	    	</tr>
	    	<tr>
	    		<td><?php echo $form['description']->renderLabel('', array( 'class' => 'formLabel' ))?></td>
	    		<td><?php echo $form['description']->render( array( 'class' => 'formInput' ))?></td>
	    		<td><?php echo $form['description']->renderError()?></td>
	    	</tr>
	    	<tr>
	    		<td><?php echo $form['group_id']->renderLabel('', array( 'class' => 'formLabel' ))?></td>
	    		<td><?php echo $form['group_id']->render( array( 'class' => 'formInput' ))?></td>
	    		<td><?php echo $form['group_id']->renderError()?></td>
	    	</tr>

	    	<tr>
	    		<td>
	    			<?php echo $form['active_start']->renderLabel('', array( 'class' => 'formLabel' ))?>
	    		</td>
	    		<td><?php if ($form['active_start']->getValue()!="") $value_active_start = $form['active_start']->getValue();  else $value_active_start = date('Y-m-d H:i:s');
	    		echo $form['active_start']->render( array( 'class' => 'formInput', 'id' => 'active_start', 'value' => $value_active_start ))?>
	    			<input type="button" value="Vali" class="formInput" onclick="displayCalendar(document.getElementById('active_start'),'yyyy-mm-dd 00:00:00',this);">
	    		</td>
	    		<td><?php echo $form['active_start']->renderError()?></td>
	    	</tr>
		    <tr>
	    		<td><?php echo $form['type']->renderLabel('', array( 'class' => 'formLabel' ))?></td>
	    		<td><?php echo $form['type']->render( array( 'class' => 'formInput' ))?></td>
	    		<td><?php echo $form['type']->renderError()?></td>
	    	</tr>

	    </tbody>
    </table>
	<table>
		<tbody>
	    	<tr>
	    		<td><?php echo $form['slug']->renderLabel('URL', array( 'class' => 'formLabel' ))?></td>
	    		<td><?php echo $form['slug']->render( array( 'class' => 'formInput','size' => '40' ))?></td>
	    		<td><?php echo $form['slug']->renderError()?></td>
	    	</tr>
    		<tr>
	    		<td><?php echo $form['tags']->renderLabel('', array( 'class' => 'formLabel' ))?></td>
	    		<td><?php echo $form['tags']->render( array( 'class' => 'formInput' ))?></td>
	    		<td><?php echo $form['source']->renderError()?></td>
	    	</tr>
	    	<tr>
	    		<td><!--<?php echo $form['source']->renderLabel('', array( 'class' => 'formLabel' ))?>--><label class="formLabel" for="new_item_source">External URL</label></td>
	    		<td><?php echo $form['source']->render( array( 'class' => 'formInput' ))?></td>
	    		<td><?php echo $form['source']->renderError()?></td>
	    	</tr>

	    	<tr>
	    		<td>
	    			<?php echo $form['active_end']->renderLabel('', array( 'class' => 'formLabel' ))?>
	    		</td>
	    		<td><?php echo $form['active_end']->render( array( 'class' => 'formInput', 'id' => 'active_end' ))?>
	    			<input type="button" value="Vali" class="formInput" onclick="displayCalendar(document.getElementById('active_end'),'yyyy-mm-dd',this);">
	    		</td>
	    		<td><?php echo $form['active_end']->renderError()?></td>
	    	</tr>
		</tbody>
	</table>


<table style="float:left;clear:both;">
    	<tfoot>
    		<tr>
    			<td>
    				<input type="submit" name="Salvesta" value="Salvesta" class="formInput" />
    			</td>
    		</tr>
    	</tfoot>
	<tbody>
    	<tr>
    		<td><?php echo $form['content']->renderLabel('', array( 'class' => 'formLabel' ))?></td>
    		<td><?php echo $form['content']->render( array( 'class' => 'formInput' ))?></td>
    		<td><?php echo $form['content']->renderError()?></td>
    	</tr>
    	<tr>
    		<td><?php echo $form['picture']->renderLabel('', array( 'class' => 'formLabel' ))?></td>
    		<td><?php echo $form['picture']->render( array( 'class' => 'formInput' ))?></td>
    		<td><?php echo $form['picture']->renderError()?></td>
    	</tr>
	</tbody>
</table>




  </form>



<script type="text/javascript">
			//<![CDATA[

				// This call can be placed at any point after the
				// <textarea>, or inside a <head><script> in a
				// window.onload event handler.

				// Replace the <textarea id="editor"> with an CKEditor
				// instance, using default configurations.

				var editor_5 = CKEDITOR.replace( 'content',
						{
							height:"200", width:"850",

						}		 );
				// Just call CKFinder.SetupCKEditor and pass the CKEditor instance as the first argument.
				// The second parameter (optional), is the path for the CKFinder installation (default = "/ckfinder/").
				CKFinder.SetupCKEditor( editor_5, '/js/ckfinder/'  ) ;

				// It is also possible to pass an object with selected CKFinder properties as a second argument.
				// CKFinder.SetupCKEditor( editor, { BasePath : '../../', RememberLastFolder : false } ) ;

			//]]>
			</script>