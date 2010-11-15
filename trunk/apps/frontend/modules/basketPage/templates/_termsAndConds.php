<div class="rightbottom"> 
	<div class="checkbox" id="terms_and_conditions"><?php echo $form['accept_terms_and_conditions']->render()?></div>
	<p class="check"><?php echo __('I accept the <span>terms and conditions</span>')?></p>
</div>



<script type="text/javascript">

$('#terms_and_conditions').click(function(){
	$(this).toggleClass('checkbox');
	$(this).toggleClass('checkboxactive');

	var val = $(this).hasClass('checkboxactive') ? 1 : 0;
	$('input', this).val(val);

	// IE6 hacking
	if($(this).hasClass('checkboxactive')){
		$(this).css('background-url', 'url("img/checked.png") no-repeat scroll 0 0 transparent');
	}else{
		$(this).css('background-url', 'url("img/unchecked.png") no-repeat scroll 0 0 transparent');
	}
});

$(".check span").fancybox({
    'autoScale'     	: false,
    'transitionIn'		: 'none',
	'transitionOut'		: 'fade',
	'type'				: 'iframe',
	'width'				: '75%',
	'height'			: '75%',
	'href'				: '<?php include_component('linker', 'plainActions', array('module'=>'article','action' => 'termsAndConds','nodeID' => $termsAndConditionsNode->getId()))?>'
});
</script>