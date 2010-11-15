<form action="<?php echo url_for( '@structure_page?action=commonDelete')?>" method="post">  
<fieldset>
    <legend class="formLabel"><?php echo __('Folders deletion')?></legend>
  <table id="job_form">
    <tfoot>
      <tr>
        <td colspan="2">
          <input type="submit" value="<?php echo __('Delete')?>" class="formSubmit">
        </td>
      </tr>
    </tfoot>
    <tbody>
		<?php foreach( $curNodes as $node ):?>
			<tr>
	  			<th>
	  				<label for="struct_<?php echo $node['id']?>" class="formLabel"><?php echo $node['title']?></label>
	  			</th>
		  		<td>
		  			<input type="checkbox" checked name="struct[]" value="<?php echo $node['id']?>" />
		 		 </td>
			</tr>
		<?php endforeach;?>    	
    </tbody>
  </table>
  
 </fieldset>
</form>
