
<h2><?php echo __('Shipping zone intervals')?>:</h2>
<table style="width:400px;">
	<tr>
		<th><?php echo __('Interval')?></th>
		<th><?php echo __('Price')?></th>
		<th><?php echo __('Actions')?></th>
	</tr>
<?php foreach( $intervals as $interval ):?>
	<tr>
		<td><?php echo $interval->getStart()?> ... <?php echo $interval->getEnd()?></td>
		<td><?php echo $interval->getPrice()?></td>
		<td>
			<a class="struct_node" href="<?php echo url_for('admin_page', array('action'=>'editInterval', 'module' => 'shipping', 'intervalID' => $interval->getId() ));?>::30::30::1" >Change</a> 
			<a href="<?php echo url_for('admin_page', array('action'=>'deleteInterval', 'module' => 'shipping', 'intervalID' => $interval->getId()));?>" >Delete</a>
		</td>
	</tr>
<?php endforeach;?>
</table>


<a class="struct_node"   href="<?php echo url_for('admin_page', array('action'=>'newInterval', 'module' => 'shipping', 'zoneID' => $form->getObject()->getId()));?>::30::30::1"><?php echo __('Add interval')?></a>


