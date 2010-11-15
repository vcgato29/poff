<?php

class ParameterProductValueTextBoxForm extends ParameterProductValueForm{
	public function configure(){
		parent::configure();
		
	}
	
  public function getEditFormRendereringTemplate(){
  	
  	if( $this->getObject()->getParameter()->getMultilang() )
  		return "multilang_textfieldform";
  	else
  		return "singlelang_textfieldform";
  }
}