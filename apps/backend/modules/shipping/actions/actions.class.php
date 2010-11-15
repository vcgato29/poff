<?php

require_once dirname(__FILE__).'/../lib/shippingGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/shippingGeneratorHelper.class.php';


class shippingActions extends autoShippingActions
{
	
	/* shipping zone actions are stored in parent class */
	#...
	
	public function executeNewInterval(){
		$this->setLayout('popuplayout');
		
		$this->zone = $this->getShippingZone();
		
		$interval = new ShippingZoneInterval();
		$interval->ShippingZone = $this->zone;
		
		
		$this->form = new ShippingZoneIntervalForm($interval);
		
	}
	
	public function executeCreateInterval(){
		$this->setLayout('popuplayout');
		
		$this->form = new ShippingZoneIntervalForm();
		
		if( $this->processShippingZoneForm($this->form) ){
			$this->getUser()->setFlash('notice','shipping zone interval created.');
			
			return $this->renderPartial('global/closePopup');
		}else{
			
			$this->getUser()->setFlash('error', 'fill form corretly');
			
			$this->setTemplate('newInterval');
		}

	}
	
	
	
	public function executeEditInterval(){
		$this->setLayout('popuplayout');
		$this->form = new ShippingZoneIntervalForm( $this->getShippingInterval() );
		

	}
	
	public function executeUpdateInterval(){
		$this->setLayout('popuplayout');
			
		$this->form = new ShippingZoneIntervalForm( $this->getShippingInterval());

		if( $this->processShippingZoneForm($this->form) ){
			$this->getUser()->setFlash('notice','shipping zone interval updated.');
			
			return $this->renderPartial('global/closePopup');
		}else{
			$this->getUser()->setFlash('error', 'fill form corretly');
			
			$this->setTemplate('editInterval');
		}
	}
	
	
	public function executeDeleteInterval(){
		$this->setLayout('popuplayout');
		
		$this->getShippingInterval()->delete();
		
		return $this->redirect($this->getRequest()->getReferer());
	}
	
	
	
	protected function processShippingZoneForm( $form ){
		
		$form->bind( $this->getRequestParameter($form->getName()) );
		
		if( $form->isValid() ){
			return $form->save();
		}
		
		return false;
	}
	
	protected function getShippingZone(){
		return Doctrine::getTable('ShippingZone')->find( $this->getRequestParameter('zoneID') );
	}
	
	protected function getShippingInterval(){
		return	Doctrine::getTable('ShippingZoneInterval')
					->find($this->getRequestParameter('intervalID'));
	}
}
