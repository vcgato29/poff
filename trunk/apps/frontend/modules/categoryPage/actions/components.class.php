<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of components
 *
 * @author aneto
 */
class categoryPageComponents extends myComponents {

	private $activeCategory;


	public function executeRender(){
	    $this->activeProductGroup = $this->getActiveCategory();
	    if($this->getRoute()->getProductObject()) $this->checkProduct = 1;
	    if($this->activeProductGroup) {
			$this->pager = new sfDoctrinePager( 'Product', $this->getShowBy() );
	  		$this->pager->setQuery( $this->getProductsQuery() );
	  		$this->pager->setPage($this->getRequestParameter('page', 1));
	  		$this->pager->init();
        }
        else $this->productGroups = $this->getCategoriesQuery()->execute();

	}



	protected function getShowBy(){
		if($this->getUser()->getAttribute('showby')){
			return $this->getUser()->getAttribute('showby');
		}else
			return 999;
	}


	protected function getSort(){
		if( $this->getUser()->getAttribute('sort') ){
			return $this->getUser()->getAttribute('sort');
		}else{
			$keys = array_keys( $this->sorting );
			return $keys[0];
		}
	}

	private function getCategoriesQuery(){
		return Doctrine_Query::create()
			->select('pg.*')
			->addSelect('pgt.slug as slug')
			->from('ProductGroup pg')
			->innerJoin('pg.Translation pgt WITH pgt.lang = ?', $this->getUser()->getCulture())
			->innerJoin('pg.Products pconn')
			->innerJoin('pconn.Product p')
			->innerJoin('p.Translation pt WITH pt.lang = ?',  $this->getUser()->getCulture());

	}

	private function getActiveCategory(){
		if($this->activeCategory)
			return $this->activeCategory;

		if($this->getRoute()->getCategoryObject()){
			$this->activeCategory = $this->getRoute()->getCategoryObject();
		}else{
			//$this->activeCategory = $this->getCategoriesQuery()->execute()->getFirst();
		}

		return $this->activeCategory;

	}

	private function getProductsQuery(){
		return
			Doctrine_Query::create()
			->select('p.*, pt.*, pp.*')
			->from('Product p')
			->innerJoin('p.Translation pt WITH pt.lang = ?', $this->getUser()->getCulture())
			->innerJoin('p.ProductGroups pgconn')
			->innerJoin('pgconn.ProductGroup pg WITH pg.id = ?', $this->getActiveCategory()->getId())
			->orderBy("pt.name asc")
			->leftJoin('p.ProductPictures pp WITH pp.parameter = ?', 'default');

	}

}