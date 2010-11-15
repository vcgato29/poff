  
    
<div id="leftbox">
<div class="menu">
      <div class="menu_up"></div>
      <div class="menu_list">
      <div class="menu_body_item">
        <a class="menu_link menu_head menu_attitude" href="<?php echo url_for( '@structure_page?action=settings' )?>" id="structure_menu_item">
        	<?php if( $nodeID == 1 ):?>
        		<b><?php echo __("Structure")?></b>
        		<?php else:?>
					<?php echo __("Structure")?>
			<?php endif;?>
        </a>
      </div>  
      <div class="menu_body" style="display:block">
	      <div class="blockline3"></div>
	    
	    	
	    	<?php foreach( $languages as $language ):?>        		
        		<?php if( $language->url == $selectedLanguage ):?>
	    			<div class="menu_body_item">
	            		<a class="menu_link menu_language" href="<?php echo url_for( "@structure_page?action=index&nodeid=".$language['id'] )?>" id="structure_et_menu_item"><b><?php echo $language->title?></b></a>
	        		</div>
        			<?php include_component( 'structure', 'leftmenubody', array( 'nodeID' => $nodeID ) ) ?>
        		<?php else: ?>
	    			<div class="menu_body_item">
	            		<a class="menu_link menu_language" href="<?php echo url_for( "@structure_page?action=index&nodeid=".$language['id'] )?>" id="structure_et_menu_item"><?php echo $language->title?></a>
	        		</div>
        		<?php endif?>
	    	<?php endforeach;?>

	        
      </div>
      </div>
      <div class="menu_down"></div>
     
</div>

<?php include_component( 'structure', 'backendModulesBox' ) ?>

<?php include_component( 'settings', 'settingsBox' ) ?>

</div>
        
