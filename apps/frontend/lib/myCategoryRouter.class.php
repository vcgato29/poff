<?php

class myCategoryRouter extends sfDoctrineRoute implements AppRoutingDesc{
	
	protected $category = false;
	
	protected function getObjectForParameters($parameters){




		// find depending on P0 ( lang struct ) with parameter category structure
  		$result = array();
		for( $i = 0; $i < count($parameters); ++$i ){
			if(isset($parameters['p'.$i]) && !empty($parameters['p'.$i]))
				$result[$i] = $parameters['p'.$i];
		}
		

		if(empty($result)){ // if user is requesting "www.domain.com" with no structures. Get first language 	
			$lastStructElement = Doctrine::getTable('StructureLanguage')->findAll()->getFirst();
		}else{
			$lastStructElement = Doctrine::getTable('Structure')->getLastStructureElement($result);
		}

		if( (!isset($result[1]) || !$result[1]) && $lastStructElement ){
			$lastStructElement = Doctrine::getTable('Structure')->findOneByLangAndParameter( $lastStructElement['lang'] , 'index');
			
		}
		
		if( !$lastStructElement ){
			throw new Exception( 'no structure element' );
		}
		
  		return $lastStructElement; 
	}
	
	
	public function getStructureOfLevel( $index = 1 ){
		
		foreach( $this->getObject()->getNode()->getAncestors() as $anc ){
			if( $anc->getLevel() == $index )
				return $anc;
		}
		
		if( $this->getObject()->getLevel() == $index )
			return $this->getObject();
		
		return false;
		

	}
	
	public function getCategoryObject(){
		if( !$this->category ){
			$params = $this->getParameters();
			for($i = 1; $i < 5; ++$i){
				if(isset($params['c' . $i]) && !empty($params['c'.$i]))
					$lastSlug = $params['c' . $i];
			}
			
			if(isset($lastSlug)){

				$this->category = Doctrine::getTable('ProductGroup')->createQuery()
							->from('ProductGroup pg')
							->innerJoin('pg.Translation pt')
							->where('pt.slug = ?', $lastSlug)->fetchOne();
			}
			else
				return false;
		}
		
		return $this->category;
	}
	
	protected function getObjectsForParameters($parameters){
		return new Doctrine_Collection('Structure','id');
	}
	
	
	public function getProductObject(){
		return false;
	}


	public function getNewsItemObject(){
		return false;
	}
}