<?php slot('ArchiveListWidget') ?>
<div class="dropdown">
            <div class="block_left"></div>
            <div class="block_content">
              <?php echo __('Arhiiv') ?>
              <div class="arrows"></div>
            </div>
            <div class="block_right"></div>
          </div>
          <div class="dropdown-selections">
            <div class="dp_top"></div>
            <div class="dp_center">
              <ul>
<?php foreach($nodes as $node): ?>
	<?php if(!$node['isHidden']): ?>
		<?php
			$active = ( $node['id'] == $curNode['id'] || $node->isChildrenOf( $curNode ) );
		?>
    <li><a href="<?php echo $node['slug'] ?>" target="_blank"><?php echo $node['title'] ?></a></li>
	<?php endif; ?>
<?php endforeach; ?>
              </ul>
            </div>
            <div class="dp_bottom"></div>
          </div>
<?php end_slot() ?>