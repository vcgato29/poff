<table cellspacing="0" cellpadding="0" border="0" width="100%">
	<tbody>
		<?php foreach( $productGroups as $index => $group ):?>
			<tr height="20" onmouseout="this.style.background='';" onmouseover="this.style.background='#c1c1c1';" style="">
			    <td width="4%">
					<div style="white-space: nowrap;">
						<?php if( $index > 0 ):?>
						<a href="<?php echo url_for("@admin_page?module=product_group&action=order&order=up&id=" . $group['id'])?>">
							<img  onmouseout="this.style.border='2px solid transparent';" onmouseover="this.style.border='2px solid #a0a0a0'" style="border: 2px solid transparent; cursor: pointer;" alt="Down" src="/img/admin/sort_up.gif">
						</a>
						<?php endif;?>
						<?php if( $index < count($productGroups) - 1 ):?>
						<a href="<?php echo url_for("@admin_page?module=product_group&action=order&order=down&id=" . $group['id'])?>">
							<img  onmouseout="this.style.border='2px solid transparent';" onmouseover="this.style.border='2px solid #a0a0a0'" style="border: 2px solid transparent; cursor: pointer;" alt="Up" src="/img/admin/sort_down.gif">&nbsp;
						</a>
						<?php endif;?>						
					</div>
			    </td>
			    <td width="96%">
			    	<?php if($group['title'] != 'root'): ?>
			    	<a  class="struct_node" onclick="javascript:return false;"  href="<?php echo url_for('@admin_page?module=product_group&action=edit&id=' . $group['id'])?>"><?php echo $group['title']?></a>&nbsp;&nbsp;&nbsp;

					<a style="padding-left:20px" href="<?php echo url_for('@admin_page?module=product_group&action=toggleGroup&group_id='.$group['id'])?>">
						<?php if( count( $group['__children'] ) ):?>
							<img border="0" alt="" style="cursor: pointer;" src="<?php if( !in_array( $group['id'], $selectedGroups ) ): ?>/img/admin/opncls_closed.gif<?php else:?>/img/admin/opncls_opened.gif<?php endif;?>">
						<?php else:?>
						<img border="" src="/img/admin/spacer.gif" width="9px" height="21px" />
						<?php endif;?>
						
					</a>

			    	<a style="float:right;padding:5px" onclick="if(!confirm('<?php echo __('Are you sure ?')?>')) return false;"  href="<?php echo url_for('@admin_page?module=product_group&action=delete&id='.$group['id'])?>"><img width="10px"  alt="" src="img/admin/delete.png"></a>&nbsp;&nbsp;&nbsp;
			    	<?php endif;?>
			    	<a style="float:right"  class="struct_node" href="<?php echo url_for('@admin_page?module=product_group&action=new&parent_id='.$group['id'])?>" onclick="javascript:return false;"><img border="0" alt="" style="cursor: pointer;" src="/img/admin/add.gif"></a>&nbsp;&nbsp;&nbsp;
			    	
			    </td>

			    
			</tr>
          <tr>
	        <td></td>
		        <td>
		        <?php if(  isset( $group['__children'] ) && !empty( $group['__children'] )  &&  ( in_array( $group['id'], $selectedGroups ) || $group['level'] == 0  ) ):?>
		        	<?php include_partial('product_group/treeComponent', array('productGroups' => $group['__children'], 'selectedGroups' => $selectedGroups))?>
				<?php endif;?>
				</td>
		   </tr>
		   <?php endforeach;?>
	</tbody>
</table>