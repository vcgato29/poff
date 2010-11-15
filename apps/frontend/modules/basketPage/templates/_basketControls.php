<div class="buttons">
    <div class="continue">
	    <a href="<?php include_component('linker', 'articleLinkBuilder', array('node' => $continueShoppingNode))?>"><?php echo __('Continue Shopping') ?></a>
	</div>
	<?php if(!empty($products)):?>
	<div class="checkout">
	    <a href="<?php if($sf_user->isAuthenticated()):?><?php include_component('linker', 'basket', array('action' => 'checkout') )?><?php else:?>#<?php endif;?>"><?php echo __('Checkout')?></a>
	</div>
	<?php endif;?>
</div>
<div class="clear"></div>
