<form method="post" action="<?php echo url_for( '@structure_page?action=commonRights' )?>" id="formRights">
					<?php foreach( $resultArray as $nodeID => $nodeArray ):?>
						<fieldset style="margin-bottom: 10px;">
							<legend class="formLabel"><?php echo $nodeArray['node_title']?></legend>
							<!-- to make it scroll add padding: 5px; background: rgb(255, 255, 255) none repeat scroll 0% 0%; overflow: auto; height: 80px -->
							<div style="padding: 5px; background: rgb(255, 255, 255) none repeat scroll 0% 0%; overflow: auto; ">
								<table cellspacing="0" cellpadding="4" style="width: 100%;">
										<tbody>
										<?php foreach( $nodeArray['user_groups'] as $groupID => $groupArray ):?>
										<tr>
											<td width="150" class="formLabel"><?php echo $groupArray['group_title'] ?></td>
											<td>&nbsp;</td>
											<?php foreach( array( __('Reading') => myUser::PERM_READ, __('Reading and writing') => myUser::PERM_RW, __('Reading, writing and deleting') => myUser::PERM_RWD, __('Denied') => myUser::PERM_DENY ) as $desc => $val ):?>
												<td><input type="radio" <?php if( $groupArray['permission'] == $val && $groupArray['not_inherited'] )echo 'checked'?> name="struct[<?php echo $nodeID?>][<?php echo $groupID?>]" value="<?php echo $val?>" class="formRadio"></td>
												<td class="formLabel">
												<?php if( !$groupArray['not_inherited'] && $groupArray['permission'] == $val):?>
													<b><?php echo $desc?></b>
												<?php else:?>
													<?php echo $desc?>
												<?php endif;?>
												</td>
											<?php endforeach;?>
											<td>
											<?php if( !$groupArray['not_inherited'] ):?>
											<input type="radio" checked name="struct[<?php echo $nodeID?>][<?php echo $groupID?>]" value="<?php echo myUser::PERM_INH?>" class="formRadio">
											<?php else:?>
											<input type="radio"  name="struct[<?php echo $nodeID?>][<?php echo $groupID?>]" value="<?php echo myUser::PERM_INH?>" class="formRadio">
											<?php endif;?>
											</td>
											<td class="formLabel">
												<?php echo __('Inherited');?>
											</td>
										</tr>
										
										
										
										<?php endforeach;?>
									</tbody>
							</table>
							</div>
						</fieldset>
					<?php endforeach;?>	
					
						<div>
							<input type="submit" name="submit" value="<?php echo __('Save')?>" class="formSubmit">
						</div>
</form>