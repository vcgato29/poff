
<div id="rightbox"> 
 <div id="structure_tabs">
    <ul class="tabs"  style="z-index:0">
        <li class=""><a class="button delete_tab tab_link" href="<?php echo url_for( '@sf_guard_group_page?action=adminNew' )?>" ><span>Add</span></a></li>
    </ul>

    <div class="tab-content" id="add_tab">
        <div class="structure_elements_acc">
        <div class="clear"></div>
        
        <form name="structureform">
        
        <?php foreach( $userGroups as $index => $group ):?>

		<!-- structure node start -->
        <div class="item_row_header_up"></div>
        <div class="item_row_header">
            <table>
                <tr>
                    <td style="width:5%">
                        
                    </td>
                    <td>
                      <table>
	                      <tr>
	                        <td width="18%" style="cursor:hand;cursor:pointer;">
	        					<?php echo $group['name']?>
	        				</td>
	                        <td width="26%" style="cursor:hand;cursor:pointer;"><div class="structure_folder_icon">user group</div>
	                        </td>
	                        
	                        <td width="17%" style="cursor:hand;cursor:pointer;">admin</td>
	                        
	
	                      </tr>
                      </table>
                     </td>
     
                    <td style="width:4%" class="icons">
                    	<a  href="<?php echo url_for( '@sf_guard_group_page?action=adminEdit&id=' . $group['id'] )?>">
                    		<img src="img/admin/edit.png" alt="" />
                    	</a>
					</td>
					
                    <td style="width:4%" class="icons"><a class="delete_structure_item_2" href="<?php echo url_for( '@sf_guard_group_page?action=adminDelete&id=' . $group['id'] )?>" onclick="if(!confirm('<?php echo __('Are you sure ?')?>')) return false;"><img src="img/admin/delete.png" alt="" /></a></td>
                </tr>
            </table>
            
            <div class="item_row_content" id="edit_2"></div>
          </div>
          <div class="item_row_header_down"></div>
		<!-- /structure node end -->

       <?php endforeach;?>
		</form>
        </div>
        
    </div>
    <div class="tab-content" id="rights_tab"></div>
</div>

</div>

<!-- defining slot for fancybox stuff -->

