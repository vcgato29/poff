
 
 <div id="structure_tabs">
    <ul class="tabs"  style="z-index:0">
        <li>
                <a id="add_button" class="button defaulttab tab_link" href="<?php 
                if( !empty( $curStruct ) )
                	echo url_for( '@structure_child_new?parentID=' . $curStruct['id'], true);
                else
                	echo url_for( '@structure_child_new?parentID=0', true);
                 ?>" onclick="javascript:return false;"><span><?php echo  __("Add") ?></span>
                 </a>    
        </li>
        
        <li><a class="button delete_tab tab_link common_action_tab" id="copy_tab" href="<?php echo url_for( '@structure_page?action=commonCopy' )?>::100::100::0" onclick="javascript:return false;"><span><?php echo __("Copy") ?></span></a></li>
		<li><a class="button delete_tab tab_link common_action_tab" id="move_tab" href="<?php echo url_for( '@structure_page?action=commonMove' )?>::100::100::1" onclick="javascript:return false;"><span><?php echo __("Move") ?></span></a></li>
        <li><a class="button delete_tab tab_link common_action_tab" id="delete_tab" href="<?php echo url_for( '@structure_page?action=commonDelete' )?>::50::50::1" onclick="javascript:return false;"><span><?php echo  __("Delete") ?></span></a></li>
        <li><a class="button delete_tab tab_link common_action_tab" id="edit_tab" href="<?php echo url_for( '@structure_page?action=commonEdit' )?>::100::100::1" onclick="javascript:return false;"><span><?php echo __("Edit") ?></span></a></li>
		<li><a class="button delete_tab tab_link common_action_tab" id="rights_tab" href="<?php echo url_for( '@structure_page?action=commonRights' )?>::100::100::0" onclick="javascript:return false;"><span><?php echo __("Rights") ?></span></a></li>
		<li><a class="button delete_tab tab_link" id="checkboxall"  href="#" onclick="javascript:return false;"><span><?php echo __('Select all') ?> <input id="checkboxall_real" type="checkbox" name="c" style="display:none" /></span></a></li>
		
    </ul>

    <div class="tab-content" id="add_tab">
        <div class="structure_elements_acc">
        <div class="clear"></div>
        
        <form name="structureform">

        
        <?php foreach( $structureList as $index => $struct ):?>

		<!-- structure node start -->
        <div class="item_row_header_up"></div>
        <div class="item_row_header">
            <table>
                <tr>
                    <td style="width:5%">
                        <input class="structcheck" id="node_<?php echo $index?>" name="structs" value="<?php echo $struct['id']?>" type="checkbox" />
                    </td>
                    <td>
                      <table>
                      <tr>
                        <td width="18%" style="cursor:hand;cursor:pointer;">
        					<?php echo link_to($struct['title'], '@structure_page?action=index&nodeid='.$struct['id'] . '&lang=' . $selectedLanguage ) ?>
        				</td>
                        <td width="15%" style="cursor:hand;cursor:pointer;"><div class="structure_folder_icon"><?php echo __('folder')?></div>
                        </td>
                        <td width="10%" style="cursor:hand;cursor:pointer;"><?php echo $struct['created_at']?></td>
                        <td width="10%" style="cursor:hand;cursor:pointer;"><?php echo isset( $struct['created_by_user']['username'] ) ? $struct['created_by_user']['username'] : '-' ?></td>
                        
						<td width="10%" style="cursor:hand;cursor:pointer;"><?php echo $struct['updated_at']?></td>
                        <td width="10%" style="cursor:hand;cursor:pointer;"><?php echo isset( $struct['updated_by_user']['username'] ) ? $struct['updated_by_user']['username'] : '-' ?></td>
                        
                        <td width="15%">
                          <div class="order_down">
                          	<a href="<?php echo url_for( '@structure_page?action=order&order=down&nodeid='.$struct['id'] . '&lang=' . $selectedLanguage )?>"><img src="img/admin/down.png" alt="down"/></a>                             
                          </div>
                          <div class="order_up">
                            <a href="<?php echo url_for( '@structure_page?action=order&order=up&nodeid='.$struct['id'] . '&lang=' . $selectedLanguage )?>"><img src="img/admin/up.png" alt="up"/></a>
                          </div>
                        </td>
                      </tr>
                      </table>
                     </td>
                     <td style="width:4%" class="icons">
                     	<?php if( !$struct['inherits_layout'] ):?>
                     		<a class="struct_layout" onclick="javascript:return false;" href="<?php echo url_for( '@structure_page?action=editLayout&id='.$struct['id'])?>" onclick=""><img style="padding-bottom:5px"  width="30" src="img/admin/module.png" alt="" /></a>
                     	<?php endif;?>
                     </td>
                    <td style="width:4%" class="icons">
                    	<a class="struct_node"  onclick="javascript:return false;" href="<?php echo url_for( '@structure_child_edit?id='.$struct['id'], true);?>">
                    		<img src="img/admin/edit.png" alt="" />
                    	</a>
					</td>
					
                    <td style="width:4%" class="icons"><a class="delete_structure_item_2" href="<?php echo url_for('@structure_child_delete?id='.$struct['id'])?>" onclick="if(!confirm('<?php echo __('Are you sure ?')?>')) return false;"><img src="img/admin/delete.png" alt="" /></a></td>
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
    
    <ul class="tabs"  style="z-index:0">        
    	<?php if(!$curStruct['inherits_layout']):?>
    		<li>
    		
    			<a class="button delete_tab tab_link struct_node" id="copy_tab" href="<?php echo url_for( '@structure_page?action=editLayout&id=' . $sf_request->getParameter('nodeid') )?>" onclick="javascript:return false;">
    				<img style="position:absolute" width="30" alt="" src="img/admin/module.png" style="padding-bottom: 5px;" />
    			<span><?php echo __("Layout") ?></span>
    			
    			</a>
    		</li>
    	<?php endif;?>
		<li>
		<a class="button delete_tab tab_link struct_node"  href="<?php echo url_for( '@structure_child_edit?id=' . $sf_request->getParameter('nodeid'), true);?>" onclick="javascript:return false;">
			<img style="position:absolute;padding-top:5px;"  alt="" src="img/admin/edit.png" style="padding-bottom: 5px;" />
			<span><?php echo __("Settings") ?></span>
		</a>
		</li>
    </ul>
    
</div>



