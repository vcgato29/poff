<?php

class OrderingForm extends BaseProductOrderForm{
	
	
	protected static $shippingTypes = array('shipping', 'shop');
	protected static $paymentMethods = array('master', 'visa', 'seb', 'swed', 'nordea');
	
	public function configure(){ 
		# unset not needed fields
		unset($this['created_at'], $this['updated_at'], $this['order_number'], $this['public_user_id'], $this['status']);
		
		# set additional fields
		$this->widgetSchema['shipping_type'] = new sfWidgetFormInputHidden();
		$this->widgetSchema['shipping_type']->setDefault(self::$shippingTypes[0]);
		$this->widgetSchema['accept_terms_and_conditions'] = new sfWidgetFormInputHidden();
		$this->widgetSchema['payment_type'] = new sfWidgetFormInputHidden();
		
		# set validators
		$this->validatorSchema['shipping_type'] = new sfValidatorChoice(array('choices' => self::$shippingTypes));
		
		$this->validatorSchema['accept_terms_and_conditions'] = new sfValidatorChoice( array('choices' => array('1', 'true', 1, true)), 
																						array('required' => 'Accept terms and conditions.', 'invalid' => 'Accept terms and conditions.') );
																						
		
		$this->validatorSchema['payment_type'] = new sfValidatorChoice(array('required' => true,'choices' => self::$paymentMethods),
																			array('required' => 'Select payment method.'));


		# embed forms
		
		// embedding 'billing information' form
		$billingAddress = $this->getObject()->BillingAddress;
		$userinfo = $this->getObject()->getPublicUser()->toArray();
		$billingAddressArr = array( 'city' => $userinfo['city'],	// map user info to ProductOrderBilling object
									'street' => $userinfo['address1'],
									'country' => $userinfo['country'],
									'zip' => $userinfo['zip'],
									'receiver' => $userinfo['name'],
									'email' =>  $userinfo['email'] );
		
		$billingAddress->fromArray( $billingAddressArr );
		$this->embedForm( 'billing' , new FrontendProductOrderBillingForm($billingAddress));
		
		// embedding 'shipping transport' form
		
		$transportForm = ShippingTransportForm::mapTo($this->getObject()->getPublicUser()->Addresses[0], $this->getObject()->getShippings()->getFirst());
		$this->embedForm('shipping_transport', $transportForm );
		
		// embedding 'shpping shop' form
		$this->embedForm('shipping_shop', new ShippingShopForm($this->getObject()->getShippings()->getFirst()) );
		
	}
	
	public function bind(array $taintedValues = null, array $taintedFiles = null){
		
		if($taintedValues['shipping_type'] == 'shipping')
			unset($this['shipping_shop'], $taintedValues['shipping_shop']);
		else{
			unset($this['shipping_transport'], $taintedValues['shipping_transport']);
			
		}
			
		return parent::bind($taintedValues, $taintedFiles);
	}
	
	public function getShippingAddressesForms(){
		$forms = array();
		
		# add empty address
		$address = new PublicUserAddresses();
		$address->fromArray(array('title' => '-' ));
		$forms[] = ShippingTransportForm::mapTo($address);
		
		# add user addresses
		foreach($this->getObject()->getPublicUser()->Addresses as $address){
			$forms[] = ShippingTransportForm::mapTo($address);;
		}
	
		
		return $forms;
	}
	
	
	public function updateObject($values = null){
		$object = parent::updateObject($values);
		$this->object->setType($this->getValue('payment_type'));
		$this->object->setPriceCurrency(Currency::getCurrencyByAbbr(Currency::DEFAULT_CURRENCY)->getAbbr());
		
		return $object;
		
	}
	
	public function updateObjectEmbeddedForms($values, $forms = null){
		if(isset($this['shipping_transport'])){
			$this->getEmbeddedForm('shipping_transport')->updateObject($values['shipping_transport']);
		}elseif(isset($this['shipping_shop'])){
			$this->getEmbeddedForm('shipping_shop')->updateObject($values['shipping_shop']);
		}
		
		
		
		return parent::updateObjectEmbeddedForms($values, $forms);
	}
	
	
	public function getErrorsAssociatedToFieldIDs(){
		
		$result = array();
		
		foreach($this as $index => $field){
				if($field->hasError()){
					
					if($field instanceof sfFormFieldSchema){
						foreach($field as $index2 => $field2){
							if($field2->hasError())
								$result[$field2->renderId()] = $field2->getError()->__toString();
						}
					}else{
						$result[$field->renderId()] = $field->getError()->__toString();
					}		
				}
			}	
			
		return $result;
	}
	
}