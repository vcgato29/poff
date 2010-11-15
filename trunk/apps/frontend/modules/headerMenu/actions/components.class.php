<?php
class headerMenuComponents extends myComponents
{

	static $nodes = false;

  public function executeRender(){

  	$this->curNode = $this->getRoute()->getObject();
	$this->nodes = $this->getNodes();
    //echo '<pre>';
	//print_r($this->nodes->toArray());
    //echo '</pre>';
	$this->basket = myBasket::getInstance();

  }

  public function executeRendera(){

  	$this->curNode = $this->getRoute()->getObject();

  	$this->nodes = Doctrine::getTable('Structure')->
		createQuery('all')
		->select('sl.*')
		->from('Structure sl')
		->where('sl.parameter = ?' , 'archive')
		->andWhere('sl.lang = ?',  $this->getRoute()->getObject()->getLang())
		->setHydrationMode(Doctrine::HYDRATE_RECORD)
		->execute();
    //echo '<pre>';
	//print_r($this->nodes);
    //echo '</pre>';
    //$this->nodes = $this->getNodes();
	$this->basket = myBasket::getInstance();

  }

  public function executeRenderf(){

  	$this->curNode = $this->getRoute()->getObject();
	$this->nodes = Doctrine::getTable('Structure')->
		createQuery('all')
		->select('sl.*')
		->from('Structure sl')
		->where('sl.parameter = ?' , 'festival')
		->andWhere('sl.lang = ?',  $this->getRoute()->getObject()->getLang())
		->setHydrationMode(Doctrine::HYDRATE_RECORD)
		->execute();
    //echo '<pre>';
	//print_r($this->nodes[14]);
    //echo '</pre>';
    //$this->nodes = $this->getNodes();
	$this->basket = myBasket::getInstance();

  }

  public function executeRenderf2(){

  	$this->curNode = $this->getRoute()->getObject();
	$this->nodes = Doctrine::getTable('Structure')->
		createQuery('all')
		->select('sl.*')
		->from('Structure sl')
		->where('sl.parameter = ?' , 'festival')
		->andWhere('sl.lang = ?',  $this->getRoute()->getObject()->getLang())
		->setHydrationMode(Doctrine::HYDRATE_RECORD)
		->execute();
    //echo '<pre>';
	//print_r($this->nodes[14]);
    //echo '</pre>';
    //$this->nodes = $this->getNodes();
	$this->basket = myBasket::getInstance();

  }


  protected function getNodes( $recreate = false ){
  		if( $recreate || !self::$nodes ){
  			$coll = new Doctrine_Collection('Structure', 'id');
  			self::$nodes = $coll->merge( $this->getMenuItemFetchingQuery()
							->execute() );

  		}

	return self::$nodes;
  }

  protected function getMenuItemFetchingQuery(){
  	return $this->setMenuItemContstraints( Doctrine::getTable('Structure')->createQuery('headerMenu')
			->select('s.*')
			->from('Structure s') );
  }

  protected function setMenuItemContstraints( Doctrine_Query $q ){
  	$q ->where('s.level > 1')
	  ->andWhere('s.lang = ?',  $this->getRoute()->getObject()->getLang())
	  ->andWhere('s.level <= ?', $this->getCurrentMenuLevel())
	  ->orderBy('s.lft asc')
	  ->setHydrationMode(Doctrine::HYDRATE_RECORD_HIERARCHY);

	  return $q;
  }

  protected function getCurrentMenuLevel(){
  	return 4;
  }

  public function executeLangSelect(){

	$this->langs = Doctrine::getTable('StructureLanguage')->
		createQuery('all')
		->select('sl.*')
		->from('StructureLanguage sl')
		->where('sl.isHidden = ?' , 0)
		->setHydrationMode(Doctrine::HYDRATE_RECORD)
		->execute();

	$this->currentNode = $this->getRoute()->getObject();
  }


  public function executeCurrencySelect(){
  	$this->currencies = Doctrine::getTable('Currency')->findAll();
  }


  public function executeSearchBox(){

  }

  public function executeSignIn(){
  	$this->form = new SignInForm();

  	$this->mySettings = Doctrine::getTable('Structure')->findOneByParameterAndLang('my settings', $this->getRoute()->getObject()->getLang());
  	$this->myOrders = Doctrine::getTable('Structure')->findOneByParameterAndLang('orders', $this->getRoute()->getObject()->getLang());

  	$this->reminderForm = new PasswordReminderForm();
  }



  public function executeBreadCrumbs(){

  	$structs = $this->getRoute()->getObject()->getNode()->getAncestors();
  	$structs->add( $this->getRoute()->getObject() );
  	$structNodes = array();

  	# build structure breadscrumbs
  	foreach($structs as $struct){
  		$ar = $struct->toArray();
  		$ar['link'] = @$this->getAction()->getComponent('linker', 'articleLinkBuilder', array('node' => $struct) );
  		$structNodes[] = $ar;

  	}

  	# add category breadscrumbs
  	if($this->getRoute()->getCategoryObject()){
  		$cats = $this->getRoute()->getCategoryObject()->getNode()->getAncestors();
  		$cats->add($this->getRoute()->getCategoryObject());

		  foreach($cats as $anc){
		  	if($anc['level'] == 0)continue; // root is not needed

		  	//prepare array
  			$ar = $anc->toArray();
  			$ar['title'] = $anc['name'];
  			$ar['link'] = @$this->getAction()->getComponent('linker', 'category', array('category' => $anc) );
  			$ar['isHidden'] = 0;

  			$structNodes[] = $ar;
		  }
  	}



  	# add product breadscrumb
  	if($this->getRoute()->getProductObject()){
  		$ar['link'] = ''; // @$this->getAction()->getComponent('linker', 'product', array('category' => $this->getRoute()->getCategoryObject(), 'product' => $this->getRoute()->getProductObject()) )
  		$ar['isHidden'] = 0;
  		$ar['title'] = $this->getRoute()->getProductObject()->getName();

  		$structNodes[] = $ar;
  	}

	# add NewItem
	if($this->getRoute()->getNewsItemObject()){
  		$ar['link'] = ''; // @$this->getAction()->getComponent('linker', 'product', array('category' => $this->getRoute()->getCategoryObject(), 'product' => $this->getRoute()->getProductObject()) )
  		$ar['isHidden'] = 0;
  		$ar['title'] = $this->getRoute()->getNewsItemObject()->getName();

  		$structNodes[] = $ar;
	}

  	$this->nodes = $structNodes;

  }


}