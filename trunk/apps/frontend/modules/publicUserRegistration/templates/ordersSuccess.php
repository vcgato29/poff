<?php include_component('articlesLeftMenuWidget', 'render', array('controller' => $controller))?>
 
<?php slot('maincontent')?>
<div class="maincontent">
	<?php include_component('headerMenu', 'breadCrumbs')?>
	<div class="clear"></div>
	
<div class="orders">
	<div class="topmenu">
		<p><?php echo __('Name')?></p>
		<p class="orderstatus"><?php echo __('Status')?></p>
		<p class="orderdate"><?php echo __('Date')?></p>
		<p class="invoice"><?php echo __('Invoice')?></p>
		<p class="orderdetail"><?php echo __('Items')?></p>
	</div>
	
	<div class="clear"></div>
	<div class="orderbox">
		<?php foreach($orders as $order):?>
	    <div class="ordercontent">
		<div title="<?php echo $order['id']?>" class="ordername name"><a id="order_title_<?php echo $order['id']?>" href="#"><?php if($order['title']):?><?php echo $order['title']?><?php else: ?><?php echo __("no name")  ?><?php endif;?></a></div>
		<div class="orderstatus"><p><?php echo __($order['status'])?></p></div>
		<div class="date"><p><?php echo $order['created_at']?></p></div>
		<div class="invoice"><a href="<?php include_component('linker', 'myOrdersLinkBuilder', array('action' => 'invoice', 'invoiceID' => $order['id'] ) )?>"><?php echo $order['order_number']?></a></div>
		<div class="details">
			<?php foreach($order->OrederedItems as $item):?>
			<p class="ordername"><?php echo $item['name']?></p>
			<?php endforeach;?>
			<p>&nbsp;</p>
		</div>
		<div class="rename">
		    <div class="renamelink" title="<?php echo $order['id']?>">
			    <img height="7" width="4" alt="" src="/faye/img/arrow.png">
			    <a href="#"><?php echo __('Rename order')?></a>
			</div>
			<div class="clear"></div>
			<div>
			    <img height="7" width="4" alt="" src="/faye/img/arrow.png">
			    <?php if($order['status'] == ProductOrderTable::STATUS_NEW):?>
			    	<a href="<?php include_component('linker', 'basket', array('action' => 'order', 'order' => $order))?>"><?php echo __('Continue order')?></a>
			    <?php else:?>
			    	<a href="<?php include_component('linker', 'basket', array('action' => 'restartOrder', 'order' => $order))?>"><?php echo __('Restart order')?></a>
			    <?php endif;?>
			</div>
		    <div class="hideorder" id="hideorder_<?php echo $order['id']?>" title="<?php echo __('Hide order')?>"> <!-- propmpt popup title -->
			    <img height="7" width="4" alt="" src="/faye/img/arrow.png">
			    <a href="<?php include_component('linker', 'myOrdersLinkBuilder', array('action' => 'hideInvoice', 'invoiceID' => $order['id'] ) ) ?>"><?php echo __('Delete from list')?></a>
			</div>
		</div>
		<div class="clear"></div>
		</div>
		<div class="clear"></div>
		<?php endforeach;?>
	</div>
	</div>
</div>

<!-- prompt HTML -->
<div id="rename_prompt_html" style="display:none">
<?php echo __("Enter order name")?>:<br /> 
	<input type="text" class="alertName" name="myname" value="" />
</div>

<script type="text/javascript">
// rename order
$('.renamelink, .ordername').click(function(){
	
	var promptSubmitCallback = function (v,m,f){
		// if "Cancel" was pressed => close prompt
		if(v === false){
			jQuery.prompt.close();
			return;
		}
		
		// get prompt input field
		var input = $('.alertName', m);

		// check if input prompt input is filled
		if(input.val() == ""){
			input.css("border","solid #ff0000 1px");
			return false;
		}else{ // if VALUE is OK, hide controls
			$('.jqibuttons').hide();
			$('.jqimessage').html('<?php echo __('Loading')?>...');
		}

		// request URL
		var url = '<?php include_component('linker', 'myOrdersLinkBuilder', array('action' => 'renameInvoice') )?>';

		// send name change request
		$.get(url, {name: input.val(), invoiceID: v}, function(data) {
			$('#order_title_' + v).html(data);
			jQuery.prompt.close();
		});

		return false;

	};
	
	$.prompt($("#rename_prompt_html").html(),{
		submit: promptSubmitCallback,
		buttons: { OK:$(this).attr('title'), Cancel: false }
	});	
});

// hide order
$('.hideorder').click(function(e){
	e.preventDefault();
	
	$.prompt('<?php echo __('Are you sure ?')?>',{
		buttons: { OK:{title: this.title, value: this.id}, Cancel:{title: '<?php echo __('Cancel')?>', value: false} },
		submit: function(v, m, f){
			// if "Cancel" was pressed => close prompt
			if(v === false){
				jQuery.prompt.close();
				return;
			}

			var hideButton = $('#' + v);
			$('.jqibuttons').hide();
			$('.jqimessage').html('<?php echo __('Loading')?>...');
			$.post(hideButton.find('a').attr('href'), function(data){
				hideButton.parents('.ordercontent').slideUp(700);
				jQuery.prompt.close();
			});
			return false;
		}
	});
	return false;
});
</script>
<?php end_slot()?>