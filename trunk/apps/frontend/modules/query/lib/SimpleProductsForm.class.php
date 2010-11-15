<?php

class SimpleProductsForm extends sfForm{
	
	public function configure(){

		$this->setNameFormat();

		$this->widgetSchema['valitud tooted'] =
			new sfWidgetFormInputCheckbox(array(), array());

		$this->widgetSchema['toodete kogused'] =
			new sfWidgetFormInput(array(),array('class' => 'koguseinput'));


		$this->validatorSchema['valitud tooted'] = new sfValidatorPass();
		$this->validatorSchema['toodete kogused'] = new sfValidatorPass();

		$this->setDefault('toodete kogused', '1');

	}

   public function getErrors(){
   $result = array();

    foreach($this->getErrorSchema() as $index => $val){
        $result[$index] = $val->__toString();
    }
    return $result;

   }

   public function setNameFormat(){
        $this->widgetSchema->setNameFormat('products[%s]');
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