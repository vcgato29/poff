<div class="payment">
 	<a href="seb" title="Seb"><img height="18" width="28" src="/faye/img/visa.png" /></a>
	<a href="nordea" title="Nordea"><img height="18" width="28" alt="master" src="/faye/img/master.png" /></a>
</div>
		
<script type="text/javascript">
	$(document).ready(function(){
		$('.payment a').click(function(e){
			e.preventDefault();
			$('.payment img').fadeTo(0,0.5);
			$('img',this).fadeTo(0, 1);

			$('#selected_payment span').html($(this).attr('title'));
			$('#selected_payment input').val($(this).attr('href'));
			
			return true;
		});
	});

</script>