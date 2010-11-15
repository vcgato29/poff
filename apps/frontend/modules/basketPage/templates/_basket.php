<div class="topmenulink basketbutton">
	<p><img src="/faye/img/basket.png" width="15" height="11" alt=""/></p>
	<p class="inter"><a href="#"><?php echo __('Basket')?> (<?php echo $totalItems?>)</a></p>
</div>
<div class="clear"></div>

<div  class="basketbox" id="basket" >

<div class="basketcontent">

<div class="baskettop">
<div class="korv basketbutton">
	<img height="11" width="15" alt="" src="/faye/img/basket.png">
	<p><a href="#"><?php echo __('Basket')?> (<?php echo $totalItems?>)</a></p>
</div>
<div class="summa">
	<p><?php echo price_format($totalPrice)?></p>
	<img height="16" width="15" alt="" src="/faye/img/abutton.png">
</div>
</div>

<div class="clear"></div>
<div class="basketbottom">
<div class="baskettopbg"></div>
<div class="mainbasket">
    
<?php if($itemsInBasket):?>
<?php foreach($itemsInBasket as $item):?>
<div class="box">
<!-- <div class="thumb"><img height="53" width="58" alt="" src="/faye/img/basket/1.jpg"></div> -->
<div class="productname"><a href="<?php include_component('linker', 'product', array('product' => $item['product']))?>"><?php echo $item['product']['name']?></a></div>
<div class="productprice">
<div class="top"><?php echo __('Price')?></div>
<div class="bottom"><?php echo price_format($item['product']['price_actual'])?></div>
</div>
<div class="qty">
<div class="top"><?php echo __('Qty')?></div>
<div class="bottom"><?php echo $item['quanity']?></div>
</div>
<div class="total">
<div class="top"><?php echo __('Total')?></div>
<div class="bottom"><?php echo price_format($item['quanity'] * $item['product']['price_actual'])?></div>
</div>
<div class="remove">
<a href="<?php include_component('linker', 'basket', array('action' => 'deleteFromBasket','productID' => $item['product']['id']))?>"></a>
<div class="top"><?php echo __('Remove')?></div>
<div class="bottomcontainer"><div class="bottom"></div></div>
</div>
<div class="product_id" style="display:none"><?php echo $item['product']['id']?></div>
<div class="clear"></div>
</div>
<?php endforeach;?>

<div class="viewbasket">
<a href="<?php include_component('linker', 'basket', array('action' => 'index' ) )?>"><?php echo __('View basket')?></a>
</div>
<?php else:?>
<div class="productname" style="width:inherit;text-align:center;float:none;">
	<a><?php echo __('Basket is empty')?></a>
</div>
<?php endif;?>

<div class="clear"></div>

</div>

<div class="basketbottombg"></div>

</div>

</div>

</div>