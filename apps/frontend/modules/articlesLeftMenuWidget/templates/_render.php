<?php slot('menu')?>
<div class="rightlinks">
	<?php if( isset($secondLevelMenuItems) ):?>
	<?php foreach($secondLevelMenuItems as $index => $node):?>

	<div class="menuItem" title="<?php echo $node['id'] ?>">
			<div class="rlink ractive" <?php if($helper->isActive($node, $activeNodes)): ?>style="display:none"<?php endif; ?>>
				<div class="linkbody <?php if($index + 1 == count($secondLevelMenuItems)): ?>last<?php endif; ?>">
					<div class="linkarrow grey"></div>
					<div class="linkcontent bold">
						<a href="<?php echo $node['link'] ?>"><?php echo $node['title'] ?></a>
					</div>
					<div class="clear"></div>
				</div>
			</div>
			<div class="rlinksub" style="<?php if(!$helper->isActive($node, $activeNodes)): ?>display:none<?php endif; ?>">
				<div class="linkbodysub">
					<div class="linkarrow blue"></div>
					<div class="linkcontentactive">
						<a href="<?php echo $node['link'] ?>"><?php echo $node['title'] ?></a>
						<div class="clear"></div>
					</div>
					<div class="clear"></div>
					<div class="menudown">
						<ul>
							<?php foreach($node['__children'] as $child): ?>
								<?php if($helper->isActive($child, $activeNodes)): ?>
									<li>
										<div class="downactive"></div>
										<div class="ldownactive">
											<a href="<?php echo $child['link'] ?>"><?php echo $child['title'] ?></a>
										</div>
										<div class="clear"></div>
									</li>
								<?php else: ?>
									<li onmouseover="linkover('sublink2')">
										<div id="sublink2" class="linkarrowdown"></div>
										<div class="ldown">
											<a href="<?php echo $child['link'] ?>"><?php echo $child['title'] ?></a>
										</div>
										<div class="clear"></div>
									</li>
								<?php endif; ?>
							<?php endforeach; ?>
						</ul>
					</div>
				</div>
			</div>
	</div>
	<?php endforeach;?>
	<?php endif;?>
</div>
<?php end_slot()?>