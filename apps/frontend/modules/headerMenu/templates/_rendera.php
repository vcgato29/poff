<?php foreach($nodes as $node): ?>
	<?php if(!$node['isHidden']): ?>
		<?php
			$active = ( $node['id'] == $curNode['id'] || $node->isChildrenOf( $curNode ) );
		?>
    <li><a href="<?php echo $node['slug'] ?>"><?php echo $node['title'] ?></a></li>
	<?php endif; ?>
<?php endforeach; ?>