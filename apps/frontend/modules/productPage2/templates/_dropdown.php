<div class="dropdown">
	<div class="dropdowninput" style="display:none"><?php echo $field->render() ?></div>
	<div class="drop">
		<div class="droptext"><?php echo $default ?></div>
		<div class="droparrow">
			<img height="5" width="11" alt="" src="/olly/img/droparrow.png">
		</div>
	</div>
	<div class="hiddendrop">
		<ul>
			<?php foreach($values as $index => $val): ?>
				<li><a href="<?php echo $val ?>"><?php echo __($index) ?></a></li>
			<?php endforeach; ?>
		</ul>
	</div>
</div>