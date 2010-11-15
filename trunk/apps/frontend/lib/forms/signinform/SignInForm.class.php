<?php
class SignInForm extends BaseForm
{


   public function configure()
   {

     $this->setNameFormat();

     $this->widgetSchema['username'] = new sfWidgetFormInput();
     $this->widgetSchema['password'] = new sfWidgetFormInputPassword();
     
     // submit form ON ENTER press
     $this->widgetSchema['submit'] = new sfWidgetFormInputHidden(array('type' => 'submit'), array('style' => 'display:none'));
     
     
     $this->setValidators( array(
        'username' => new sfValidatorString(array('min_length' => 2, 'max_length' => 100), array()),
     	'password' => new sfValidatorString(array('min_length' => 2, 'max_length' => 100), array()),
     	'submit' => new sfValidatorPass(),
      ));



   }
   
   public function setNameFormat(){
   		$this->widgetSchema->setNameFormat('signin[%s]');
   }

} 