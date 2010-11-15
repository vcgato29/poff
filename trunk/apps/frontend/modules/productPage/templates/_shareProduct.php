<div class="share">
<a rel="mail_link" class="smallpic" title="1" id="small1"  href="<?php include_component('linker', 'product', array('product' => $product, 'category' => $category, 'action' => 'productSuggestionIndex'))?>"><img  height="20" class="leftimg" width="23" src="/faye/img/mail.png" onmouseover="showbig('big1')";></a>
<?php foreach($iconBanners as $index => $banner):?>
<?php 
$link = $banner['link'];
if(strpos($link, '%cururl%') !== false){
	$link = str_replace('%cururl%', get_component('linker', 'product', array('product' => $product, 'category' => $category, 'full' => true)), $link);
}
?>

<a title="<?php echo $index+2?>" class="smallpic" id="small<?php echo $index+2?>" href="<?php echo $link ?>"><img height="20" width="23" src="<?php echo @myPicture::getInstance($banner->getPicture())->thumbnail(23,20,'center')->url()?>" class="rightimg"></a>
<?php endforeach;?>
	<div class="sharelinkbox">
		<div class="arrow"><img src="/faye/img/arrow.png" width="4" height="7" alt=""/></div>
		<div class="sharelink"><a href="#"><?php echo __('Share this Product')?></a></div>
	</div>
	<div class="clear"></div>
	
	<div class="hiddensharebox">
		<div class="sharebig">
		<img  height="27" class="imgbig big1" title="1" id="big1" width="30" src="/faye/img/mail.png";>
		<?php foreach($iconBanners as $index => $banner):?>
		<img class="imgbig big<?php echo $index + 2?>" title="<?php echo $index+2?>" id="big<?php echo $index + 2?>" height="27" width="30" src="<?php echo @myPicture::getInstance($banner->getPicture())->thumbnail(30,27,'center')->url()?>">
		<?php endforeach;?>
             </div>   
	</div>
</div>

<script type="text/javascript">
$('.imgbig').click(function(e){
	var link = $('#small'+$(this).attr('title'));

	if(link.attr('rel') == 'mail_link'){ // if we clicked on mail icon
		link.trigger('click');
	}
	else
		window.location = link.attr('href');
	
	return false;
});


$('.smallpic').mouseover(function(){
	$('.imgbig').hide();
	showbig('big' + $(this).attr('title'));
	
	
});

</script>

