<?php

/**
 * ParameterSelectionSingle
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    jobeet
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 6820 2009-11-30 17:27:49Z jwage $
 */
class ParameterSelectionSingle extends BaseParameterSelectionSingle
{
	public $editForm = null;
	
	
	public function getEditForm()
	{
		if( $this->editForm == null )
			$this->editForm = new ParameterSelectionSingleForm( $this );
			
		return $this->editForm;
	}
	
  public function createAndGetParamValueForm( $product = null ){

  	$form = new ParameterSelectionOptionsContainerForm( $product, array(), false );
  	$form->setParameter( $this );
  	$form->configure();
  	$this->setParamValueForm( $form );
  	
  	return $this->getParamValueForm();
	
	
  	
  }
  

	

	
	
	

}