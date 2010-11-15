<?php if( isset($products) && $products->count() ):?>
<div class="searchcontentbox" id="searchcontent">
<div class="searchcontent">
    <?php foreach( $products as $product ):?>
    <?php 
    	$link = get_component('linker', 'product', array('product' => $product) );
    	$pic = myPicture::getInstance($product['ProductPictures'][0]['file'])->thumbnail(58,53, 'center')->url(true);
    ?>
        <div class="result">
	    <div class="resimg"><img height="53" width="58" alt="" src="<?php echo $pic?>"></div>
		<div class="restext">
		    <div class="tootename"><a href="<?php echo $link?>"><?php if(strlen($product['name']) > 25):?>
		    									<?php echo truncate($product['name'], 25)?>
		    								  <?php else:?>
		    								  	<?php echo $product['name'] ?>
		    								  <?php endif;?></a></div>
			<div class="maht"><p>&nbsp;<?php echo $product['volume']?></p></div>
			<div class="hind"><p><?php echo price_format($product['price_actual'])?></p></div>
			<div class="clear"></div>
			<div class="basketarrow"><img height="7" width="4" alt="" src="/faye/img/arrow.png"></div>
			<div class="basketadd"><a href="<?php echo $link?>"><?php echo __('More info')?></a></div>
		</div>
		<div class="clear"></div>
	</div>
	<div class="clear"></div>
	<?php endforeach;?>
</div>
</div>
<?php endif;?>