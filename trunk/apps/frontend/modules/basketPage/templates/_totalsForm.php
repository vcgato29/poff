<div class="totalprice">
		<div class="totalpriceleft">
			<h2><?php echo __('Basket total')?></h2>
			<h2><?php echo __('Shipping')?></h2>
			<h1><?php echo __('Total payable')?></h1>
			<h2><?php echo __('Selected payment')?></h2>
		</div>
         <div class="totalpriceright">
			<h4><?php echo price_format($priceBasketTotal)?></h4>
			<h4><span id="shipping_price">-</span></h4>
			<h5><span id="total_payable"><?php echo price_format($priceBasketTotal)?></span></h5>
			<h3 id="selected_payment"><span></span><?php echo $form['payment_type']->render()?></h3>
         </div>
</div>