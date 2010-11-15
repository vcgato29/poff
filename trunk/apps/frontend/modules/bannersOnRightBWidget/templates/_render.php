<?php slot('bannersOnRightBWidget') ?>
	<?php foreach($banners as $banner): ?>
	        <?php echo $banner['content'] ?>
	<?php endforeach; ?>
<?php end_slot() ?>