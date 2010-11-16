<?php slot('hooaeg') ?>

<div class="wp_season"><?php echo __('Hooaeg') ?>:
	<?php foreach($hooajad as $index => $hooaeg): ?>
		<?php if(isset($hooaeg['node']) && $hooaeg['node'] instanceof Structure): ?>
			<a <?php if($node['id'] == $hooaeg['id']): ?>class="active" style="color:<?php echo CustomizationHelper::getInstance()->dark($section) ?>;"<?php endif; ?>  href="<?php include_component('linker', 'articleLinkBuilder', array('node' => $hooaeg['node'])) ?>">
			<?php echo $hooaeg['title'] ?></a> <?php if($index + 1 != count($hooajad)): ?>|<?php endif; ?>
		<?php endif; ?>
	<?php endforeach; ?>
</div>
<?php end_slot() ?>