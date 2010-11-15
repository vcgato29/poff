<?php

/**
 * ParameterProductValue form.
 *
 * @package    jobeet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class ParameterProductValueForm extends BaseParameterProductValueForm
{
	public $langs = array();
	
  public function configure(){
  	
	$this->useFields( array( 'product_id', 'param_id', 'common_value' ) );
  	
  	$this->widgetSchema['product_id'] = new sfWidgetFormInputHidden();
  	$this->widgetSchema['param_id'] = new sfWidgetFormInputHidden();
  	
  	$this->setupI18n();
  	
  }
  
  public function getEditFormRendereringTemplate(){
  	return "zzz";
  }
  
  
  public function setupI18n(){
		if( $this->getObject() ){
			if( $this->getObject()->getParameter()->getMultilang() ){
				$this->embedI18n( $this->getLanguages()  );
				unset($this['common_value']);	
				$this->setupI18nCallback();
			}
		}
  }
  
  
  public function setupI18nCallback(){}
  
  
  public function getLanguages(){
  	return $this->langs;
  }
  
  
  public function setLanguages( array $langs ){
  	
  	foreach( $this->getLanguages() as $lang ){
  		unset( $this[$lang] );
  	}

  	$this->langs = $langs;
  	
  	$this->setupI18n();
  }
	
}
