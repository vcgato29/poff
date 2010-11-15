<?php
$formField = $form['valitud tooted'];

?>

<div class="vihmasystem">
	<?php foreach($productGroups as $groupName => $products): ?>
	<div class="vihmasystemcenter">
		<h3><?php echo $groupName ?>:</h3>
		<div class="turvabox">
			<?php foreach($products as $index => $product): ?>
			<?php
				if($index % 3 == 0)
					$position = 'left';
				else if($index % 3 == 1)
					$position = 'center';
				else
					$position = 'right';
			?>
			<div class="vcenter<?php echo $position ?>">
				<div class="turva">
					<div class="turvaimgbox">
						<a href="#"><img width="109" height="110" alt="" src="<?php echo @myPicture::getInstance( $product->ProductPictures[0]->getFile() )->thumbnail(109,110,'center')->url() ?>"></a>
					</div>
					<div class="turvacheck">
						<div id="rcheck1" class="uncheck"><?php echo $formField->render(array('checked' => @in_array($product['id'], $data['valitud tooted']),'name' => $formField->renderName() . '[]','style' => 'display:none','value' => $product['id'])) ?></div>
						<div class="turvachecktext"><p><?php echo $product['name'] ?></p></div>
					</div>
					<div class="clear"></div>
					<div class="kogus">
						<div class="kogusetext"><?php echo __('Kogus') ?></div>
						<div class="koguseform">
							<?php
								$value = isset($data['toodete kogused']['prod_' . $product['id']]) ? $data['toodete kogused']['prod_' . $product['id']] : 1;
								$name = $form['toodete kogused']->renderName() . '[prod_' . $product['id'] . ']';

								echo $form['toodete kogused']->render(array('value' => $value,'name' =>  $name));
							?>
							
						</div>
					</div>
					<div class="clear"></div>
				</div>
			</div>
			<?php endforeach; ?>
			<div class="clear"></div>
		</div>
	</div>
	<div class="clear"></div>
	<?php endforeach; ?>
</div>
<div class="clear"></div>

<script type="text/javascript">

	$('.uncheck input[checked]').each(function(){
		$(this).parent('.uncheck')
		.toggleClass('uncheckactive')
		.toggleClass('uncheck');
	});

    $('.uncheck, .uncheckactive').click(function(){

        var input = $('input', this);

        // kas soovib katuse m66distamist ?
        if($(this).hasClass('uncheckactive')){
            input.attr('checked', false);
        }else{
            input.attr('checked', true);
        }

        $(this).toggleClass('uncheckactive');
        $(this).toggleClass('uncheck');
    });

</script>

