<?php
class ProductContactForm extends BaseForm
{


   public function configure()
   {

     $this->setNameFormat();

     $this->widgetSchema['sender_name'] = new sfWidgetFormInput();
     $this->widgetSchema['sender_email'] = new sfWidgetFormInput();
     $this->widgetSchema['receiver_name'] = new sfWidgetFormInput();
     $this->widgetSchema['receiver_email'] = new sfWidgetFormInput();
     $this->widgetSchema['message'] = new sfWidgetFormTextarea();
     $this->widgetSchema['captcha']= new sfWidgetFormInput();
     
     $this->setValidators( array(
        'sender_name' => new sfValidatorString(array('min_length' => 2, 'max_length' => 100)),
     	'sender_email' => new sfValidatorEmail (array('min_length' => 2, 'max_length' => 100)),
        'receiver_name' => new sfValidatorString(array('min_length' => 2, 'max_length' => 100)),
     	'receiver_email' => new sfValidatorEmail (array('min_length' => 2, 'max_length' => 100)),
     	'message' => new sfValidatorString(array('min_length' => 2, 'max_length' => 700)),
     	'captcha' => new sfCaptchaGDValidator(array('length' => 4)),
      ));


   }
   
   
   public function setNameFormat(){
   		$this->widgetSchema->setNameFormat('contact[%s]');
   }

} 