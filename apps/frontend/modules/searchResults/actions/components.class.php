<?php
class searchResultsComponents extends sfComponents
{

  public function executeSearchBox()
  {

  }

  public function executeRender()
  {

  	$this->node = $this->controller->getLastStructureElement();
	$this->keyword = $this->getKeyword();

	//echo html_entity_decode( $this->keyword );


  	$this->searchResults = $this->getCurrentSearchResults();
  	$this->totalPages = ceil( $this->getTotalResults() / $this->getPerPage() );
  	$this->currentPage = $this->getPage();


  }

  public function getCurrentSearchResults(){

	$resultArray = array();

	$results = $this->getMergedResults();
	for( $i = $this->getFrom()-1; $i < $this->getTo(); ++$i ){
		if( !isset( $results[$i] ) )break;

		$item = array();

		switch( $results[$i]['type'] ){
			case 'structure':
				$struct = Doctrine::getTable('Structure')->find($results[$i]['id']);
				$item['link'] = $struct->buildLink();
				$item['name'] = $struct->getPageTitle();
				$item['desc'] = $struct->getDescription();
				break;
			case 'product_group':
				$prod = Doctrine::getTable('ProductGroup')->find($results[$i]['id']);
				$item['link'] = $prod->buildLink( $this->getLang() );
				$item['name'] = $prod->getName();
				$item['desc'] = $prod->getMetaDescription();
				break;
			case 'product':
				$prod = Doctrine::getTable('Product')->find($results[$i]['id']);
				$item['link'] = $prod->buildLink( $this->getLang() );
				$item['name'] = $prod->getName();
				$item['desc'] = $prod->getDescription();
				break;
		}


		$resultArray[] = $item;
	}


	return $resultArray;

  }


  public function getMergedResults(){
  	return array_merge( $this->getStructureResults(),  $this->getProductResults(), $this->getProductGroupResults() );
  }

  public function getTotalResults(){
  	return count( $this->getStructureResults() ) + count( $this->getProductResults() ) + count( $this->getProductGroupResults() );
  }

  public function getStructureResults(){

  	$structureTable = Doctrine::getTable('Structure');
  	$result = $structureTable->search( $this->getKeyword() );


  	$ids = array();
  	foreach( $result as $item )
  		$ids[] = $item['id'];

  	#--- put criteria to them
	$z = Doctrine::getTable('Structure')->createQuery('crit')
		->select('s.*')
		->from('Structure s')
		->whereIn('s.id', $ids)
		->andWhere('s.lang = ?' , $this->getLang() )
		->andWhere('s.isHidden = 1');

	$pks = $z->execute()->getPrimaryKeys();
  	#--- put criteria to them

  	foreach ( $result as $index => &$item ){
  		if( !in_array( $item['id'], $pks ) )
  			unset( $result[$index] );
  		else
  			$item['type'] = 'structure';
  	}


  	return $result;

  }


  public function getProductResults(){


	$index = Doctrine::getTable('Product')
			->getTemplate('Doctrine_Template_I18n')
			->getPlugin()
			->getTable()
			->getGenerator('Doctrine_Search');

	$result = $index->search( $this->getKeyword() );

  	$ids = array();
  	foreach( $result as $item )
  		$ids[] = $item['id'];


    #--- put criteria to them
	$z = Doctrine::getTable('Product')->createQuery('crit')
		->select('pg.*')
		->from('Product pg')
		->innerJoin('pg.Translation t')
		->where('t.lang = ? AND t.name != ?', array( $this->getCulture(), '' ) )
		->whereIn('pg.id', $ids);

	$pks = $z->execute()->getPrimaryKeys();
  	#--- put criteria to them

  	foreach ( $result as $index => &$item ){
  		if( !in_array( $item['id'], $pks ) )
  			unset( $result[$index] );
  		else
  			$item['type'] = 'product';
  	}

	return $result;
  }

  public function getProductGroupResults(){


	$index = Doctrine::getTable('ProductGroup')
			->getTemplate('Doctrine_Template_I18n')
			->getPlugin()
			->getTable()
			->getGenerator('Doctrine_Search');

	$result = $index->search( $this->getKeyword() );

  	$ids = array();
  	foreach( $result as $item )
  		$ids[] = $item['id'];


    #--- put criteria to them
	$z = Doctrine::getTable('ProductGroup')->createQuery('crit')
		->select('pg.*')
		->from('ProductGroup pg')
		->innerJoin('pg.Translation t')
		->where('t.lang = ? AND t.name != ?', array( $this->getCulture(), '' ) )
		->whereIn('pg.id', $ids);

	$pks = $z->execute()->getPrimaryKeys();
  	#--- put criteria to them

  	foreach ( $result as $index => &$item ){
  		if( !in_array( $item['id'], $pks ) )
  			unset( $result[$index] );
  		else
  			$item['type'] = 'product_group';
  	}

	return $result;
  }


  public function getProductQuery(){

  	$productGroupQ = Doctrine_Query::create()
    		->from('Product p');

	$index = Doctrine::getTable('Product')
			->getTemplate('Doctrine_Template_I18n')
			->getPlugin()
			->getTable()
			->getGenerator('Doctrine_Search');

	return $index->search( $this->getKeyword(), $productGroupQ );
  }



  public function getProductGroupQuery(){

  	$productGroupQ = Doctrine_Query::create()
    		->from('ProductGroup pg');

	$index = Doctrine::getTable('ProductGroup')
			->getTemplate('Doctrine_Template_I18n')
			->getPlugin()
			->getTable()
			->getGenerator('Doctrine_Search');

	return $index->search( $this->getKeyword(), $productGroupQ );
  }

  public function getStructureQuery(){

  	$structureTable = Doctrine::getTable('Structure');

  	$structureQ = Doctrine_Query::create()
  			->from('Structure s')
    		->limit('2');

  	return $structureTable->search( $this->getKeyword(), $structureQ );

  }




  public function getKeyword(){
  	return $this->getRequestParameter('keyword');
  }


  public function getPage()
  {
  	if( $this->getRequest()->hasParameter('page') ){
  		return $this->getRequestParameter('page');
  	}
  	return 1;
  }


  public function getFrom(){
  	return ( ( $this->getPage() - 1 ) * $this->getPerPage() )  + 1;
  }

  public function getTo(){
  	return $this->getFrom() + ( $this->getPerPage() - 1 );
  }

  public function getPerPage(){
  	return 20;
  }

  public function getLang(){
  	return $this->controller->getLastStructureElement()->getLang();
  }

  public function getCulture(){
  	$z = Doctrine::getTable('Language')->findOneByUrl( $this->getLang() );
  	return $z['abr'];
  }

}