<?php


class SimpleProfilesForm extends sfForm{

	public function configure(){


		$this->setNameFormat();

		$this->widgetSchema['katuse profiil'] = new sfWidgetFormInput();
		$this->widgetSchema['värvus'] = new sfWidgetFormInput();
		$this->widgetSchema['pinnakate'] = new sfWidgetFormInput();

		
		$this->validatorSchema['katuse profiil'] = new sfValidatorString(array('required' => false,'min_length' => 0, 'max_length' => 200));
		$this->validatorSchema['värvus'] = new sfValidatorString(array('required' => false,'min_length' => 0, 'max_length' => 200));
		$this->validatorSchema['pinnakate'] = new sfValidatorString(array('required' => false,'min_length' => 0, 'max_length' => 200));

	}


   public function getErrors(){
   $result = array();

    foreach($this->getErrorSchema() as $index => $val){
        $result[$index] = $val->__toString();
    }
    return $result;

   }

   public function setNameFormat(){
        $this->widgetSchema->setNameFormat('profiles[%s]');
   }

   public function validateForm(sfWebRequest $request){
       $this->bind($request->getParameter($this->getName()), array());

       if($this->isValid()){
           return true;
       }else{
           return false;
       }

   }


}