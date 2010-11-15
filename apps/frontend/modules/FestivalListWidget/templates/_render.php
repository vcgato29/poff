<?php slot('FestivalListWidget') ?>
<div class="linklist">
            <ul>
<?php $count = 0; ?>
<?php foreach($nodes as $node): ?>
	<?php if(!$node['isHidden']): ?>
	<?php $count++; ?>
	<?php endif; ?>
<?php endforeach; ?>

<?php $i = 0; ?>
<?php foreach($nodes as $node): ?>
	<?php if(!$node['isHidden']): ?>
		<?php
			$active = ( $node['id'] == $curNode['id'] || $node->isChildrenOf( $curNode ) );
			$i++;
		?>
	   <li <?php if($i==1): ?>class="selected"<?php endif; ?>><a href="<?php echo $node['slug'] ?>" target="_blank"><?php echo $node['title'] ?></a></li>
      <?php if($i!=$count): ?><li><img src="/img/whitesquare.png" alt="" title="" /></li><?php endif; ?>
	<?php endif; ?>
<?php endforeach; ?>
  </ul>
</div>
<?php end_slot() ?>