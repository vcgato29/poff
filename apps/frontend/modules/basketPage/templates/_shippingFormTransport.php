	<p><?php echo __('Please send me the goods')?>:</p>
	<div class="clear"></div>
	
	<div class="dropdown" title="1">
	    <p><?php echo $form_transport['title']->getValue()?></p>
		<img height="16" width="17" alt="" src="/faye/img/droparrow.png">
		
		<div class="clear"></div>
		<div class="hiddendrop">
		    <div class="hiddendropbox">
				<?php foreach($addresses as $address):?>
				<a href="#" class="shippingaddress" rel="<?php echo $address->getAddressId()?>"><?php echo $address->getTitle()?></a>
				<?php endforeach;?>
			</div>
		</div>
	</div>
	
	
	<?php foreach($addresses as $address):?>
		<div id="shippingaddress_<?php echo $address->getAddressId()?>">
		<?php foreach($form_transport as $field):?>
			<?php if(!$field->isHidden()):?>
				<input type="hidden" name="<?php echo $field->renderId()?>" value="<?php echo $address[$field->getName()]->getValue()?>" />
			<?php endif;?>
		<?php endforeach;?>
		</div>
	<?php endforeach;?>
		
		
<script type="text/javascript">
/* user clicks on ADDRESS in dropdown menu. Paste information from DATA HOLDER (shippingaddress_*) to address input fields  */
	$('.shippingaddress').click(function(e){
		var selectedAddress = $(this).attr('rel');

		$('#shippingaddress_' + selectedAddress + " input").each(function(){
			var dest =$('#' + this.name);
			var source = $(this);

			if(!source.val()){
				dest.val( dest.attr('title') );
				return;
			}
			if(dest)dest.val(source.val());
		});
	});
</script>

	<div id="shipping_fields">
		<div class="username">
		
			<?php 
				$field = $form_transport['name'];
				$default = __('Name');
				$class = $field->hasError() ? 'user errinput' : 'user';
				$val = $field->getValue() ? $field->getValue() : $default;
				echo $field->render(array('class' => $class, 'value' => $val, 'title' => $default));
			?>
		</div>
		<div class="username">
			<?php 
				$field = $form_transport['address'];
				$default = __('Address');
				$class = $field->hasError() ? 'user errinput' : 'user';
				$val = $field->getValue() ? $field->getValue() : $default;
				echo $field->render(array('class' => $class, 'value' => $val, 'title' => $default));
			?>
		</div>
		<div class="username">
			<?php 
				$field = $form_transport['city'];
				$default = __('City');
				$class = $field->hasError() ? 'user errinput' : 'user';
				$val = $field->getValue() ? $field->getValue() : $default;
				echo $field->render(array('class' => $class, 'value' => $val, 'title' => $default));
			?>
		</div>
		<div class="username">
			<?php 
				$field = $form_transport['country'];
				$default = __('Country');
				$class = $field->hasError() ? 'user errinput' : 'user';
				$val = $field->getValue() ? $field->getValue() : $default;
				echo $field->render(array('class' => $class, 'value' => $val, 'title' => $default));
			?>
		</div>
	</div>
	
	
<div class="bottominput">
	<div class="dropdown" id="<?php echo $form_transport['shipping_zone_id']->renderId() //ID is needed for ERROR OUTLINING?>">
	    <p><?php echo __('Select shipping type')?></p>
		<img height="16" width="17" alt="" src="/faye/img/droparrow.png">
		<div class="clear"></div>
		<div class="hiddendrop" id="dropdown2">
		    <div class="hiddendropbox">
				<?php foreach( $shippingZones as $shippingZone ):?>
					<a class="shippingzone" href="#">
					<?php echo $shippingZone['name']?>
					<input type="hidden" value="<?php echo $shippingZone['id']?>" />
					</a>
				<?php endforeach;?>
			</div>
		</div>
		
		<div id="selected_shipping_zone" style="display:none">
			<?php echo $form_transport['shipping_zone_id']->render(array('id' => 'foreign_shipping_zone_id')) // ID is changed because field is hidden, and REAL id is used in dropdown itself for error outlining in RED?>
		</div>
	</div>
</div>
	
	<a id="change_shipping_zone_link" href="<?php include_component('linker', 'basket', array('action' => 'changeShippingZone', 'orderID' => $sf_request->getParameter('orderID') ) )?>" ></a>
	
	<script type="text/javascript">
		$('.shippingzone').click(function(e){
			e.preventDefault();

			$('#selected_shipping_zone input').val($('input',this).val());

			// is CHECKBOX active
			if($(this).parents('.container').find('.shipselect').hasClass('checkboxactive')){
				shippingZoneChanged();
			}
			
			return false;
		});
	</script>