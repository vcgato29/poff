<?php
class RegistrationFacebookForm extends BasePublicUserForm
{

	

   public function configure()
   {

    	$this->useFields(array( 'login', 'name','email', 'password' ));
    	
		$this->validatorSchema['login'] = new sfValidatorString();
    	$this->validatorSchema['email'] = new sfValidatorEmail();
     
   }
   
   
} 