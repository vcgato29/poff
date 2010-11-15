<?php
$formField = $form['katuse profiil'];
?>
<div class="profiilsliders">
	<div class="profiiltoptext"><?php echo __('Vali katuse profiil') ?>:</div>
	<div id="profiilcarousel" class="profiilcarousel">
		<div class="profiilboxwrap">
			<div class="profiilbox">
				<ul>
					<?php echo $formField->render(array('style' => 'display:none')) ?>
					<?php foreach($profiles as $index => $profile): ?>
					<li>
						<div style="display:none" class="itemindex"><?php echo $index ?></div>
						<div class="profiilimg"><img src="<?php echo $profile['img'] ?>" width="109" height="110" alt="" /></div>
						<div class="profiilbottomtext" style="width:100px;padding-left:20px"><?php echo __($profile['txt']) ?></div>
					</li>
					<?php endforeach; ?>
				</ul>
				<div class="clear"></div>
			</div>
		</div>
	</div>
</div>



<script type="text/javascript">
jQuery(document).ready(function() {
	jQuery('#profiilcarousel').jcarousel({
		scroll: 1,
		visible: 1,
		wrap: 'circular',
		itemVisibleInCallback: {
			onAfterAnimation: function(carousel,item,index,state){
				var input = $(item).parents('ul').find('input');
				input.val($('.itemindex',item).text());

				//console.log('profiil: ' + input.val());
			}
		},
		start: <?php if($formField->getValue()): ?> <?php echo $formField->getValue() + 1 ?> <?php else: ?> 1 <?php endif; ?>
	});
});
</script>