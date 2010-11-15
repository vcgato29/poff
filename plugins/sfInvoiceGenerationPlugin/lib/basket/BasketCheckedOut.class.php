<?php
class BasketCheckedOut{
	
	static $map = array();
	
	const SHIPPING_PRICE = 1;
	const TOTAL_NO_SHIPPING = 2;
	const TOTAL_PAYABLE = 3;
	
	private $order = false;
	
	private function __construct(ProductOrder $order){
		$this->order = $order;
	}
	
	static function getInstance($orderID){
		if(!isset(self::$map[$orderID])){
			self::$map[$orderID] = new BasketCheckedOut(Doctrine::getTable('ProductOrder')->find($orderID));
		}
		
		return self::$map[$orderID];
	}

	
	public function shippingCost($zoneID){
		$interval = $this->shippingZoneInterval($zoneID);
		return $interval['price'];
	}
	
	public function shippingZoneInterval($zoneID){
		if($zoneID){
			$mass = $this->getOrderMass(Doctrine::getTable('ProductOrder')->find($this->getOrder()->getId()));
			foreach(Doctrine::getTable('ShippingZone')->find($zoneID)->Intervals as $interval){
				if($interval['start'] <= $mass && $interval['end'] >= $mass) return $interval;
			}
		}
		return array('start' => 0, 'end' => 1000000000, 'price' => 0);	
	}
	
	
	
	
	public function price($type = myBasket::TOTAL_PAYABLE){
		$result = 0;
		
		switch($type){
			case myBasket::TOTAL_PAYABLE:
				$result = $this->getTotalPayable($this->getOrder());
				break;
			case myBasket::TOTAL_NO_SHIPPING:
				$result = $this->getTotalWithoutShipping($this->getOrder());
				break;
			case myBasket::SHIPPING_PRICE:
				$result = $this->getShippingPrice($this->getOrder());
				break;
			default:
				throw new Exception('wrong price type');
		}

		return $result;
	}
	
	
	public function prepareDataForView(){
		$result = array();
		
		foreach($this->getOrder()->OrederedItems as $item){
			$ar['product'] = $item->toArray();
			$ar['product']['ProductPictures'][0]['file'] = $item->getProduct()->ProductPictures[0]['file'];
			$ar['product']['price_actual'] = $item['price'];
			$ar['quanity'] = $item['quanity'];
			$result[] = $ar;
		}
		
		return $result;
	}
	
	private function getOrderMass(){
		$mass = 0;
		foreach($this->getOrder()->OrederedItems as $item){
			$mass = $mass + $item['mass'];
		}
		
		return $mass;
	}
	
	private function getShippingPrice(){
		return $this->getOrder()->Shippings[0]['cost'];
	}
	
	private function getTotalPayable(){
		return $this->getShippingPrice() + $this->getTotalWithoutShipping();
	}
	
	private function getTotalWithoutShipping(){
		$price = 0;
		foreach($this->getOrder()->OrederedItems as $item){
			$price += $item['quanity'] * $item['price'];
		}
		return $price;
	}
	
	public function getOrder(){
		return $this->order;
	}
	
}