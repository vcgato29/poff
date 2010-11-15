
<div class="menu_body">
	<?php if( isset( $structureMenu ) && !empty( $structureMenu ) ):?>
        <?php foreach( $structureMenu['childs'] as $struct ):?>
        	<?php if( in_array( $struct['id'], $ignoreNodeList ) ):?>
        		<?php continue;?>
        	<?php endif;?>
        	
           <div class="menu_body_item">
            <a  href="javascript:return false;" class="menu_link menu_folder">
				<span class="<?php if( $struct['permitted']) echo "node";else echo "node_restrited";?>" id="<?php echo $struct['id']?>"><?php echo $struct['title']?></span>
				
        	</a>	
            </div>
            <?php if( !in_array( $struct['id'], $ignoreNodeList ) && isset( $struct['childs']) && !empty( $struct['childs'] )  ):?>
				<?php include_partial('structure/openedNodesLedder',
					array('structureMenu' => $struct, 'ignoreNodeList' => $ignoreNodeList )
				) ?>
            <?php endif;?>
        <?php endforeach;?>
   <?php endif;?>
   
</div>