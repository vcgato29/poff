<?php

class myBasket{
	
	static $instance = false;
	
	const SHIPPING_PRICE = 1;
	const TOTAL_NO_SHIPPING = 2;
	const TOTAL_PAYABLE = 3;
	
	private function __construct(){}
	
	static function getInstance(){
		if(!self::$instance){
			self::$instance = new myBasket();
		}
		
		return self::$instance;
	}
	
	
	public function addProduct($productID, $qty = 1){
		if( !Doctrine::getTable('Product')->find($productID) ) return false;
		
		if($qty <= 0)$qty = 1;
		
		$products = array();
		if($this->getUser()->hasAttribute('basket.products')){
			$products = $this->getUser()->getAttribute('basket.products');
		}
		
		$products[$productID] = isset($products[$productID]) && is_integer($products[$productID]) ? $products[$productID] + $qty : $qty;
		
		$this->getUser()->setAttribute('basket.products', $products);
		return true;
	}
	
	public function getProducts(){
		return $this->getUser()->getAttribute('basket.products', array());
	}
	
	public function prepareDataForView(){		
		$result = array();
		
		$pks = array(-1);

		foreach($this->getProducts() as $ID => $quanity)
				$pks[] = $ID;
		
		$q = Doctrine::getTable('Product')->createQuery('basketProds')
						->from('Product p')
						->innerJoin('p.Translation t')
						->leftJoin('p.ProductPictures pp')
						->orderBy('p.pri asc')
						->addOrderBy('pp.pri asc')
						->whereIn('p.id', $pks);
						
		$basketInfo = $this->getProducts();
		foreach($q->execute() as $item){
			$ar['product'] = $item;
			$ar['quanity'] = $basketInfo[$item->getId()];
			
			$result[] = $ar;
		}
			
		return $result;
	}
	
	
	public function countItems(){
		$result = 0;

		foreach($this->getProducts() as $id => $q){
			$result += $q;
		}
		
		return $result;
	}
	
	public function deleteProduct($id){
		$ar = $this->getProducts();
		unset($ar[$id]);
		
		$this->setProducts($ar);
		return true;
	}
	
	public function changeAmount($productID, $qty = 1){
		if($qty <= 0) $qty = 1;
		
		if($this->getUser()->hasAttribute('basket.products')){
			$products = $this->getUser()->getAttribute('basket.products');
		}else{
			return;
		}
		
		$products[$productID] = $qty;
		$this->getUser()->setAttribute('basket.products', $products);

	}
	
	public function isEmpty(){
		return  $this->getProducts() ? false : true;
	}
	
	public function getTotalPrice(){
		$result = 0;
		foreach($this->prepareDataForView() as $prod)
			$result += ($prod['quanity'] * $prod['product']['price_actual']);
		return $result;
	}
	
	private function setProducts( array $products ){
		$this->getUser()->setAttribute('basket.products', $products);
	}
	
	private function getUser(){
		 return sfContext::getInstance()->getUser();
	}
	
	
	public function checkout(){
		return Doctrine::getTable('ProductOrder')->checkout($this->getProducts(),$this->getUser()->getObject(),  $this->getUser()->getCurrency() );
	}
		
}