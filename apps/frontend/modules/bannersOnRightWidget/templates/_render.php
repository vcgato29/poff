<?php slot('bannersOnRightWidget') ?>
	<?php foreach($banners as $banner): ?>

	<?php if($banner['type']=="flash"): ?>
	<div id="flashbanner_right">
	</div>

	<script type="text/javascript">
	   var so = new SWFObject("/uploads<?php echo $banner['file']; ?>", "mymovie", "<?php echo $banner['width']; ?>", "<?php echo $banner['height']; ?>", "8", "#FFFFFF");
	   so.write("flashbanner_right");
	</script>
	 <?php else: ?>
	        <a ref="<?php echo $banner['link'] ?>" target="_blank"><img alt="" src="<?php echo @myPicture::getInstance( $banner->getPicture() )->resize(183, $banner['height'],true,ture)->url()  ?>" /></a>
            <div class="boxseparator"></div>
    <?php endif; ?>
	<?php endforeach; ?>
<?php end_slot() ?>