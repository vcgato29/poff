<?php
require_once dirname(__FILE__).'/../../articlesLeftMenuWidget/actions/components.class.php';
require_once dirname(__FILE__).'/../lib/CategoriesLeftMenuHelper.class.php';

class categoriesLeftMenuWidgetComponents extends articlesLeftMenuWidgetComponents
{

	static $activeNodes = false;

	public function executeRender(){

		parent::executeRender();
		$this->params = $this->getVarHolder()->getAll();

                if(!$this->getAction()->getRoute()->getCategoryObject()){
                    $this->getAction()->redirect($this->params['secondLevelMenuItems'][0]['link']);
                }


	}



  protected function getSecondLevelMenuItems(){
  	$result = array();
  	// OLLY HAS ONLY 1 level of categories
  	foreach($this->getMenuItemFetchingQuery()->execute() as $group){


		if( $this->helper->hiddenNode( $group ) )continue;

  		$item = $group->toArray();

  		unset($item['__children']);
  		$item['title'] = $group->getName();
  		$item['link'] = $this->getAction()->getComponent('linker', 'category', array('category' => $group));
  		$item['object'] = $group;


                $q = $group->getAssociatedProductsQuery();
				// join translations of active culture
				$q->innerJoin($q->getRootAlias(). ".Translation tt ")
							->where("tt.name != '' AND tt.lang = ?", $this->getUser()->getCulture());

				if($this->getRoute()->getCategoryObject() &&
						$this->getRoute()->getCategoryObject()->getId() == $group['id'])
                    foreach($q->execute() as $child){
                            $child_item = $child->toArray();
                            $child_item['link'] = $this->getAction()->getComponent('linker', 'product', array('product' => $child, 'category' => $group));
                            $child_item['title'] = $child['name'];
                            $child_item['item_type'] = 'product';
                            $child_item['object'] = $child;
                            $item['__children'][] = $child_item;
                    }


                    //if(!empty($item['__children']))
                        $result[] = $item;
  	}




  	return $result;

  }

  protected function getHelper(){
  	return new CategoriesLeftMenuHelper();
  }

  protected function getCurrentStructureNode(){
  	return $this->getRoute()->getObject();
  }

  protected function getActiveMenuItemsIDs(){

  	if(!self::$activeNodes){
	  	if($this->getRoute()->getCategoryObject()){
			$cur = array($this->getRoute()->getCategoryObject()->getId());
			//self::$activeNodes = array_merge($this->getRoute()->getCategoryObject()->getNode()->getAncestors()->getPrimaryKeys(), $cur );
	  	}else{
	  		self::$activeNodes = array();
	  	}
  	}
  	return self::$activeNodes;
  }

  protected function getMenuItemFetchingQuery(){
  	$q = Doctrine::getTable('ProductGroup')->createQuery('categoriesMenu')
				->from('ProductGroup c')
				->andWhere('c.level >= ? AND c.level < ?', array(1,3))
				->orderBy('c.lft asc')
				->setHydrationMode(Doctrine::HYDRATE_RECORD_HIERARCHY);

	//echo $this->getRoute()
	return Doctrine::getTable('ProductGroup')->addFrontendViewConstraints($q, $this->getUser()->getCulture());
  }

  protected function redirectToNextItem(){
  	return false;
  }

  protected function activeItem(){
  	return false;
  }



}