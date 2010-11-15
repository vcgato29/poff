<a id="first_product_image" title="<?php echo $pictures[0]['name']?>" href="<?php echo @myPicture::getInstance( $pictures[0]['file'] )->url()?>" rel="example_group">
	<img height="292" width="283" alt="" src="<?php echo @myPicture::getInstance( $pictures[0]['file'] )->thumbnail(283,292,'center')->url()?>">
</a>
<div class="enlarge">
	<a title="" id="click_to_enlarge">
		<img height="21" width="21" alt="" src="/faye/img/zoom.png">
		<?php echo __('Click to enlarge image')?>
	</a>    
	<div class="clear"></div>
</div>
    
<div class="smallgallery">
<ul>
    	<?php for($i = 1; $i < count($pictures); ++$i ):?>
	<li>
	    <a title="<?php echo $pictures[$i]['name']?>" href="<?php echo @myPicture::getInstance( $pictures[$i]['file'] )->url()?>" rel="example_group">
	    	<img height="127" width="139" alt="" src="<?php echo @myPicture::getInstance( $pictures[$i]['file'] )->thumbnail(139,127,'center')->url()?>">
	    </a>
	</li>
    	<?php endfor;?>
</ul>
</div>

<script type="text/javascript">
$('#click_to_enlarge').click(function(e){
	e.preventDefault();
	$('#first_product_image').trigger('click');
	return false;
});
</script>