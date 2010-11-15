


<div id="rightbox"> 
 <div id="structure_tabs">
    <ul class="tabs"  style="z-index:0">
        <li class=""><a class="button delete_tab tab_link" id="add_button" href="<?php echo url_for( '@admin_page?module=translation&action=new' )?>" onclick="javascript:return false;" rel="move_tab"><span>Add</span></a></li>
    </ul>

    <div class="tab-content" id="add_tab">
        <div class="structure_elements_acc">
        <div class="clear"></div>
        
        <form name="structureform">
        
        <?php foreach( $transUnits as $index => $transUnit ):?>
		
		<!-- structure  node start -->
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
	        					<?php echo __($transUnit['source'])?>
	        				</td>
	        				
	        				<td width="26%" style="cursor:hand;cursor:pointer;"><?php echo $transUnit['source']?></td>
	        				
	        				
	                        <td width="26%" style="cursor:hand;cursor:pointer;"><div class="structure_trans_icon">translation</div>
	                        </td>
	                        
	                        <td width="17%" style="cursor:hand;cursor:pointer;">admin</td>
	                        
	                        
	
	                      </tr>
                      </table>
                     </td>
     
                    <td style="width:4%" class="icons">
                    	<a  class="struct_node" onclick="javascript:return false;" href="<?php echo url_for( '@admin_page?module=translation&action=edit&source=' . $transUnit['source'] )?>">
                    		<img src="img/admin/edit.png" alt="" />
                    	</a>
					</td>
					
                    <td style="width:4%" class="icons"><a class="delete_structure_item_2" href="<?php echo url_for( '@admin_page?module=translation&action=delete&source=' . $transUnit['source'] )?>" onclick="if(!confirm('Kindel, et kustutan?')) return false;"><img src="img/admin/delete.png" alt="" /></a></td>
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

