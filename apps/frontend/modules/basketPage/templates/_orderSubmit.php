<div class="proceed">
	<a href="#"><?php echo __('Proceed to payment')?></a>
</div>

<div style="float:right;display:none;margin-bottom:35px;" class="loader">
	<img src="/faye/ajax-loader.gif" height="23px" width="148px" >
</div>

<script type="text/javascript">
$('.proceed').click(function(e){
	e.preventDefault();
	
	var form = $(this).parents('form');
	var action = form.attr('action');
	var params = form.serialize();
	var button = $(this);
	
	var toggleLoader = function(){
		if($('.loader').is(':visible')){
			button.show();
			$('.loader').hide();
		}else{
			button.hide();
			$('.loader').show();
		}
	};

	toggleLoader();
	
	$.post(action, params, function(data){
		$('.errinput').removeClass('errinput');
		toggleLoader();
		
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
			//alert('ok');
			window.location.href = data.link;
		}
	},'json');
});
</script>