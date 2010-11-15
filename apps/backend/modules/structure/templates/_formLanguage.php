<form action="<?php echo url_for( '@structure_page?action=addLanguage' )?>" method="post" >
 <fieldset>
    <legend class="formLabel"><?php echo __('Select language')?></legend>
  <table id="job_form">
    <tfoot>
      <tr>
        <td colspan="2">
          <input type="submit" class="formSubmit" value="<?php echo __('Save')?>" />
        </td>
      </tr>
    </tfoot>
    <tbody>
    	
	<tr>
	  <th><?php echo $form['language']->renderLabel('Language',array('class'=>'formLabel')); ?></th>
	  <td>
	    <?php echo $form['language']->renderError() ?>
	    <?php echo $form['language'] ?>
	  </td>
	</tr>
    </tbody>
  </table>  
 </fieldset>
</form>