

<?php if( !isset( $formTagStarted ) ):?>
	<?php  echo form_tag_for($form, '@structure' ) ?>
<?php endif;?>
<?php echo $form->renderHiddenFields()?>
  <fieldset>
    <legend class="formLabel"><?php echo __( 'Structure info' )?></legend>
  <table id="job_form" style="float:left;padding-right:100px">

    <tbody>
    	
	<tr>
	  <th><?php echo $form['title']->renderLabel('Name',array('class'=>'formLabel')); ?></th>
	  <td>
	    <?php echo $form['title']->renderError() ?>
	    <?php echo $form['title'] ?>
	  </td>
	</tr>

	<tr>
	  <th><?php echo $form['metaDescription']->renderLabel('metaDescription',array('class'=>'formLabel')); ?></th>
	  <td>
	    <?php echo $form['metaDescription']->renderError() ?>
	    <?php echo $form['metaDescription'] ?>
	  </td>
	</tr>
  	<tr>
	  <th><?php echo $form['pageTitle']->renderLabel('Title',array('class'=>'formLabel')); ?></th>
	  <td>
	    <?php echo $form['pageTitle']->renderError() ?>
	    <?php echo $form['pageTitle'] ?>
	  </td>
	</tr>





	<tr>
	  <th><?php echo $form['type']->renderLabel('Type',array('class'=>'formLabel')); ?></th>
	  <td>
	    <?php echo $form['type']->renderError() ?>
	    <?php echo $form['type'] ?>
	  </td>
	</tr>
	<tr>
	  <th><?php echo $form['isHidden']->renderLabel('Hidden',array('class'=>'formLabel')); ?></th>
	  <td>
	    <?php echo $form['isHidden']->renderError() ?>
	    <?php echo $form['isHidden'] ?>
	    <!-- findme_kjhjkhkjh -->
	    <?php echo $form['parentID']?>
	    
	  </td>
	</tr>
		
    </tbody>
  </table>
  
  
  <table>
  	<tbody>
	<tr>
	  <th><?php echo $form['metaKeywords']->renderLabel('metaKeywords',array('class'=>'formLabel')); ?></th>
	  <td>
	    <?php echo $form['metaKeywords']->renderError() ?>
	    <?php echo $form['metaKeywords'] ?>
	  </td>
	</tr>
	<tr>
	  <th><?php echo $form['description']->renderLabel('Description',array('class'=>'formLabel')); ?></th>
	  <td>
	    <?php echo $form['description']->renderError() ?>
	    <?php echo $form['description'] ?>
	  </td>
	</tr>
	<tr>
	  <th><?php echo $form['layout']->renderLabel('Template',array('class'=>'formLabel')); ?></th>
	  <td>
	    <?php echo $form['layout']->renderError() ?>
	    <?php echo $form['layout'] ?>
	  </td>
	</tr>
	<tr>
	  <th><?php echo $form['inherits_layout']->renderLabel('Inherited layout',array('class'=>'formLabel')); ?></th>
	  <td>
	    <?php echo $form['inherits_layout']->renderError() ?>
	    <?php echo $form['inherits_layout'] ?>
	  </td>
	</tr>

  	
  	</tbody>
  </table>
  
  <table style="float:left; clear:both">
    <tfoot>
      <tr>
        <td colspan="2">
          <input type="submit" class="formSubmit" value="<?php echo __('Save')?>" />
        </td>
      </tr>
    </tfoot>
	<tr>
	  <th><?php echo $form['content']->renderLabel('Content',array('class'=>'formLabel')); ?></th>
	  <td>
	    <?php echo $form['content']->renderError() ?>
	    <?php echo $form['content']->render(array( 'id' => $form->getObject()->id )) ?>
			<script type="text/javascript">
			//<![CDATA[

				// This call can be placed at any point after the
				// <textarea>, or inside a <head><script> in a
				// window.onload event handler.

				// Replace the <textarea id="editor"> with an CKEditor
				// instance, using default configurations.
				
				var editor_<?php echo $form->getObject()->id?> = CKEDITOR.replace( '<?php echo $form->getObject()->id ? $form->getObject()->id : 'content'?>' );
				// Just call CKFinder.SetupCKEditor and pass the CKEditor instance as the first argument.
				// The second parameter (optional), is the path for the CKFinder installation (default = "/ckfinder/").
				CKFinder.SetupCKEditor( editor_<?php echo $form->getObject()->id?>, '/js/ckfinder/'  ) ;

				// It is also possible to pass an object with selected CKFinder properties as a second argument.
				// CKFinder.SetupCKEditor( editor, { BasePath : '../../', RememberLastFolder : false } ) ;

			//]]>
			</script>

	  </td>
	</tr>
	<tr>
	  <th><?php echo $form['picture']->renderLabel('Picture', array('class'=>'formLabel') ); ?></th>
	  <td>
	    <?php echo $form['picture']->renderError() ?>
	    <?php echo $form['picture'] ?>
	  </td>
	  
	</tr>
  </table>
  
  
 </fieldset>
</form>