<form id="order_form" action="<?php include_component('linker','basket', array('action' => 'orderSubmit','orderID' => $sf_request->getParameter('orderID') ) )?>">
<?php echo $form->renderHiddenFields(true)?>
<div class="smallboxesleft">
	<?php include_partial('basketPage/billingForm', array('form'=> $form['billing']))?>
	<div class="smallboxesbottom">
		<?php include_partial('basketPage/shippingForm', array('orderingForm' => $form, 'addresses' => $form->getShippingAddressesForms(), 'shippingZones' => $shippingZones, 'shops' => $shops ))?>
	<div class="clear"></div>
	</div>
</div>


<div class="smallboxesright">
	<div class="box">

		<?php include_partial('basketPage/totalsForm', array('form'=> $form,															
															'priceTotalPayable' => $priceTotalPayable,
															'priceShipping' => $priceShipping,
															'priceBasketTotal' => $priceBasketTotal))?>	
		<div class="clear"></div>
		
		<?php include_partial('basketPage/paymentMethods', array('form' => $form))?>
		<div class="clear"></div>
		
		<?php include_partial('basketPage/termsAndConds', array('form' => $form, 'termsAndConditionsNode' => $termsAndConditionsNode))?>
		<div class="clear"></div>
		
		<?php include_partial('basketPage/orderSubmit', array('form' => $form))?>
		 
	</div>
</div>
<div class="clear"></div>



</form>
<script type="text/javascript">$('.smallboxesleft input').clearInputDescription();</script>