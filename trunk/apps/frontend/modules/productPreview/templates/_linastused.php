<?php
$result = array();
$products = array();
foreach($linastused as $linastus){
	$result[date('y-m-d', strtotime($linastus['scheduled_time']))][] = $linastus;
	$products[] = $linastus['Product'];
}

$productLinks = LinkGen::getInstance(LinkGen::PRODUCT)->collectionLinks($products);

?>
<div id="front-films">
	<ul id="tabset01" class="tabs clear">
		<?php $todays = false; ?>
		<?php foreach($result as $index => $tab): ?>
			<?php if($index == date('y-m-d')): ?>
			<?php $todays = true; ?>
			<li><a href="#tabset01-01" onclick="return showTab(this,'tabset01')" class="active"><?php echo __('tänased filmid') ?></a></li>
			<?php else: ?>
			<li><a href="#tabset01-02" onclick="return showTab(this,'tabset01')" class="<?php echo $todays ? '' : 'active' ?>"><?php echo __('homsed filmid') ?></a></li>
			<?php endif; ?>
		<?php endforeach; ?>
	</ul>

	<?php $c = 1; ?>
	<?php foreach($result as $day => $linastused): ?>
	<div id="tabset01-0<?php echo $c ?>" class="<?php echo $c == 1 ? '' : 'hidden'; ++$c ?>">
		<ul class="list">
			<li class="level01"><?php echo __(date('D', strtotime($day))) ?> <?php echo date('d.m.Y', strtotime($day)) ?></li>
			<?php foreach($linastused as $linastus): ?>
				<li><?php echo date('H:i', strtotime($linastus['scheduled_time'])) ?> <a href="<?php echo $productLinks[$linastus['Product']['id']] ?>"><?php echo $linastus['name'] ?></a> / <?php echo $linastus['cinema'] ?> / <?php echo $linastus['Product']['year'] ?></li>
			<?php endforeach; ?>
		</ul>
	</div>
	<?php endforeach; ?>
</div>