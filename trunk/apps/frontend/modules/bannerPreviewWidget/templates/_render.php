<?php slot('bannerPreviewWidget')?>
<div class="clear"></div>
<div class="bottomthumbs">

<div style="width:<?php echo count($banners) * 170 ?>px;margin:auto;"> <!-- 160px * 4 -->
	
<?php foreach($banners as $index => $banner):?>
<div class="hiddenthumb">
    <div class="back" id="rek<?php echo $index?>">
	    <div class="thumb">
	        <img src="/faye/img/thumbbg.png" width="145" height="145" alt=""/>
			<p><?php echo $banner['name']?></p>
		</div>
	</div>
	<div class="front">
	    <div class="thumb">
		   <a href="<?php echo $banner['link']?>"> <img id="img<?php echo $index?>" src="<?php echo @myPicture::getInstance($banner->getPicture())->thumbnail(102,86,'center')->url()?>" width="102" height="86" alt="" onmouseover="showthumb('rek<?php echo $index?>','img<?php echo $index?>')" /></a>
		</div>
	</div>
</div>
<?php endforeach;?>
	
<div class="clear"></div>
</div>

</div>
<?php end_slot()?>