<form action="<?php echo url_for( '@structure_page?action=commonCopy')?>" method="post">  
<fieldset>
    <legend class="formLabel"><?php echo __('Folders copying')?></legend>
  <table id="job_form">
    <tfoot>
      <tr>
        <td colspan="2">
          <input type="submit" value="<?php echo __('Copy')?>" class="formSubmit">
          <input type="hidden" value="" name="selected_node" id="selected_node" />
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

<br />

<?php include_component( 'structure', 'openedNodesLedder', array( 'exceptNodes' => $curNodes, 'checkPermissions' => true, 'permission' => myUser::PERM_RW ) ) ?>

<script type="text/javascript">

$(document).ready(function() {
	$('.node').click( function(){ 
		$('.node').each(function(){
				$(this).html( $(this).text() )
			});
			$('#selected_node').val( this.id );
			$(this).html( '<b>' + $(this).text() + '</b>' ); 
	});
	$('.node_restrited').click( function(){ 
		alert( 'Not Permitted' ); 
	});
});

</script>
