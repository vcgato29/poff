<?php slot('CounterWidget') ?>
	<?php foreach($counter as $counter1): ?>
	<?php $target = explode(",", $counter1['target']); $target[1] = intval($target[1])-1; $target2 = implode(",", $target);?>
	    $('#counter').countdown({until: new Date(<?php echo $target2; ?>),
    	layout: '<?php echo __('PÖFFini on jäänud') ?> <strong>{dn}</strong> <?php echo __('päeva') ?> <strong>{hn}</strong> <?php echo __('tundi') ?> <strong>{mn}</strong> <?php echo __('minutit') ?> <strong>{sn}</strong> <?php echo __('sekundit') ?>'});
	   <?php break; ?>

	<?php endforeach; ?>
<?php end_slot() ?>