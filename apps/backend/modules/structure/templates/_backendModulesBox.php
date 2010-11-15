
<div class="menu">
      <div class="menu_up"></div>
      <div class="menu_list">
      <div class="menu_body_item">
        <a class="menu_link menu_head menu_attitude" href="#" onclick="javascript:return false;" ><?php echo __('Modules')?></a>
      </div>  


				<div class="menu_body" style="display: block;">
				      <div class="blockline3"></div>
				    

	
	 			<?php foreach( $backendModules as $module => $modulesArray ):?>
	 				<?php if( !empty( $modulesArray['submodules'] ) ):?>
						<div class="menu_body_item">
				            <a href="#<?php echo $module?>"  class="menu_link menu_settings uber-puper">
				            	<?php if( @$modulesArray['selected'] ):?>
				            		<b><?php echo $module?></b>
				            	<?php else:?>
				            		<?php echo $module?>
				            	<?php endif;?>
				            </a>
				        </div>
				        	 			 
				    <div class="menu_body" id="<?php echo $module?>" style="display: <?php if( @$modulesArray['selected'] ):?>block<?php else:?>none<?php endif;?>;">
	 				<?php foreach( $modulesArray['submodules'] as $moduleInfo ):?>
	 					    <div class="menu_body_item">
								<?php if($sf_user->hasCredential( $moduleInfo['id'] )):?>
						 				<a class="menu_link menu_settings" href="<?php echo url_for( '@admin_page?module='.$moduleInfo['module_name'] . '&action=' . $moduleInfo['action'] . '&nodeid=' . $nodeID, true )?>" id="structure_et_menu_item">
						 				<?php if( $moduleInfo['module_name'] == $sf_request->getParameter('module') ): ?> 
						 					<b><?php echo $moduleInfo['title']?></b>
						 				<?php else:?>
						 					<?php echo $moduleInfo['title']?>
						 				<?php endif;?>
						 				</a>
						 		<?php endif;?>				 	
					 		</div>
					 		<div class="menu_body"></div>
	 				<?php endforeach;?>
	 				</div>
	 				
	 				<?php endif;?>
	 			<?php endforeach;?>
				

				        
				        
				     
				
				     
				      
				</div>

      </div>
      <div class="menu_down"></div>
     
</div>
