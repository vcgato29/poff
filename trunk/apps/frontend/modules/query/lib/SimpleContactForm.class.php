<?php

class SimpleContactForm extends sfForm{

   public function configure()
   {

     sfProjectConfiguration::getActive()->loadHelpers(array('I18N'));

     $this->setNameFormat();

     $this->widgetSchema['nimi'] = new sfWidgetFormInput();
     $this->widgetSchema['aadress'] = new sfWidgetFormInput();
     $this->widgetSchema['indeks'] = new sfWidgetFormInput();
     $this->widgetSchema['maakond'] = new sfWidgetFormInput();
     $this->widgetSchema['telefon'] = new sfWidgetFormInput();
     $this->widgetSchema['email'] = new sfWidgetFormInput();
     $this->widgetSchema['lisainfo'] = new sfWidgetFormTextarea();

     $this->widgetSchema['send_copy'] = new sfWidgetFormSelectRadio(array(
        'choices'  => array('1', '0'),
    ));

     $this->widgetSchema['ühenduse meetod'] = new sfWidgetFormSelectRadio(array(
        'choices'  => array('phone', 'email'),
    ));


     $this->setValidators( array(
        'nimi' => new sfValidatorString(array('required' => false,'min_length' => 0, 'max_length' => 100)),
     	'aadress' => new sfValidatorString (array('required' => false,'min_length' => 0, 'max_length' => 100)),
        'indeks' => new sfValidatorString(array('required' => false,'min_length' => 0, 'max_length' => 100)),
     	'maakond' => new sfValidatorString (array('required' => false,'min_length' => 0, 'max_length' => 100)),
     	'telefon' => new sfValidatorString(array('required' => false,'min_length' => 0, 'max_length' => 100)),
        'email' => new sfValidatorEmail(array('required' => true,'max_length' => 100), array('invalid' => __('Vale email'), 'required' => __('Email on kohustuslik'))),
        'lisainfo' => new sfValidatorString(array('required' => false,'min_length' => 0, 'max_length' => 700)),

        'send_copy' => new sfValidatorString(array('required' => false)),
        'ühenduse meetod' => new sfValidatorString(array('required' => false)),
     	//'captcha' => new sfCaptchaGDValidator(array('length' => 4)),
      ));

     

     $this->setDefault('ühenduse meetod', 'email');
     $this->setDefault('send_copy', '1');

   }


   public function setNameFormat(){
        $this->widgetSchema->setNameFormat('contact[%s]');
   }

   public function validateForm(sfWebRequest $request){
       $this->bind($request->getParameter($this->getName()), array());

       if($this->isValid()){
           return true;
       }else{
           return false;
       }

   }

   public function getErrors(){
   $result = array();

    foreach($this->getErrorSchema() as $index => $val){
        $result[$index] = $val->__toString();
    }
    return $result;
    
   }


}