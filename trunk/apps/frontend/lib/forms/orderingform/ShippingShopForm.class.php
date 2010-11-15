<?php
class ShippingShopForm extends BaseProductOrderShippingForm{
	public function configure(){
		$this->widgetSchema['shop'] = new sfWidgetFormInput();
		$this->widgetSchema['order_id'] = new sfWidgetFormInputHidden();
		
		
		$this->validatorSchema['shop'] = new sfValidatorDoctrineChoice(array('model' => 'Shop'), array('required' => 'Select shop'));
	}
	
	public function updateObject($values = null){
		
		$shop = Doctrine::getTable('Shop')->find($values['shop']);
		$this->getObject()->setInformation( $shop['title'] . ";" . $shop['address'] );
		$this->getObject()->setName( $this->getObject()->ProductOrder->BillingAddress->getReceiver() );
		
		$this->getObject()->setCost(0);
		$this->getObject()->setMassIntervalStart(0);
		$this->getObject()->setMassIntervalEnd(0);
		
		// parent::updateObject($values); // DO NOT USE here, or values will not save. If appears need THEN replace logic from this method to OrderingForm class
	}
}