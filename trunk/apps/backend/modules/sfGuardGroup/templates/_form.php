<?php  echo form_tag_for($form, '@sf_guard_group_page' ) ?>
  <fieldset>
    <legend class="formLabel"><?php echo __('Information')?></legend>
  <table id="job_form">
    <tfoot>
      <tr>
        <td colspan="2">
          <input type="submit" class="formSubmit" value="<?php echo __('Save')?>" />
        </td>
      </tr>
    </tfoot>
    <tbody>
    	
	<?php echo $form?>
		
    </tbody>
  </table>
  
 </fieldset>
</form>