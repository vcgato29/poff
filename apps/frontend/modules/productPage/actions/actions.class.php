<?php
require_once dirname(__FILE__).'/../lib/ProductPageHelper.class.php';

class productPageActions extends myFrontendAction{

	public function preExecute(){
		parent::preExecute();

		$this->setLayout('layout_widgets_off');

		$this->product = $this->getProductObject();
		$this->category = $this->getRoute()->getCategoryObject();


	}


	/* product page */
	public function executeIndex(sfWebRequest $request){
		$this->linastused = $this->parseProductExemplars();
		$this->userLinastused = $this->parseUserProductExemplars();
	}


	private function parseUserProductExemplars(){
		if($this->getUser()->isAuthenticated()){
			return $this->getUser()->getObject()->getLinastused();
		}else{
			return false;
		}
	}

	private function parseProductExemplars(){
		return
			Doctrine_Query::create()
			->from('ProductExemplar pe')
			->where('pe.product_id = ?', $this->product['id'])
			->innerJoin('pe.Translation pet WITH pet.lang = ?', $this->getUser()->getCulture())
			->orderBy('pe.scheduled_time asc')
			->execute();
	}

	private function getProductObject(){
		return
			Doctrine_Query::create()
			->from('Product p')
			->leftJoin('p.Translation pt')
			//->leftJoin('p.ProductPictures pp WITH pp.parameter = ?', 'default')
			->leftJoin('p.ProductPictures pp')
			->where('p.id = ?',$this->getRoute()->getProductObject()->getId())
			->fetchOne();

	}

}