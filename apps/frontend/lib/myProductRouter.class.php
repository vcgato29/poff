<?php

class myProductRouter  extends myCategoryRouter implements AppRoutingDesc{
	
	private $product = false;
	
	protected function getObjectsForParameters($parameters){
		print_r($parameters);
		exit;
		//return new Doctrine_Collection('Structure','id');
	}
	
	public function getProductObject(){
		if(!$this->product){
			$params = $this->getParameters();
			
			if(isset($params['product_slug'])){
				$q =	Doctrine::getTable('Product')->createQuery()
							->from('Product p')
							->leftJoin('p.ProductPictures pp')
							->innerJoin('p.Translation pt')
							->where('pt.slug = ?', $params['product_slug']);
					
				$this->product = $q->execute()->getFirst();
			}else{
				$this->product = false;
			}
		}
		
		return $this->product; 
	}
	
}