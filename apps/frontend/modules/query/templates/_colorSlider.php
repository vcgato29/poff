<?php

$formField = $form['värvus'];
$activeElementIndex = $formField->getValue() ? $formField->getValue() : -1;

$t1 = count($colors) % 6 != 0 ? 6 - count($colors) % 6 : 0;
for($i = 1; $i <= $t1; ++$i)
	$colors[] = false;
?>
<div class="colorsliders">
    <div class="profiiltoptext"><?php echo __('Vali värvus') ?>:</div>
    <div id="colorcarousel" class="colorcarousel">
        <div class="colorboxwrap">
            <div class="colorbox">
                <ul>
					<?php echo $formField->render(array('style' => 'display:none')) ?>

					<?php foreach($colors as $index => $color): ?>

					

					<?php if($index % 3 == 0): ?><li><?php endif; ?>
						<?php if($color): ?>
                        <div class="colorthumb">
							<div class="itemindex" style="display:none"><?php echo $index ?></div>
							<a href="#"><img src="<?php echo $color['img'] ?>" width="28" height="28" alt="<?php echo $color['txt'] ?>" /></a>
							<div class="colorthumbhidden" <?php if($index == $activeElementIndex): ?>style="display:block"<?php endif; ?>>
								<img src="<?php echo $color['img'] ?>" width="35" height="35" alt="<?php echo $color['txt'] ?>" />
							</div>
                        </div>
						<?php else: ?>
							<div style="width:28px;height:28px">&nbsp;</div>
						<?php endif; ?>
                    <?php if($index % 3 == 2): ?></li><?php endif; ?>
					<?php endforeach; ?>
                </ul>
                <div class="clear"></div>
            </div>
        </div>
    </div>
    <div class="colorbottomtext">
		<?php foreach($colors as $index=>$color): ?>
			<?php if($index == $activeElementIndex): ?>
				<?php echo $color['txt'] ?>
			<?php endif; ?>
		<?php endforeach; ?>

	</div>
</div>


<script type="text/javascript">
jQuery(document).ready(function() {

    $('.colorthumb').click(function(e){
		e.preventDefault();
		
        $('.colorthumbhidden').css('display','none');
        $(this).find('.colorthumbhidden').css('display','block');



		//put selected color index in input field
		var input = $(this).parents('ul').find('input');
		input.val($('.itemindex',this).text());
		//console.log('v2rv: ' + input.val());

		//put selected color name in box
		$('.colorbottomtext').text($('a img',this).attr('alt'));

		return false;
    });


    jQuery('#colorcarousel').jcarousel({
        scroll: 2,
        visible: 2,
    	wrap: 'circular',
		start: <?php echo ((ceil((abs($activeElementIndex) + 1) / 6) - 1) * 2) + 1 // sick formula to get slider on the right position ?>
    });
});
</script>