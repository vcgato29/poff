<?php 
$form_transport = $orderingForm['shipping_transport'];
$form_shop = $orderingForm['shipping_shop'];
?>
<div class="shipping">
    <h1><?php echo __('Shipping')?></h1>
    
    <div class="container">
    <!-- shipping TYPE selection RADIO button -->
    <div class="shipselect checkboxactive">
    	<input type="hidden" name="type" value="shipping" />
    	<input type="hidden" name="value"  value="" />
    </div>
	<?php include_partial('basketPage/shippingFormTransport', array('addresses' => $addresses, 'form_transport' => $form_transport, 'shippingZones' => $shippingZones))?>
	</div>
	
	<div class="container">
	<!-- shipping TYPE selection RADIO button -->
	<div class="shipselect checkbox">
		<input type="hidden" name="type" value="shop" />
		<input type="hidden" name="value" value="0" />
	</div>
	<?php include_partial('basketPage/shippingFormShop', array('shops' => $shops, 'form_shop' => $form_shop))?>
	</div>
		
	<!-- selected shipping -->
	<div id="selected_shipping"><?php echo $orderingForm['shipping_type']->render(array('value' => 'shipping'))?></div>
	
<script type="text/javascript">
$('.shipselect').click(function(e){
	var value = $('input[name=value]', this).val();
	var type = $('input[name=type]',this).val();

	shippingZoneChanged(value);
	$('#selected_shipping input').val(type);
	
	$('.shipselect').removeClass('checkboxactive');
	$('.shipselect').addClass('checkbox');
	$(this).removeClass('checkbox');
	$(this).addClass('checkboxactive');

	// IE6 hacking
	$('.shipselect').each(function(){
		$(this).css('background-url', 'url("img/unchecked.png") no-repeat scroll 0 0 transparent');
	});
	if($(this).hasClass('checkboxactive')){
		$(this).css('background-url', 'url("img/checked.png") no-repeat scroll 0 0 transparent');
	}
});
</script>
</div>

<script type="text/javascript">
function shippingZoneChanged(zone){

	var zoneID = zone === '0' ? 0 : $('#selected_shipping_zone input').val();
	
	if(zoneID === '')return;
	
	$.post($('#change_shipping_zone_link').attr('href'), {zoneID: zoneID} , function(data){
		$('#shipping_price').html(data.shipping);
		$('#total_payable').html(data.total);
	},'json');
}
</script>