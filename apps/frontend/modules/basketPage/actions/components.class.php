<?php

class basketPageComponents extends myComponents{
	public function executeBasket(){
		$this->itemsInBasket = myBasket::getInstance()->isEmpty() ? false : myBasket::getInstance()->prepareDataForView();
		$this->totalItems = myBasket::getInstance()->countItems();
		$this->totalPrice = myBasket::getInstance()->getTotalPrice();
		
	}
}