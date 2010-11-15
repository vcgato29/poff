<p><?php echo __('I will pick up goods from shop')?>:</p>
<div class="clear"></div>

<!-- list of availible shops -->
<div class="dropdown" id="<?php echo $form_shop['shop']->renderId() ?>">
    <p><?php echo __('Choose shop')?></p>
	<img height="16" width="17" alt="" src="/faye/img/droparrow.png">
	<div class="clear"></div>
	<div class="hiddendrop" id="pic">
	    <div class="hiddendropbox">
			<?php foreach($shops as $shop):?>
				<a href="#" class="shop"><?php echo $shop['title']?>
				<input  alt="shop_address" type="hidden" value="<?php echo $shop['address']?>" />
				<input  alt="shop_id" type="hidden" value="<?php echo $shop['id']?>" />
				</a>
			<?php endforeach;?>
		</div>
	</div>
	
	<div id="selected_shop_id" style="display:none;">
		<?php echo $form_shop['shop']->render(array('id' => 'faked_input_id')) //"hidden" field?>
	</div>
</div>

<!-- selected shop -->
<div class="pic selected_shop_text"> 
	<p> </p>
</div>
	

<script type="text/javascript">
// actions on shop select
$('.shop').click(function(e){
	$('.selected_shop_text p').html($('input[alt=shop_address]',this).val());
	$('#selected_shop_id input').val($('input[alt=shop_id]',this).val());
});
</script>