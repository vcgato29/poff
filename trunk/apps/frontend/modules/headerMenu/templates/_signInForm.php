<div class="login">
    <div class="linkname">
    	<p class="active"><?php echo __('Sign In')?></p>
    	
	    <!-- show if signin error is set OR reminder request was incorrect -->
		<div id="signin" class="hiddenbox" <?php if($sf_user->hasFlash('signin.error') || $sf_user->hasFlash('reminder.message')  ):?>style="display:block;"<?php endif;?>>
		    <div class="signincontentbox">
			    <div id="signcontent" class="signcontent">
			        <div class="signtop"></div>
					<div class="signcenter">
					    <div class="signcontent">
					        <h1><?php echo __('Existing customers')?></h1>
						    
							<p><?php echo __('Enter your user name and password if you have previously shopped on the Faye website')?></p>
							
							<div class="userlogin" style="<?php if($sf_user->hasFlash('reminder.message') ):?>display:none;<?php endif;?>">
								<p style="color:red"><?php if($sf_user->hasFlash('signin.error')):?> <?php  echo __( $sf_user->getFlash('signin.error') ) ?><?php endif;?></p>
							        
								<form id="loginform" action="<?php include_component('linker', 'signIn' ) ?>" method="post">
							        	<?php echo $form->renderHiddenFields(true)?>
									<div class="inputbox">
										<?php echo $form['username']->render(array('title' => __('Username') ,'class' => 'signin', 'value' => __('Username') ))?>
									</div>
									<div class="inputbox">
							        	<?php echo $form['password']->render(array('title' => __('Password'), 'class' => 'signin', 'value' => __('Password') ))?>
									</div>
								</form>
							</div>
							
						    <div class="clear"></div>
							<div class="fbox">
						        <div class="arrow"><img src="/faye/img/arrow.png" width="4" height="7" alt=""/></div>
						        <div class="forgot"><p><?php echo __('Forgotten your password ?')?></p></div>
						        
								<div class="inputbox" id="input" <?php if($sf_user->hasFlash('reminder.message') ):?>style="display:block;"<?php endif;?>>
									<br />
									<p style="color:red"><?php echo __($sf_user->getFlash('reminder.message'))?></p>
									
									<form id="password_reminder_form" action="<?php include_component('linker', 'passwordReminder')?>" method="post">
										<?php echo $reminderForm->renderHiddenFields(true)?>
										<?php echo $reminderForm['email']->render(array('class' => 'forgotpass', 'title' => __('Enter e-mail here') , 'value' => __('Enter e-mail here') ) )?>
	                                </form>
	                                
	                                
									<div class="button2" id="password_reminder" style="margin-top:10px;">
								       	<a href="#"><?php echo __('send')?></a>
								    </div>
                                </div>
                                
                                
						        <div class="clear"></div>
								
							</div>
							
							<div style="padding-bottom:15px;" class="button" id="signin_button" style="<?php if($sf_user->hasFlash('reminder.message') ):?>display:none;<?php endif;?>">
								<a href="#"><?php echo __('Sign in')?></a>
							</div>
							
							<div class="clear"></div>
							<div id="face_connect_button" style="padding-bottom:35px;">
								<img src="/faye/img/face_connect.png" />
							</div>
							
							 <div class="clear"></div>
							 
							<h1><?php echo __('New customers')?></h1>
							<p><?php echo __('If you haven’t shopped with us before, click the ‘Continue‘ button')?></p>
							<div class="button2">
								<a href="<?php include_component('linker', 'registrationPage')?>"><?php echo __('Continue')?></a>
							</div>
							<div class="clear"></div>
						</div>
					</div>
					<div class="signbottom"></div>
				</div>
			</div>
		</div>
	</div>
    <div id="a4" class="nonactivebutton"></div>
</div>


<script type="text/javascript">
$('#a4').click(function(){ // toggle sign in form
	$('#signin').toggle();
});

$('input.signin,input.forgotpass').clearInputDescription();

$('#signin_button').click(function(e){ // submit form on click
	e.preventDefault();
	$('#loginform').submit();
	return false;
});

jQuery(document.body).click(function(event){  // hide sign in form on body click
	var clicked = jQuery(event.target);
	if (!( clicked.is('#a4') || clicked.is('#signin') || clicked.parents('#signin').length )) {
		$('#signin').hide();
	}
});

$('.forgot').click(function(){
	$('.userlogin').toggle();
	$('#input, #signin_button').toggle();	
});

$('#password_reminder').click(function(e){
	e.preventDefault();
	$('#password_reminder_form').submit();
	return false;
});
</script>


<!-- FACEBOOK -->
<div id="fb-root"></div>
    <script>
      // initialize the library with the API key
   	  window.fbAsyncInit = function() {
	    FB.init({appId: 'd4f4a4800e3770f12ccad4f300d91f44', status: true, cookie: true,
	             xfbml: true});
	  };
	  (function() {
	    var e = document.createElement('script'); e.async = true;
	    e.src = document.location.protocol +
	      '//connect.facebook.net/en_US/all.js';
	    document.getElementById('fb-root').appendChild(e);
	  }());

      $('#face_connect_button').bind('click', function() {
        FB.login(handleSessionResponse, {perms: "email"});
      });


      // no user, clear display
      function clearDisplay() {
        $('#user-info').hide('fast');
      }

      // handle a session response from any of the auth related calls
      function handleSessionResponse(response) {
        // if we dont have a session, just hide the user info
        if (!response.session) {
          clearDisplay();
          return;
        }

        
		var perms = response.perms.split(',');
		for(z in perms){
			if(perms[z] == 'email'){
				var link = '<?php echo url_for('@facebook', array('action' => 'connect')) ?>';
				window.location = link;
			}
		}

      }
    </script>
<!-- /FACEBOOK -->