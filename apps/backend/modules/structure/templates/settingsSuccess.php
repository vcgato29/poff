
<div id="rightbox"> 
 <div id="structure_tabs">
    <ul class="tabs"  style="z-index:0">
        <li class=""><a class="button delete_tab tab_link" id="addlang_tab" href="<?php echo url_for( '@structure_page?action=addLanguage' )?>" onclick="javascript:return false;" rel="add_tab"><span><?php echo __('Add')?></span></a></li>
        <li class=""><a class="button delete_tab tab_link common_action_tab" id="rights_tab" href="<?php echo url_for( '@structure_page?action=commonRights' )?>::100::100::1" onclick="javascript:return false;" rel="rights_tab"><span><?php echo __('Rights')?></span></a></li>
        <li class=""><a class="button delete_tab tab_link struct_layout" id="rights_tab" href="<?php echo url_for( '@structure_page?action=editLayout&id=1')?>" onclick="javascript:return false;" rel="rights_tab"><span><?php echo __('Default layout')?></span></a></li>
        <li class=""><a class="button delete_tab tab_link struct_layout" id="rights_tab" href="<?php echo url_for( '@structure_page?action=commonRights&struct[]=1')?>" onclick="javascript:return false;" rel="rights_tab"><span><?php echo __('Default rights')?></span></a></li>
    </ul>

    <div class="tab-content" id="add_tab">
        <div class="structure_elements_acc">
        <div class="clear"></div>
        
        <form name="structureform">
        
        <?php foreach( $languageList as $index => $lang ):?>
		<!-- structure node start -->
        <div class="item_row_header_up"></div>
        <div class="item_row_header">
            <table>
                <tr>
                    <td style="width:5%">
                        <input class="structcheck" id="node_<?php echo $index?>" name="structs" value="<?php echo $lang['id']?>" type="checkbox" />
                    </td>
                    <td>
                      <table>
                      <tr>
                        <td width="18%" style="cursor:hand;cursor:pointer;">
        					<?php echo link_to($lang['title'], '@structure_page?action=index&nodeid='.$lang['id']  ) ?>
        				</td>
                        <td width="15%" style="cursor:hand;cursor:pointer;"><div class="structure_lang_icon"><?php echo __('language')?></div>
                        </td>
						<td width="10%" style="cursor:hand;cursor:pointer;"><?php echo $lang['created_at']?></td>
                        <td width="10%" style="cursor:hand;cursor:pointer;"><?php echo isset( $lang['created_by_user']['username'] ) ? $lang['created_by_user']['username'] : '-' ?></td>
                        
						<td width="10%" style="cursor:hand;cursor:pointer;"><?php echo $lang['updated_at']?></td>
                        <td width="10%" style="cursor:hand;cursor:pointer;"><?php echo isset( $lang['updated_by_user']['username'] ) ? $lang['updated_by_user']['username'] : '-' ?></td>
                        
                        
                        <td width="15%">
                          <div class="order_down">
                          	<a href="<?php echo url_for( '@structure_page?action=order&order=down&nodeid='.$lang['id'] )?>"><img src="img/admin/down.png" alt="down"/></a>                             
                          </div>
                          <div class="order_up">
                            <a href="<?php echo url_for( '@structure_page?action=order&order=up&nodeid='.$lang['id'] )?>"><img src="img/admin/up.png" alt="up"/></a>
                          </div>
                        </td>
                      </tr></table>
                     </td>
                     <td style="width:4%" class="icons">
                     	<?php if( !$lang['inherits_layout'] ):?>
                     		<a class="struct_layout" id="struct_layout_<?php echo $lang->id?>" onclick="javascript:return false;" href="<?php echo url_for( '@structure_page?action=editLayout&id='.$lang['id'])?>" onclick=""><img style="padding-bottom:5px"  width="30" src="img/admin/module.png" alt="" /></a>
                     	<?php endif;?>
                     </td>
                    <td style="width:4%" class="icons">
                    	<a id="" class="struct_node" onclick="javascript:return false;" href="<?php echo url_for( '@structure_child_edit?id='.$lang['id'], true);?>">
                    		<img src="img/admin/edit.png" alt="" />
                    	</a>
					</td>
					
                    <td style="width:4%" class="icons"><a class="delete_structure_item_2" href="<?php echo url_for('@structure_child_delete?id='.$lang['id'])?>" onclick="if(!confirm('<?php echo __('Are you sure ?')?>')) return false;"><img src="img/admin/delete.png" alt="" /></a></td>
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

