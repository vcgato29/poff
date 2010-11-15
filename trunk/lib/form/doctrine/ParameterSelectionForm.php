<?php

/**
 * ParameterSelectionSingle form.
 *
 * @package    jobeet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class ParameterSelectionForm extends ParameterForm
{
	
  
  /**
   * @see ParameterForm
   */
  public function configure()
  {
  	
    parent::configure();
    
    unset($this['created_at']); 
    
    
    $parameterOption = new ParameterOption();
    $this->embedForm( 'new_option', new ParameterOptionForm() );
    
    if( !$this->isNew() ){
    	foreach( $this->getObject()->getParameterOptions() as $option ){
    		$this->embedForm( 'option_'.$option->getId(), new ParameterOptionForm( $option ) );		
    	}
    	
    	
    }
    
  }
  

  
  
	public function bind(array $taintedValues = null, array $taintedFiles = null) {

		
		// remove the embedded new form if the name field was not provided
		if (  ( isset( $taintedValues['new_option']['title'] ) &&  ( !$this->getObject()->getMultilang()  && is_null($taintedValues['new_option']['title']) ||  strlen($taintedValues['new_option']['title']) === 0 ) ) ||
				( isset($taintedValues['new_option']['et']['name'] ) && ( $this->getObject()->getMultilang() && is_null( $taintedValues['new_option']['et']['name'] ) ||  strlen($taintedValues['new_option']['et']['name']) === 0 ) ) ) {

			unset($this->embeddedForms['new_option'], $taintedValues['new_option']);
			// pass the new form validations
			$this->validatorSchema['new_option'] = new sfValidatorPass();
	
		} else {

			$this->embeddedForms['new_option']->getObject()->
	                setParameter($this->getObject());
			
		}
		
//		$taintedValues['multilang'] = $taintedValues['multilang'] == 'on' ? 'off' : 'on';
		// call parent bind method
		parent::bind($taintedValues, $taintedFiles);
	
	}
	
 
	

	


	public function getSubTemplate(){
		
	  	if( !$this->isNew() ){
	  		if( $this->getObject()->getMultilang() ){
	  			return 'parameter/multilangform';
	  		}else{
	  			return 'parameter/singlelangform';
	  		}	
  		}
  		
	}
}
