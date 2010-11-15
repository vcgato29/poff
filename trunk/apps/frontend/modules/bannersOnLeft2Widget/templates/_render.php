<?php slot('bannersOnLeft2Widget') ?>
	<?php foreach($banners as $banner): ?>
	<?php if($banner['type']=="flash"): ?>
	<div id="flashbanner_left2_<?php echo $banner['id'] ?>">
	</div>
	<script type="text/javascript">
	   var so = new SWFObject("/uploads<?php echo $banner['file']; ?>", "mymovie", "<?php echo $banner['width']; ?>", "<?php echo $banner['height']; ?>", "8", "#FFFFFF");
	   so.addVariable("clickTAG", "<?php echo $banner['link'] ?>");
	   <?php $flashvars = explode("&", $banner['flash_vars']); ?>
	   <?php if(count($flashvars)>0 and $banner['flash_vars']!=""): ?>
	   <?php foreach($flashvars as $flashvar): ?>
	   <?php $aflashvar = explode("=", $flashvar); ?>
	   so.addVariable("<?php echo $aflashvar[0] ?>", "<?php echo $aflashvar[1] ?>");
	   <?php endforeach; ?>
	   <?php endif; ?>
	   so.write("flashbanner_left2_<?php echo $banner['id'] ?>");
	</script>
	 <?php else: ?>
	        <a href="<?php echo $banner['link'] ?>" target="_blank"><img alt="" src="<?php if($banner['type']=="gif"): ?>/uploads<?php echo $banner['file'];  ?><?php else: ?><?php echo @myPicture::getInstance( $banner->getPicture() )->resize(183, $banner['height'],true,ture)->url()  ?><?php endif; ?>" /></a>
	<?php endif; ?>
	<div class="boxseparator"></div>
	<?php endforeach; ?>
<?php end_slot() ?>