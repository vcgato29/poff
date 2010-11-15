<?php

class ShippingTransportForm extends BaseProductOrderShippingForm{
	
	public $mappedAddress = false;
	
	public function configure(){
		
		$this->widgetSchema['title'] = new sfWidgetFormInput();
		$this->widgetSchema['address'] = new sfWidgetFormInput();
		$this->widgetSchema['city'] = new sfWidgetFormInput();
		$this->widgetSchema['country'] = new sfWidgetFormInput();
		$this->widgetSchema['shipping_zone_id'] = new sfWidgetFormInput(); // is NOT hidden because is SPECIAL holder on JS dropdown
		$this->widgetSchema['order_id'] = new sfWidgetFormInputHidden();
		

		$this->validatorSchema['title'] = new sfValidatorPass(); // used in dropdown as address Name
		
		$this->validatorSchema['name'] = new sfValidatorString( array('required' => true, 'max_length' => 255, 'min_length' => 2 ), 
																	array('required' => 'Name is required', 
																		  'min_length' => 'Name is too short', 
																		  'max_length' => 'Name is too long') );
																	
		$this->validatorSchema['city'] = new sfValidatorString( array('required' => true, 'max_length' => 100, 'min_length' => 3 ), 
																	array('required' => ' City is required',
																		  'min_length' => 'City is too short', 
																		  'max_length' => 'City is too long') );
																	
		$this->validatorSchema['country'] = new sfValidatorString( array('required' => true, 'max_length' => 100, 'min_length' => 3 ), 
																	array('required' => ' Country is required', 
																		  'min_length' => 'Country is too short', 
																		  'max_length' => 'Country is too long') );
																	
		$this->validatorSchema['address'] = new sfValidatorString( array('required' => true, 'max_length' => 100, 'min_length' => 3 ), 
																	array('required' => 'Address is required', 
																		  'min_length' => 'Address is too short', 
																		  'max_length' => 'Address is too long') );

		$this->validatorSchema['shipping_zone_id'] = new sfValidatorDoctrineChoice(array('model' => 'ShippingZone'), array('required' => 'Select shipping type'));

	}
	
	static function mapTo($address, $object = null){
		
		if(!$object){
			$object = new ProductOrderShipping();
			$object->fromArray(array('name' => $address['name']));
		}else{
			$object->setName($address['name']);
		}
		
		$form = new ShippingTransportForm($object);
		
		
		$form->mappedAddress = $address;
		$form->setDefaults(array_merge($address->toArray(), $form->getDefaults()));
		
		return $form;	
	}
	
	public function getAddressId(){
		return $this->mappedAddress['id'];
	}
	
	public function getTitle(){
		return $this->mappedAddress['title'];
	}
	
	public function updateObject($values = null){

		$zone = Doctrine::getTable('ShippingZone')->find($values['shipping_zone_id']);
		
		$this->getObject()->setInformation( $zone['name'] . ';' .
											$values['address'] . ';' . 
											$values['city'] . ';' . 
											$values['country']);
											
		$this->getObject()->setName($values['name']);
		
	
		$interval = BasketCheckedOut::getInstance($values['order_id'])->shippingZoneInterval($values['shipping_zone_id']);
		$this->getObject()->setMassIntervalStart($interval['start']);
		$this->getObject()->setMassIntervalEnd($interval['end']);
		$this->getObject()->setCost($interval['price']);
		
		// parent::updateObject($values); // DO NOT USE here, or values will not save. If appears need THEN replace logic from this method to OrderingForm class
	}
}