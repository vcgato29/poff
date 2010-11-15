$('.rbutton').live('click',function(e){

	var input = $('input[type=radio]', this);
	var inputName = input.attr('name');

		$('input[name=' + inputName +']')
			.attr('checked', false)
		.parent('.rbuttonactive')
			.toggleClass('rbuttonactive')
			.toggleClass('rbutton');


	input.attr('checked', true);
	$(this).toggleClass('rbutton');
	$(this).toggleClass('rbuttonactive');
});