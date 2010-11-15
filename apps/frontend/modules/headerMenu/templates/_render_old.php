<a href="<?php include_component('linker', 'localizedHomepage')?>"><img src="/img/logo.png" alt="POFF" title="POFF" /></a>
<?php
		$index = 0; //initilize menu items counter

?>
<?php foreach($nodes as $node): ?>
	<?php if(!$node['isHidden']): ?>
		<?php
			$active = ( $node['id'] == $curNode['id'] || $node->isChildrenOf( $curNode ) );
		?>

<!--<div class="toplink link<?php echo $index + 1 ?>" onmouseover="active('link<?php echo $index +1 ?>','link<?php echo $index +1 ?>active')";>
	<div class="topnactive" id="link<?php echo $index +1 ?>">
		<div class="toplinkleft"><img src="/olly/img/nactiveleft<?php if(!$active)echo '2'  ?>.png" width="21" height="34" alt=""/></div>
		<div class="toplinkcenter<?php if($active): ?><?php echo 'main' ?><?php endif?>"><?php echo $node['title'] ?></div>
		<div class="toplinkright"><img src="/olly/img/nactiveright<?php if(!$active)echo '2'  ?>.png" width="27" height="34" alt=""/></div>
	</div>
	<div class="clear"></div>
	<div class="topactive" id="link<?php echo $index +1 ?>active">
		<div class="toplinkleft"><img src="/olly/img/activeleft<?php if($active)echo '2'  ?>.png" width="21" height="34" alt=""/></div>
			<div class="toplinkcenter tactive">
				<div class="activelinkcenter<?php if($active): ?><?php echo 'main' ?><?php endif?>"><a href="<?php include_component('linker', 'articleLinkBuilder', array( 'params' => array( 'p0' => $node['lang'], 'p1' => $node['slug'] )) )?>"><?php echo $node['title'] ?></a></div>
			</div>
		<div class="toplinkright"><img src="/olly/img/activeright.png" width="27" height="34" alt=""/></div>
		<div class="clear"></div>
	</div>
	<div class="clear"></div>
</div>-->

		<?php ++$index ?>
	<?php endif; ?>
<?php endforeach; ?>