<?php 
/**
 * @continueShoppingNode = Structure object representing the node redirect after "Continue shopping" click
 * @products
 * @immutable 
 * 
 * 2 types of VIEW:
 *	 2.1 Mutable: x, +, - buttons AND JavaScript
 * 	 2.2 Immutable: x, +, i, inputs and readonly
 *  
 */
?>
<div class="columnname">
    <p class="remove">&nbsp;<?php if(!isset($immutable) || !$immutable):?><?php echo __('Remove')?><?php endif;?></p>
	<p class="item"><?php echo __('Item')?></p>
	<p class="unitprice"><?php echo __('Unit Price')?></p>
	<p class="qty"><?php echo __('Qty')?></p>
	<p class="amount"><?php echo __('Price')?></p>
<div class="clear"></div>
</div>

<?php foreach( $products as $product ):?>
<div class="tootebox product_<?php echo $product['product']['id'] ?>">

	<?php if(!@$immutable):?>
    <div class="remove removefrombasket"><a href="<?php include_component('linker', 'basket', array('action' => 'deleteFromBasket', 'productID' => $product['product']['id']) )?>" ></a></div>
    <?php else:?>
    <div class="remove removefrombasket" style="background: url('')"></div>
    <?php endif;?>
    
    <div class="thumb"><img height="71" width="77" alt="" src="<?php echo @myPicture::getInstance($product['product']['ProductPictures'][0]['file'])->thumbnail(77,71)->url()?>"></div>
	<div class="tootename">
	    <a href="<?php if(!@$immutable):?><?php include_component('linker', 'product', array('product' => $product['product']))?><?php endif;?>"><?php echo $product['product']['name']?></a>
	</div>
    <div class="price">
	    <p><?php echo price_format($product['product']['price_actual'])?></p>  
	</div>
	<div class="qty">
		<div class="minus" <?php if(isset($immutable) && $immutable):?>style="background:url('')"<?php endif;?>></div>
		<div class="input">
		    <form method="post" action="<?php include_component('linker', 'basket', array('action'=>'changeAmount'))?>">
		        <input <?php if(@$immutable):?>style="border:0px" readonly<?php endif;?> class="qtyinput" type="text" name="qty" title="<?php echo $product['quanity']?>" class="qtyinput" value="<?php echo $product['quanity']?>" >
		        <input type="hidden" name="productID" value="<?php echo $product['product']['id']?>">
			</form>
		</div>
		<div class="pluss"<?php if(@$immutable):?>style="background:url('')"<?php endif;?>></div>

		<div class="amount">
	        <p class="totalproductprice"><?php echo price_format($product['product']['price_actual'] * $product['quanity'])?></p>  
	    </div>
		<div class="clear"></div>
	</div>
	<div class="clear"></div>
</div>
<?php endforeach;?>

<?php if(!@$immutable):?>
<script type="text/javascript">
$('.minus, .pluss').click(function(e){ // "-" or "+" CLICKED -> change value -> trigger input CHANGED event
	var input = $(this).parent('.qty').find('.qtyinput');
	var val = parseInt(input.val());
	var incdec = $(this).hasClass('minus') ? -1 : 1;

	if(val + incdec <= 0) return false;
	input.val(val + incdec);
	input.trigger('change');

	return true;
});

$('.qtyinput').keypress(function(e){ // validate input
	var code = (e.keyCode ? e.keyCode : e.which);

	if( !isUnsignedInteger(String.fromCharCode(code)) && code != 8  && code != 39 && code != 37 ){
		e.preventDefault();
		return true;
	}
	
}).keyup(function(e){ // trigger input CHANGED event
	$(this).trigger('change');
});

// CHANGED event handler
var isLoading = true;
$('.qtyinput').change(function(e){ // send request, replace HTML content  
	var form = $(this).parent('form');
	var link = form.attr('action');

	if (this.value != this.lastValue) {
		var q = this.value;

		//set loader
		$(this).parents('.tootebox').find('.totalproductprice').html('<img src="/faye/ajax-loader-black.gif" />');
		
		// Stop previous ajax-request
		if (this.timer) {
			clearTimeout(this.timer);
		}

		var input = $(this);
		// Start a new ajax-request in X ms
		this.timer = setTimeout(function () {

			$.post(link, form.serialize() ,function(data){
				basketDataChanged(data);
				basketDataChangedBasketView(data, input.parents('.tootebox'));
			},'json');
			
		}, 300);

		this.lastValue = this.value;
	}
	
});


var removeFromBasketFunction = function(e){ // remove button clicked -> send request -> replace HTML
	$(e.target).removeProductFromBasket( {
		link: $('a', e.target).attr('href'),
		container: $(e.target).parent('.tootebox'),
		loaderContainer: $(e.target),
		loader: '<img src="/faye/ajax-loader-black.gif" />',
		postCallback: function(data,container){
			basketDataChangedBasketView(data, container);
		}
	});

	return false;
}

// bind two events (click have additional behaviour like CLOSE basket)
$('.removefrombasket').live('click',removeFromBasketFunction);
$('.removefrombasket').live('remove',removeFromBasketFunction);

//specific to this page basket change behaviour
function basketDataChangedBasketView(data, container){

	$('#subtotal_price').html(data.total);
	$('.totalproductprice', container).html(data.price);
}
// helper function
function isUnsignedInteger(s) {
	  return (s.toString().search(/^[0-9]+$/) == 0);
}
</script>

<?php endif;?>
