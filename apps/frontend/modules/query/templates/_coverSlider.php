<?php
$formField = $form['pinnakate'];
?>
<div class="katesliders">
    <div class="profiiltoptext"><?php echo __('Vali pinnakate') ?>:</div>
    <div id="katecarousel" class="katecarousel">
        <div class="kateboxwrap">
            <div class="katebox">
                <ul>
					<?php echo $formField->render(array('style' => 'display:none')) ?>
					<?php foreach($covers as $index => $cover): ?>
                    <li>
						<div class="itemindex" style="display:none"><?php echo $index ?></div>
						<?php foreach($cover['desc'] as $desc): ?>
                        <div class="pinnakate">
                            <div class="textradio"><img src="/olly/img/textradio.png" width="15" height="15" alt=""/></div>
                            <div class="pinnatext"><?php echo $desc ?></div>
                            <div class="clear"></div>
                        </div>
						<?php endforeach; ?>
                        <div class="katebottomtext"><?php echo __($cover['name']) ?></div>
                    </li>
					<?php endforeach; ?>
                </ul>
                <div class="clear"></div>
            </div>
        </div>
    </div>
</div>
<div class="clear"></div>

<script type="text/javascript">
jQuery(document).ready(function() {
    jQuery('#katecarousel').jcarousel({
	    scroll: 1,
		visible: 1,
    	wrap: 'circular',
		itemVisibleInCallback: {
			onAfterAnimation: function(carousel,item,index,state){
				var input = $(item).parents('ul').find('input');
				input.val($('.itemindex',item).text());

				//console.log('pinnakate: ' + input.val());
			}
		},
		start: <?php if($formField->getValue()): ?> <?php echo $formField->getValue() + 1 ?> <?php else: ?> 1 <?php endif; ?>
    });
});
</script>