<?php

class myUser extends sfFacebookUser 
{
	public $defaultCurrency = false;
	public $persistanceObject = false;
	
	public function setCurrency( Currency $cur ){
		$this->setAttribute('currency.selected', $cur );
	}
	
	public function getCurrency(){
		if( $this->hasAttribute('currency.selected') )
			return $this->getAttribute('currency.selected' );
		else
			return $this->getDefaultCurrency();
	}
	
	protected function getDefaultCurrency(){
		if( !$this->defaultCurrency )
			$this->defaultCurrency = Doctrine::getTable('Currency')->findOneByFactor(1);
		
		return $this->defaultCurrency;
	}
	
	
	public function authAs(PublicUser $user){
		$this->setAuthenticated(true);
		
		$this->setAttribute('user.id', $user['id']);
		$this->setObject($user);
	}
	
	public function isMyOrder($order){
		return	$order instanceof ProductOrder && 
				$order->getPublicUser()->getId() == $this->getObject()->getId();
	}
	
	
	
	public function setObject(PublicUser $user){
		$this->persistanceObject = $user;
	}
	
	public function getObject(){
		if( !$this->persistanceObject ){
			$this->persistanceObject = Doctrine::getTable('PublicUser')->find( $this->getAttribute('user.id') );
		}
		
		return $this->persistanceObject; 
	}
	
	public function logOut(){
		$this->setAuthenticated(false);
	}
	
}
