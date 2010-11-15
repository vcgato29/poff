<?php

class ParameterSelectionOptionsContainerForm extends ProductForm
{
	public $options = array();
	public $parameter = null;
	public $langs = array();
	

  public function configure(){
  	
    if( !$this->getParameter() )
    	return;
  	

    $this->widgetSchema['parameter_options_list'] = new sfWidgetFormDoctrineChoice(
    			array(	'multiple' => $this->isMultiple(), 
    					'model' => 'ParameterOption', 
    					'query' => $this->getQuery(), 
    					'method' => 'getTitleForForm' ));
    			
    $this->validatorSchema['parameter_options_list'] = new sfValidatorPass();  
    		//new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'ParameterOption', 'required' => false, 'query' => $query));
    		
	
    	
   $this->useFields( array('parameter_options_list', 'id') );
    
  }
  
  
  public function getQuery(){
	return Doctrine_Query::create() 
			->from('ParameterOption po')
			->select('po.title')
			->where('po.param_id = ?', $this->getParameter()->getId());
  }
  
  public function doSave( $con = null ){
  	
  		$pk = $this->getQuery()->execute()->getPrimaryKeys();
		
  		
  		Doctrine_Query::create() 
			->delete('ParameterProductOption ppo')
			->where('product_id = ?' , $this->getObject()->getId() )
			->whereIn('option_id', $pk )
			->execute();

		if( is_array( $this->getValue('parameter_options_list') ) ){
				foreach( $this->getValue('parameter_options_list') as $paramOptionID ){
					$ppo = new ParameterProductOption();
					$ppo->fromArray( array( 'product_id' => $this->getObject()->id, 
											'option_id' => $paramOptionID ) );
					$ppo->save();
				}	
		}else{
					$ppo = new ParameterProductOption();
					$ppo->fromArray( array( 'product_id' => $this->getObject()->id, 
											'option_id' => $this->getValue('parameter_options_list') ) );
					$ppo->save();
		}
		
			
  }
  
  
  
  public function isMultiple(){  	
  	return $this->getParameter()->getType() == 'MANY_OPTIONS';
  }
  
  
  public function getEditFormRendereringTemplate(){	
  	return "singlelang_selection";
  }
	
  
  
  public function getParameter(){
  	return $this->parameter;
  }
  
  public function setParameter( $parameter ){
  	$this->parameter = $parameter;
  }
  
  
  public function getLanguages(){
  	return $this->langs;
  }
  
  
  public function setLanguages( array $langs ){
  	
  	$this->langs = $langs;
  	
  }
  
  
}
