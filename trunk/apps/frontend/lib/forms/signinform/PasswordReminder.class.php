<?php
class PasswordReminderForm extends BaseForm{
   public function configure()
   {

     $this->setNameFormat();

     $this->widgetSchema['email'] = new sfWidgetFormInput();
     
     $this->setValidators( array(
        'email' => new sfValidatorEmail(array('min_length' => 2, 'max_length' => 100), array()),
      ));


   }
   
   public function setNameFormat(){
   		$this->widgetSchema->setNameFormat('reminder[%s]');
   }
}