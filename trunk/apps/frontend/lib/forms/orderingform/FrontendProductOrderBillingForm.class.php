<?php

class FrontendProductOrderBillingForm extends BaseProductOrderBillingForm{
	public function configure(){
		
		$this->widgetSchema['order_id'] = new sfWidgetFormInputHidden();
		
		$this->validatorSchema['receiver'] = new sfValidatorString( array('required' => true, 'max_length' => 20, 'min_length' => 2 ), 
																	array('required' => 'Name is required', 
																		  'min_length' => 'Name is too short', 
																		  'max_length' => 'Name is too long') );
																	
		$this->validatorSchema['email'] = new sfValidatorEmail( array('required' => true), 
																	array('required' => 'Email is required', 
																		  'invalid' => 'Wrong email format') );
																	
		$this->validatorSchema['city'] = new sfValidatorString( array('required' => true, 'max_length' => 100, 'min_length' => 3 ), 
																	array('required' => ' City is required', 
																		  'min_length' => 'City is too short', 
																		  'max_length' => 'City is too long') );
																	
		$this->validatorSchema['street'] = new sfValidatorString( array('required' => true, 'max_length' => 100, 'min_length' => 3 ), 
																	array('required' => ' Street is required', 
																		  'min_length' => 'Street is too short', 
																		  'max_length' => 'Streeet is too long') );
																	
		$this->validatorSchema['zip'] = new sfValidatorString( array('required' => true, 'max_length' => 10, 'min_length' => 2 ), 
																	array('required' => ' Zip is required', 
																		  'min_length' => 'Zip is too short', 
																		  'max_length' => 'Zip is too long') );
																	
		
	}
}