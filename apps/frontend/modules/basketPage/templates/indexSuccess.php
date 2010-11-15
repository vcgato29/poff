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
					
			
<?php if($sf_user->hasFlash('basket.error')):?>
<div class="viga">
<p><?php echo $sf_user->getFlash('basket.error')?></p>
</div>
<?php endif;?>


<div class="basketsisu">
	<?php include_partial('basketPage/basketContent', array('products' => $products, 'continueShoppingNode' => $continueShoppingNode))?>
	<?php include_partial('basketPage/basketControls', array('products' => $products,'continueShoppingNode' => $continueShoppingNode))?>
	
	<div class="subtotal">
	    <p><?php echo __('Subtotal')?> <span id="subtotal_price"><?php echo price_format($subtotalPrice)?></span></p>
	</div>
	<div class="clear"></div>

	<?php if(!$sf_user->isAuthenticated()):?>
		<?php include_partial('basketPage/signin_register', array('form'=> $signInform))?>
	<?php endif;?>

	<div class="clear"></div>
</div>
<div class="clear"></div>

</div>
<?php end_slot()?>