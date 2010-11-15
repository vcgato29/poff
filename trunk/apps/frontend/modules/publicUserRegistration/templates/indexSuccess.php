<?php include_component('articlesLeftMenuWidget', 'render', array('controller' => $controller))?>

<?php slot('maincontent')?>
<div class="maincontent">
	<?php include_component('headerMenu', 'breadCrumbs')?>
	<div class="clear"></div>
	<form id="registration_form" method="post" action="<?php include_component('linker', 'registrationPage', $submitActionParams) ?>">
	
	<div class="settings">
	
	<div class="viga">
	    <p><?php echo __($sf_user->getFlash('mysettings.message'))?>
	    <?php if($sf_user->hasFlash('mysettings.errors')):?>
	    	<?php foreach($sf_user->getFlash('mysettings.errors') as $error):?>
	    	<?php if($error):?>
	    		<br /><?php echo __($error)?>
	    	<?php endif;?> 
	    	<?php endforeach;?>
	    <?php endif;?>
	    </p>
	</div>
	<div class="smallboxesleft">
	    <div class="personalinfo">
			<?php include_partial('publicUserRegistration/user_personalinfo', array('form' => $form))?>
			<div class="clear"></div>
			
			<div class="save">
			    <a href="#"><?php echo __('Register')?></a>
			</div>
			<div class="clear"></div>
		</div>
    </div>
					    
	<?php foreach($form->getEmbeddedForms() as $index => $embeddedForm):?>
	<div class="<?php if($index > 0):?>ship2 <?php endif;?>smallboxesright">
		<div class="personalinfo">
			<div class="formheader"><?php echo $form[$index]['title']->render(array('value' => __('Your delivery information'),'title' => __('Your delivery information'),'class' => !$form[$index]['title']->hasError() ? 'header' : 'userred'))?></div>
			<div class="clear"></div>
			<?php include_partial('publicUserRegistration/user_address', array('form' => $form[$index]))?>
			<div class="clear"></div>
		</div>
	</div>
	<?php endforeach;?>
						
	<div class="clear"></div>
	</div>

	</form>
</div>
		    	
<script type="text/javascript">
$('input').clearInputDescription();

$('.save').click(function(e){
	e.preventDefault();
	$('#registration_form').submit();
	return false;	
});
</script>
<?php end_slot()?>