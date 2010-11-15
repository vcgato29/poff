<h3><?php echo __('Billing information')?>:</h3>
<table style="width:300px;">
	<tr>
		<td><?php echo __('Name')?>:</td>
		<td><?php echo $billing->getReceiver()?></td>
	</tr>
	
	<tr>
		<td><?php echo __('Email')?>:</td>
		<td><?php echo $billing->getEmail()?></td>
	</tr>
	
	<tr>
		<td><?php echo __('Country')?>:</td>
		<td><?php echo $billing->getCountry()?></td>
	</tr>
	
	<tr>
		<td><?php echo __('City')?>:</td>
		<td><?php echo $billing->getCity()?></td>
	</tr>
	
	<tr>
		<td><?php echo __('Street')?>:</td>
		<td><?php echo $billing->getStreet()?></td>
	</tr>
	
	<tr>
		<td><?php echo __('Zip')?>:</td>
		<td><?php echo $billing->getZip()?></td>
	</tr>
	
	<tr>
		<td><?php echo __('Paid in currency')?>:</td>
		<td><?php echo $billing->ProductOrder->pay_in_currency?></td>
	</tr>
	
	<tr>
		<td><?php echo __('User culture')?>:</td>
		<td><?php echo $billing->ProductOrder->user_culture?></td>
	</tr>
	
	<tr>
		<td><?php echo __('Invoice sent ?')?>:</td>
		<td><?php echo $billing->ProductOrder->invoice_mailed ? __('Yes') : __('No')?></td>
	</tr>

</table>