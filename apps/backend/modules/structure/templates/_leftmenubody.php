
<div class="menu_body">
	<?php if( isset( $structureMenu ) && !empty( $structureMenu ) ):?>
        <?php foreach( $structureMenu as $struct ):?>
           <div class="menu_body_item">
            	<a id="structure_2_menu_item" href="<?php echo url_for( '@structure_page?action=index&nodeid=' . $struct['id'])?>" class="menu_link menu_folder">
            <?php if( isset( $selectedNodes ) && in_array($struct['id'], $selectedNodes) ):?>	
        		<b><?php echo $struct['title']?></b>
        	<?php else:?>
        		<?php echo $struct['title']?>
        	<?php endif;?>
        	</a>	
            </div>
            <?php if( isset( $struct['childs']) && !empty( $struct['childs'] ) ):?>
				<?php include_partial('structure/leftmenubody',
					array('structureMenu' => $struct['childs'], 'selectedNodes' => $selectedNodes)
				) ?>
            <?php endif;?>
        <?php endforeach;?>
   <?php endif;?>
</div>