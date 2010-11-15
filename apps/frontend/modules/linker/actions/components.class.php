<?php

class linkerComponents extends myComponents{

	static $myOrdersLinkInfo;

	static $mySettingsLinkInfo;

	static $myCategory;
	static $myCategoryStructure;

	static $myProductStructure;
	static $myProductCategoriesMap = array();

	static $myNewsStructure;

	static $myBasketStructure;

	static $structureMap;

	static $myStructureActions;




	public function executeProceedToPayment(){
		$params = $this->getVarHolder()->getAll();
		$params['orderID'] = $params['order']['id'];
		$params['action'] = 'proceedToPayment';
		unset($params['order']);
		$this->params = $params;
	}

	public function executeVerifyPayment(){
		$params = $this->getVarHolder()->getAll();
		$params['orderID'] = $params['order']['id'];
		$params['action'] = 'proceedToPayment';
		$params['p0'] = $this->getRoute()->getObject()->getLang();
		unset($params['order']);
		$this->params = $params;

	}

        public function executeNewsItem(){
            //if(!self::$myNewsStructure){
                if(isset($this->newsItem['link_to_struct']) and !empty($this->newsItem['link_to_struct']) and Doctrine::getTable('Structure')->findOneByIdAndLang($this->newsItem['link_to_struct'], $this->getRoute()
																					->getObject()
																					->getLang()))
					self::$myNewsStructure = $this->prepareStructureNodeParams( Doctrine::getTable('Structure')->findOneByIdAndLang($this->newsItem['link_to_struct'], $this->getRoute()
																					->getObject()
																					->getLang()) );

				elseif(Doctrine::getTable('Structure')->findOneByParameterAndLang('news', $this->getRoute()
																					->getObject()
																					->getLang()))
					 self::$myNewsStructure = $this->prepareStructureNodeParams( Doctrine::getTable('Structure')->findOneByParameterAndLang('news', $this->getRoute()
																					->getObject()
																					->getLang()) );

          //  }
          if(!self::$myNewsStructure) {

             if(isset($this->newsItem['link_to_struct']) and !empty($this->newsItem['link_to_struct']) and Doctrine::getTable('Structure')->findOneById($this->newsItem['link_to_struct']))
					self::$myNewsStructure = $this->prepareStructureNodeParams( Doctrine::getTable('Structure')->findOneById($this->newsItem['link_to_struct']) );
          	else self::$myNewsStructure = $this->prepareStructureNodeParams( Doctrine::getTable('Structure')->findOneByParameter('news') );


           }


            $params = $this->getVarHolder()->getAll();
            unset($params['newsItem']);

            $this->params = array_merge($params, self::$myNewsStructure, array('slug' => $this->newsItem['slug']));
        }

        public function executeNewsArchive(){

			$nodeAr =	array('node' => Doctrine::getTable('Structure')->findOneByParameterAndLang('news', $this->getRoute()
																					->getObject()
																					->getLang()));


			$this->params = array_merge($this->getVarHolder()->getAll(), $nodeAr );

			//print_r($this->params['node']->toArray());
			//exit;

        }

	public function executeCategory(){
		if(!self::$myCategoryStructure){
			self::$myCategoryStructure = $this->prepareStructureNodeParams( Doctrine::getTable('Structure')->findOneByParameterAndLang('productCatalog', $this->getRoute()
																					->getObject()
																					->getLang()) );
		}

		$params = $this->getVarHolder()->getAll();
		unset($params['category']);

		$result = array();
		$this->prepareProductCategoryParams($this->category, $this->fetchProductCategoriesTree(), $result);

		$this->params = array_merge( $params , $result, self::$myCategoryStructure );

	}

	public function executeCategoryActions(){
		$this->params = $this->getVarHolder()->getAll();
	}

	public function executeProduct(){
		//  structure
		if(!self::$myProductStructure)
			self::$myProductStructure = Doctrine::getTable('Structure')->findOneByParameterAndLang('productCatalog', $this->getRoute()
																													->getObject()
																													->getLang());

		$structureParams = $this->fetchStructureParams( self::$myProductStructure );

		//  category
		if(!$this->category && isset($this->product->ProductGroups[0])){
			$this->category = Doctrine::getTable('ProductGroup')->createQuery()
								->from('ProductGroup pg')
								->innerJoin('pg.Products p WITH p.product_id = ?', $this->product['id'])
								->fetchOne();
		}


		// unsetting objects
		$original_params = $this->getVarHolder()->getAll();
		$params = $this->getVarHolder()->getAll();
		unset($params['category'], $params['product'], $params['full']);

		// route selection
		$this->route = 'product_page_lvl_' . count($this->fetchProductCategoryParams($this->category));

		// full url ?
		$this->full = isset($original_params['full']) ? $original_params['full'] : false;



		// merging view vars
		$this->params = array_merge($structureParams,
									$this->fetchProductCategoryParams($this->category),
									array('product_slug' =>$this->product['slug']), $params);

	}


	public function executeProductActions(){
		$params = $this->getVarHolder()->getAll();

		if(!self::$myProductStructure){
			self::$myProductStructure = Doctrine::getTable('Structure')->findOneByParameterAndLang('productCatalog', $this->getRoute()
																													->getObject()
																													->getLang());
		}

		 $structureParams = $this->fetchStructureParams( self::$myProductStructure );


		$this->params = array_merge($structureParams,$params);
	}

	public function executeStructureActions(){

		if(!$this->node) return false;

		$params = $this->getVarHolder()->getAll();
		unset($params['node']);

		if(!self::$myStructureActions[$this->node['id']]){
			self::$myStructureActions[$this->node['id']] =
					$this->fetchStructureParams($this->node);
		}

		$this->params =
				array_merge(self::$myStructureActions[$this->node['id']],$params);
	}

