<?php slot('bannerLogo')?>
<?php foreach($logos as $index => $logo): ?><?php if($banner['type']=="flash"): ?>
	<div id="flashbanner_logo">
	</div>

	<script type="text/javascript">
	   var so = new SWFObject("/uploads<?php echo $banner['file']; ?>", "mymovie", "<?php echo $banner['width']; ?>", "<?php echo $banner['height']; ?>", "8", "#FFFFFF");
	   so.write("flashbanner_logo");
	</script>
	 <?php else: ?>
    <a href="<?php echo $logo['link'] ?>"><img src="<?php echo @myPicture::getInstance( $logo->getPicture() )->thumbnail(262,135,'center')->url()?>" alt="" /></a>   <?php endif; ?>
<?php endforeach; ?>

<?php end_slot()?>