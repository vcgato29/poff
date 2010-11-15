<div class="breadcrumbs">
	<ul>
	<?php foreach($nodes as $index => $node):?>
		<?php if(!$node['isHidden']):?>
			<li><a href="<?php echo $node['link'] ?>"><?php echo $node['title'] ?></a></li>
			<?php if( count($nodes) != $index + 1 ):?>
				<li>/</li>
			<?php endif;?>
		<?php endif;?>
	<?php endforeach;?>
	</ul>
	<div class="clear"></div>
</div>