	public function executeBasket(){
		$params = $this->getVarHolder()->getAll();

		if(!self::$myBasketStructure){
			self::$myBasketStructure = Doctrine::getTable('Structure')->findOneByLangAndParameter(
				$this->getRoute()->getObject()->getLang(),
				'index');
		}

		$params['p0'] = self::$myBasketStructure['lang'];
		$params['p1'] = self::$myBasketStructure['slug'];

		if(isset($params['order'])){
			$params['orderID'] = $params['order']['id'];
			unset($params['order']);
		}

		$this->params = $params;
	}


	public function executeArticleLinkBuilder(){
		if( !isset($this->params) && isset($this->node) ){
			$this->params = $this->prepareStructureNodeParams($this->node);
		}

		$params = $this->getVarHolder()->getAll();
		unset($params['params'], $params['node']);

		$this->params = array_merge($this->params, $params);

	}



	public function executeLocalizedHomepage(){
		try{
			$this->lang = isset($this->lang) ? $this->lang : $this->getRoute()->getObject()->getLang();
		}catch(Exception $e){
			$this->lang = Doctrine::getTable('Language')->findOneByAbr($this->getUser()->getCulture())->getUrl();
		}
	}



	public function executeSearchLink(){

		$params = $this->getVarHolder()->getAll();

		$node = $this->getRoute()->getObject();
		$params['p0'] = $node['lang'];

		$this->params = $params;
	}


	public function executeChangeCurrency(){
		$params['currencyID'] = $this->currencyID;
		$this->params = $params;

	}

	public function executeSignIn(){
		$this->params = $this->getVarHolder()->getAll();

		$this->register = Doctrine::getTable('Structure')
										->findOneByParameterAndLang('register', $this->getRoute()
																						->getObject()
																						->getLang());
		$z = $this->prepareStructureNodeParams($this->register);


		$this->params = @array_merge($this->params,  $z);
		$this->params['action'] = 'signIn';
	}

	public function executeLogout(){
		$this->params = array();
		$this->executeSignIn();

		$this->params['action']='logOut';
	}

	public function executePasswordReminder(){
		$this->params = array();
	}

	public function executeRegistrationPage(){
		$params = $this->getVarHolder()->getAll();

		$this->mySettings = Doctrine::getTable('Structure')
										->findOneByParameterAndLang('register', $this->getRoute()
																						->getObject()
																						->getLang());


		$z = $this->prepareStructureNodeParams($this->mySettings);
		$this->params = @array_merge($params,  $z);
	}

	public function executeMySettingsLinkBuilder(){

		if(!self::$mySettingsLinkInfo){
			$mySettings = Doctrine::getTable('Structure')
													->findOneByParameterAndLang('my settings', $this->getRoute()
																							->getObject()
																							->getLang());


			self::$mySettingsLinkInfo = $this->prepareStructureNodeParams($mySettings);
		}

		$this->params = array_merge( $this->getVarHolder()->getAll(), self::$mySettingsLinkInfo );
	}


	public function executeMyOrdersLinkBuilder(){
		if(!self::$myOrdersLinkInfo){
			$orders = Doctrine::getTable('Structure')
											->findOneByParameterAndLang('my settings', $this->getRoute()
																							->getObject()
																							->getLang());

			self::$myOrdersLinkInfo = $this->prepareStructureNodeParams($orders);
		}

		$this->params = array_merge( $this->getVarHolder()->getAll(), self::$myOrdersLinkInfo );
	}


        /*
         * PrintView for Structure or for Product
         */
	public function executePrintView(){
		if(!$this->action)
			$this->action = 'plainView';
	}

	public function executePlainActions(){
		$this->params = $this->getVarHolder()->getAll();
	}

	protected function fetchProductCategoryParams($category){
		if(!isset(self::$myProductCategoriesMap[$category['id']] )){
			$result = array();
			$this->prepareProductCategoryParams($category, $this->fetchProductCategoriesTree(), $result);
			self::$myProductCategoriesMap[$category['id']] = $result;
		}

		return self::$myProductCategoriesMap[$category['id']];

	}

	protected function fetchProductCategoriesTree(){

		if(!self::$myCategory)
		 self::$myCategory = Doctrine::getTable('ProductGroup')->createQuery('fetchTree')
					->select('c.*')
					->from('ProductGroup c')
					->orderBy('c.lft asc')
					->where('c.level > ?', 0)
					->setHydrationMode(Doctrine::HYDRATE_RECORD_HIERARCHY)
					->execute();

		return self::$myCategory;
	}

	protected function fetchStructureParams( $structure ){
		if(!isset(self::$structureMap[$structure['id']]))
			self::$structureMap[$structure['id']] = $this->prepareStructureNodeParams( $structure );


		return self::$structureMap[$structure['id']];
	}


	// for STRUCTURE link building
	protected function prepareStructureNodeParams(Structure $node){
			foreach( $node->getNode()->getAncestors() as $anc ){
				if($anc->getLevel() > 0){
					$params['p' . ($anc->getLevel() - 1 )] = $anc->getSlug();
				}
			}

			$params['p' . ($node->getLevel() - 1 )] = $node->getSlug();
			return $params;
	}

	protected function prepareProductCategoryParams($cat, $tree, &$result){
		foreach($tree as $node){
			if($node['id'] == $cat['id']){
				$result['c' . $cat['level']] = $cat['slug'];
				return true;
			}else if(isset($node['__children'])){
				if( $this->prepareProductCategoryParams($cat, $node['__children'], $result) ){
					$result['c' . $node['level']] = $node['slug'];
					return true;
				}
			}
		}
	}

}