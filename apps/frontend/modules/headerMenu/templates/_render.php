<?php foreach($nodes as $node): ?>
	<?php if(!$node['isHidden']): ?>
		<?php
			$active = ( $node['id'] == $curNode['id'] || $node->isChildrenOf( $curNode ) );
		?>

    <li class="level-0 <?php if($active): ?>selected<?php endif?>"><a href="<?php include_component('linker', 'articleLinkBuilder', array( 'params' => array( 'p0' => $node['lang'], 'p1' => $node['slug'] )) )?>"><?php echo $node['title'] ?></a></li>
	    <?php if($active): ?>
        	<?php foreach($node['__children'] as $subnode): ?>
        		<?php if(!$subnode['isHidden']): ?>
        			<?php
						$active2 = ( $subnode['id'] == $curNode['id'] );
					?>

        	   		<li class="level-1 <?php if($active2): ?>selected<?php endif; ?>"><a href="<?php include_component('linker', 'articleLinkBuilder', array( 'params' => array( 'p0' => $subnode['lang'], 'p1' => $node['slug'], 'p2' => $subnode['slug'] )) )?>"><span class="arrow">»</span> <?php echo $subnode['pageTitle'] ?> </a></li>
        	    <?php endif; ?>
        	<?php endforeach; ?>
	    <?php endif; ?>
	<?php endif; ?>
<?php endforeach; ?>