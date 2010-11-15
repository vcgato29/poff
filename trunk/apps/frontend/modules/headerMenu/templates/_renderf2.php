<?php $i = 0; ?>
<?php foreach($nodes as $node): ?>
	<?php if(!$node['isHidden']): ?>
		<?php
			$active = ( $node['id'] == $curNode['id'] || $node->isChildrenOf( $curNode ) );
			$i++;
		?>
	   <li <?php if($i==1): ?>class="selected"<?php endif; ?>><a href="<?php echo $node['slug'] ?>" target="_blank"><?php echo $node['title'] ?></a></li>
      <li><img src="/img/whitesquare.png" alt="" title="" /></li>
	<?php endif; ?>
<?php endforeach; ?>