<div class="tabbox">
    <div class="pakkumine" style="border-top: 0px">
        


		<form id="contactform" action="<?php include_component('linker', 'structureActions',
				array('node' => $node, 'module' => 'contactUsForm', 'action' => 'submit')) ?>" method="post" style="width:200px;">
		<div class="pakkumineright">
        <?php include_partial('query/contactForm',
							array('form' => $form, 'helper' => $helper)) ?>

		<div class="formosa">
			<img width="333" height="14" alt="" src="/olly/img/formsraz.png">
		</div>


		<?php include_partial('query/contactMethod', array('form' => $form)) ?>

		<div class="blackbuttonbox">
			<div class="button submitbutton">
				<div class="link" style="display:none"><?php echo $helper->link('processContactForm') ?></div>
				<div class="buttontext"><a href="#"><?php echo __('Saada') ?></a></div>
			</div>
		</div>


		</div>
	</form>
	<div style="padding-top:28px;">
		<?php echo $node['content'] ?>
	</div>
	<div class="clear"></div>
    </div>
</div>
<?php use_javascript('/olly/js/blockUI/script.js') ?>
<script type="text/javascript">
	$('.submitbutton').click(function(e){
		e.preventDefault();

		var form = $(this).parents('form');
		var data = form.serialize();

		$.blockUI({ message: '<h1><?php echo __('Oota...') ?></h1>' });

		$.post(form.attr('action'), data, function(data){

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
				$.prompt(data.notice,{
					buttons: { OK:true }
				});
			}
		},'json');

		
		return false;
	});
</script>