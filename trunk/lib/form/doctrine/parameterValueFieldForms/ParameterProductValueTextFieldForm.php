<?php

class ParameterProductValueTextFieldForm extends ParameterProductValueForm{
	public function configure(){
		
		$this->widgetSchema['common_value'] = new sfWidgetFormInputTextCustom( array(), array( 'class'=>'formInput' ) );
		
		parent::configure();
		

	}
	
  public function getEditFormRendereringTemplate(){
  	
  	if( $this->getObject()->getParameter()->getMultilang() )
  		return "multilang_textfieldform";
  	else
  		return "singlelang_textfieldform";
  }
  
  
  public function setupI18nCallback(){
  	foreach( $this->getLanguages() as $lang )
		$this->widgetSchema[$lang]['value'] =  new sfWidgetFormInputTextCustom( array(), array( 'class'=>'formInput' ) );
  }
	
	
	
}