<?php

class queryHelper{




	public function link($action){

		if(($product = $this->getAction()->getRoute()->getProductObject())){
			return $this->getAction()->getComponent('linker', 'product', array(
					'module' => 'query',
					'action' => $action,
					'product' => $product,
					'category' =>  $this->getAction()
						->getRoute()->getCategoryObject()
			));
		}

			return $this->getAction()->getComponent('linker',
				'productActions', array(
					'action' => $action
			));


		
	}


	public function getAction(){
		return sfContext::getInstance()
							->getController()
		      				->getAction( 'query', 'simple' );
	}


	
	public function useExtendedMenu($sf_request){
		$product = $this->getAction()->getRoute()->getProductObject();
		return !$product || $product['parameter'] == 'roof_product';
	}


	public function getContactAction($sf_request){
		return 'simple';
	}


	

}