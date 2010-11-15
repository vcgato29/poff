<?php 
/*
 * @signInForm
 * @products
 * @subtotalPrice
 */ 
?>
<?php slot('maincontent')?>

<?php include_partial('basketPage/leftmenu', array('controller' => $controller))?>

<div class="maincontent">

<?php include_component('headerMenu', 'breadCrumbs')?>
<div class="clear"></div>
					
<div class="basketsisu">

	
	<?php include_partial('basketPage/basketContent', array('products' => $products, 'immutable' => true))?>

	<?php include_partial('basketPage/orderingForm', array( 'form' => $orderingForm, 
															'shippingZones' => $shippingZones, 
															'shops' => $shops,
															'priceTotalPayable' => $priceTotalPayable,
															'priceShipping' => $priceShipping,
															'priceBasketTotal' => $priceBasketTotal,
															'termsAndConditionsNode' => $termsAndConditionsNode))?>


	<div class="clear"></div>
</div>

</div>
<?php end_slot()?>