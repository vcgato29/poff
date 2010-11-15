<?php

class ParameterProductValueHTMLForm extends ParameterProductValueForm{
	public function configure(){
		
		$this->widgetSchema['common_value'] = new sfWidgetFormTextArea( array(), array( 'class'=>'formInput' ) );
		parent::configure();
		
	}
	
  public function getEditFormRendereringTemplate(){
  	
  	if( $this->getObject()->getParameter()->getMultilang() )
  		return "multilang_htmlform";
  	else
  		return "singlelang_htmlform";
  }
  
  public function setupI18nCallback(){
  	foreach( $this->getLanguages() as $lang )
		$this->widgetSchema[$lang]['value'] =  new sfWidgetFormTextArea( array(), array( 'class'=>'formInput' ) );
  }

}