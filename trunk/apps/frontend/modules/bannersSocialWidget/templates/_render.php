<?php slot('bannersSocialWidget') ?>
	<?php foreach($banners as $banner): ?>
	        <li><a href="<?php echo $banner['link'] ?>" target="_blank"><img alt="" src="<?php echo @myPicture::getInstance( $banner->getPicture() )->resize(24, 24,true,ture)->url()  ?>" /></a></li>
	<?php endforeach; ?>
<?php end_slot() ?>