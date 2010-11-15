<?php use_javascript('/olly/js/blockUI/script.js') ?>

<script type="text/javascript">
	jQuery('.submitbutton').click(function(e){
		e.preventDefault();
	var form = $(this).parents('form');
	var action =  $('.link', this).text();
	var params = form.serialize();
	var button = $(this);

	$.blockUI({ message: '<h1><?php echo __('Oota...') ?></h1>' });

	

	$.post(action, params, function(data){
		
		$.unblockUI();

		if(data.code == 500){
			var error_msg = '';
			for(var error in data.errors ){
				$('#' + error).addClass('errinput');
				error_msg = error_msg + data.errors[error] + '<br />';
			}

			$.prompt(error_msg,{
							buttons: { OK:true }
			});

		}else if(data.code == 200){

						$.prompt(data.message,{
							submit: function(v,m,f){
								document.location = data.link;
							},
							buttons: { OK:true }
			});
		}else if(data.code == 301){
					document.location = data.link;
				}
	},'json');

		return false;
	});
</script>