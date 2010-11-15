<?php foreach($pager->getResults() as $product):?>
<?php $link = get_component('linker','product', array('product' => $product, 'category' => $category ) )?>
<div class="textboxproduct product">
    <div class="left">																																			
	   <a href="<?php echo $link ?>"><img height="182" width="198" alt="" src="<?php echo @myPicture::getInstance( $product['ProductPictures'][0]['file'] )->thumbnail(199,182,'center')->url()?>"></a>
	</div>
	<div class="right">
	    <div class="top">
		    <div class="leftt">
			    <h1><a href="<?php echo $link?>"><?php echo $product['name']?></a></h1>
			</div>
		</div>
		 <div class="maht"><p>&nbsp;<?php echo $product['volume']?></p></div>
		<div class="center">
		    <p><?php echo truncate($product['description'],300)?></p>
			<h2><?php echo price_format($product['price_actual'], $sf_user)?></h2>
			<div class="centerbottom">
			    <div class="moreinfo">
			        <div class="arrow"><img height="7" width="4" alt="" src="/faye/img/arrow.png" /></div>
			        <div class="infolink"><a href="<?php echo $link?>"><?php echo __('More info')?></a></div>
			    </div>
				<div class="rightbutton">
					<div class="alertnormal"></div>
				    <div class="addbutton lisabutton">
				    	<a href="<?php include_component('linker', 'basket', array('action' => 'addProductToBasket','productID' => $product['id']))?>"><?php echo __('Add to cart')?></a>
				    </div>
				    <img style="display:none" class="addbuttonloader" alt="" src="/faye/ajax-loader.gif" />
				</div>
			</div>
		</div>
	</div>
	<div class="clear"></div>
</div>
<?php endforeach;?>

<script type="text/javascript">
$(document).ready(function(){
	$('.rightbutton').addProductToBasket();
});
</script>