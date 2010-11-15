<a name="signinform"> </a>
<div>
<div class="checktootebox" style="<?php if(!$sf_user->hasFlash('basket.signin.message') ):?>display:none<?php endif;?>">
    <div class="register">
		<p style="padding:0px;"><?php echo strtoupper(__('I want to register as a user'))?></p>
		<div class="clear"></div>
		<div style="position: absolute;" class="submit">
		    <a href="<?php include_component('linker', 'registrationPage', array('basket' => 1))?>"><?php echo __('Register')?></a>
		</div>
	</div>
	<div class="registered">
		<p style="padding:0px;"><?php echo strtoupper(__('I am a registered user'))?></p>
		<div class="clear"></div>
	</div>
	<div class="clear"></div>
	<div id="registered" class="forms registeredforms">
	 &nbsp;<?php echo $sf_user->getFlash('basket.signin.message')?>
    <form id="basket_signin_form" method="post" action="<?php include_component('linker', 'signIn', array('basket' => 1) ) ?>">
    	<input type="hidden" name="message" value="basket.signin.message" />
    	<input type="hidden" name="anchor" value="signinform" />
    <?php echo $form->renderHiddenFields(true)?>
	    <div class="username">
            <?php echo $form['username']->render(array('title' => __('Username') ,'class' => 'user', 'value' => __('Username') ))?>
		</div>
		<div class="password">
		    <?php echo $form['password']->render(array('title' => __('Password'), 'class' => 'pass', 'value' => __('Password') ))?>
		</div>
		<div class="submit basket_signin" style="position:relative">
		    <a href="#"><?php echo __('Sign in')?></a>
		</div>
	</form>
	<div class="clear"></div>
	</div>
</div>
</div>
<div class="clear"></div>


<script type="text/javascript">
$('.user, .pass').clearInputDescription();

// submit form on "Sign in" click
$('.basket_signin').click(function(e){
	e.preventDefault();
	$('#basket_signin_form').submit();
	return false;
});

// click on "checkout": fade in signing form, scroll down 
$('.checkout').click(function(e){
	e.preventDefault();
	$('.checktootebox').fadeIn(50, function(){
		window.location.hash = '#signinform';
	});
	return false;
});
</script>