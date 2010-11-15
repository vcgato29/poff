<?php
require_once dirname(__FILE__).'/../../categoriesLeftMenuWidget/lib/CategoriesLeftMenuHelper.class.php';

class categoryPageActions extends myFrontendAction{
	
//	static $showByAr = array( 1,6,9,12,15);
//	static $showIn = array('list' => 'maincontent', # request value (stored in user session) => CSS class for products container
//                                'grid' => 'maincontent2');
	
//	public function executeTest(){
//		$this->getRoute()->getObject();
//	}
//
//	public function preExecute(){
//		parent::preExecute();
//		$this->setLayout('layout_widgets_off');
//	}


        public function executeIndex(sfWebRequest $request){
            
        }
									
	
//	public function executeIndex( sfWebRequest $request ){
//
//
//
//
//		$this->pager = new sfDoctrinePager( 'Product', $this->getShowBy() );
//
//
//
//		$this->showView = self::$showIn[ $this->getShowIn()]; // class in HTML container and PARTIAL included
//		$this->currentView = $this->getShowIn(); // grid or list
//		$this->showInAr = self::$showIn; // all possible views
//
//		$this->category = $this->getRoute()->getCategoryObject();
//		$this->perPage = $this->getShowBy();
//		$this->perPageAr = self::$showByAr;
//
//  		$this->pager->setQuery( $this->getCategoryProductsQuery() );
//  		$this->pager->setPage($request->getParameter('page', 1));
//  		$this->pager->init();
//
//  		if($this->pager->getNbResults() == 0){ // 3. redirect to first child if no PRODUCTS, but there are active SUB CATEGORIES
//  			$helper = new CategoriesLeftMenuHelper();
//  			if($this->category->getNode()->hasChildren())
//	  			foreach($this->category->getNode()->getChildren() as $child){
//	  				if(!$helper->hiddenNode($child)){
//	  					$this->redirect($this->getComponent('linker', 'category', array('category' => $child)));
//	  				}
//	  			}
//  		}
//
//
//	}
//
//	protected function getShowBy(){
//		if($this->getUser()->getAttribute('showby')){
//			return $this->getUser()->getAttribute('showby');
//		}else
//			return 6;
//	}
//
//	protected function getShowIn(){
//		if($this->getUser()->getAttribute('showin')){
//			return $this->getUser()->getAttribute('showin');
//		}else
//			return 'list';
//	}
//
//	protected function getSort(){
//		if( $this->getUser()->getAttribute('sort') ){
//			return $this->getUser()->getAttribute('sort');
//		}else{
//			$keys = array_keys( $this->sorting );
//			return $keys[0];
//		}
//	}
//
//	private function getCategoryProductsQuery(){
//
//		$q = Doctrine::getTable('Product')
//					->getAssociatedToCategoryProductsQuery( $this->getRoute()->getCategoryObject()->getId() );
//		$q->orderBy($q->getRootAlias() . '.pri asc');
//
//		return $this->setCategoryQueryConstraints($q);
//	}
//
//	protected function setCategoryQueryConstraints( Doctrine_Query $q ){
//		$q->innerJoin($q->getRootAlias().'.Translation t');
//
//		Doctrine::getTable('Product')->addProductPicturesJoin( $q );
//
//		return $q;
//	}
//
	  
}