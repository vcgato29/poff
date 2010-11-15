<?php include_component('articlesLeftMenuWidget', 'render', array('controller' => $controller))?> 

<?php slot('maincontent')?>
<div class="maincontent">
	<?php include_component('headerMenu', 'breadCrumbs')?>
	<div class="clear"></div>
	
	<form id="registration_form" method="post" action="<?php include_component('linker', 'mySettingsLinkBuilder', array('action' => 'editSettings')) ?>">
	<div class="settings">
	
	<div class="viga">
	    <p><?php echo __($sf_user->getFlash('mysettings.message'))?></p>
	</div>
	
	
		<div class="smallboxesleft"> <!-- USER PROFILE INFO -->
		    <div class="personalinfo">
				<?php include_partial('publicUserRegistration/user_personalinfo', array('form' => $form))?>
				<div class="clear"></div>
				
				<div class="save"><a href="#"><?php echo __('Save')?></a></div>
				<div class="clear"></div>
			</div>
	    </div>
	    
	    <div class="smallboxesright"> <!-- USER ADDRESSES and NEW ADDRESS ADDING -->
		<?php foreach($form->getEmbeddedForms() as $index => $embeddedForm):?>
			<?php if($index != RegistrationForm::EDIT_NEW_ADDRESS):?>
			
				<div class="personalinfo <?php if($index !== 'form_0'):?>ship2<?php endif;?>">
				<div class="formheader">
			           <?php echo $form[$index]['title']->render(array('title' => __('Your delivery information'),'class' => !$form[$index]['title']->hasError() ? 'header' : 'userred'))?>
				</div>
				
				<div class="clear"></div>
				<?php include_partial('publicUserRegistration/user_address', array('form' => $form[$index]))?>
					<div class="clear"></div>
					
					<?php if($form->getObject()->Addresses->count() > 1):?>
					<div class="remove_address">
						    <div class="removebutton"></div>
							<p><a href="<?php include_component('linker', 'mySettingsLinkBuilder', array('action' => 'deleteAddress',  'addressID' => $embeddedForm->getObject()->getId() )  ) ?>"><?php echo __('Remove')?></a></p>
					</div>
					<?php endif;?>
					
				<div class="save"><a href="#"><?php echo __('Save')?></a></div>
				<div class="clear"></div>
				
				</div>
			
			<?php endif;?>
		<?php endforeach;?>
		
			<div class="ship2 personalinfo">
			    <div class="formheader">
			           <?php echo $form[RegistrationForm::EDIT_NEW_ADDRESS]['title']->render(array('title' => __('new shipping address'),'value' => __('new shipping address'),'class' => !$form[RegistrationForm::EDIT_NEW_ADDRESS]['title']->hasError() ? 'header' : 'userred'))?>
				</div>
				<div class="edit2">
			        <div class="arrow"><img height="7" width="4" alt="" src="/faye/img/arrow.png"></div>
			        <div class="edittext"><a id="show_new_address_form" href=""><?php echo __('Add')?></a></div>
				</div>
				<div class="clear"></div>
				
				<div id="new_address_form" style="display:<?php if($form->newAddressSubmitted() ):?>block<?php else: ?>none<?php endif;?>">
					<?php include_partial('publicUserRegistration/user_address', array('form' => $form[RegistrationForm::EDIT_NEW_ADDRESS]))?>

					<div class="save"><a href="#"><?php echo __('Save')?></a></div>
					<div class="clear"></div>
				</div>
				<div class="clear"></div>

			</div>
		</div>						
		
		
		<div class="clear"></div>
    </div>
    
    </form>
</div>
		    	


<script type="text/javascript">
$('input').clearInputDescription();

$('#show_new_address_form').click(function(e){
	e.preventDefault();
	$('#new_address_form').toggle(500);
	return false;
});

$('.save').click(function(e){
	e.preventDefault();
	$('#registration_form').submit();
	return false;	
});

$('.remove_address').click(function(e){
	e.preventDefault();
	var link = $('a', this).attr('href');
	window.location = link;
	return false;
});
</script>

<?php end_slot()?>