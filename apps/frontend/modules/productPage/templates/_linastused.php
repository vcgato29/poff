<?php if($linastused instanceof Doctrine_Collection && $linastused->getFirst()): ?>
<?php

if($userLinastused && $userLinastused instanceof Doctrine_Collection){
	$userLinastused = $userLinastused->getPrimaryKeys();
}

?>

<div class="tabs-box type02">
	<?php foreach($linastused as $linastus): ?>

	<span>
	<?php echo __(date('D', strtotime($linastus['scheduled_time']))) ?> <?php echo date('d.m.Y H:i', strtotime($linastus['scheduled_time'])) ?> <?php echo $linastus['cinema'] ?> <b><?php echo $linastus['comment'] ?></b><br>
	<?php if(strtotime($linastus['scheduled_time']) > time() && $linastus['buy_link'] ): ?>
		<a target="_blank" href="<?php echo $linastus['buy_link'] ?>"><?php echo __('OSTA PILET') ?></a> |
	<?php endif; ?>
		<a class="add_linastus_link <?php echo $userLinastused && in_array($linastus['id'], $userLinastused) ? 'hidden' : '' ?>" href="<?php echo $sf_user->isAuthenticated() ? LinkGen::getInstance(LinkGen::SCHEDULE)->link(null, array('action' => 'add', 'id' => $linastus['id'])) : '#' ?>"><?php echo __('LISA OMA KAVVA') ?></a>
		<a class="remove_linastus_link <?php echo $userLinastused && in_array($linastus['id'], $userLinastused) ? '' : 'hidden' ?>" href="<?php echo LinkGen::getInstance(LinkGen::SCHEDULE)->link(null, array('action' => 'delete', 'id' => $linastus['id'])) ?>"><?php echo __('EEMALDA') ?>[X]</a><br>

	</span>
	<?php endforeach; ?>
	
</div>

<script type="text/javascript">

	$('.add_linastus_link, .remove_linastus_link').click(function(e){
		e.preventDefault();

		if($(this).attr('href') == '#'){
			$('#login_link').trigger('click');
			return false;
		}

		var tr = $(this).parents('span');
		if($(this).hasClass('remove_linastus_link')){
			$('.add_linastus_link', tr).show();
			$('.remove_linastus_link', tr).hide();
		}else{
			$('.add_linastus_link', tr).hide();
			$('.remove_linastus_link', tr).show();
		}

		$.post($(this).attr('href'), function(response){

		});

		return false;
	});
</script>
<?php endif; ?>