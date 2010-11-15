<h3><?php echo __('Oredered items')?>:</h3>

<?php foreach( $shipping as $ship ):?>

<?php $total = $ship->cost?>

<table>
	<tr>
		<td><?php echo __('Name')?>:</td>
		<td><?php echo $ship->name?></td>
	</tr>
	<tr>
		<td><?php echo __('Information')?>:</td>
		<td><?php echo $ship->information?></td>
	</tr>
	
	<tr>
		<td><?php echo __('Price')?>:</td>
		<td><?php echo $ship->cost?></td>
	</tr>
	
	<tr>
		<td><?php echo __('Mass interval')?>:</td>
		<td><?php echo $ship->mass_interval_start?> ... <?php echo $ship->mass_interval_end?> </td>
	</tr>
</table>

<table>
	
	<tr>
		<th><?php echo __('Product ID')?></th>
		<th><?php echo __('Name')?></th>
		<th><?php echo __('Quanity')?></th>
		<th><?php echo __('Mass')?></th>
		<th><?php echo __('One item price')?></th>
		<th><?php echo __('Total price')?></th>
	</tr>
		
		<?php foreach($ship->OrederedItems as $item):?>
		<tr>
			<td><?php echo $item->product_id?></td>
			<td><?php echo $item->name?></td>
			<td><?php echo $item->quanity?></td>
			<td><?php echo $item->mass?></td>
			<td><?php echo $item->price?></td>
			<td><?php echo $item->price * $item->quanity?></td>	
			
			<?php $total +=  $item->price * $item->quanity ?>
		</tr>
		<?php endforeach;?>	
	
	<tr align="right">
		<th style="text-align: right;" colspan="7">Total: <?php echo $total?></th>
	</tr>
		
		
</table>
<?php endforeach;?>