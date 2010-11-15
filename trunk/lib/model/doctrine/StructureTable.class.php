<?php

class StructureTable extends PriorityNestedTable
{
	
	public function getLastStructureElement( $ar ){
	  	$prev = false;
	  	foreach( $ar as $index => $struct ){
	  		$sql = $index == 0 ? 's.slug = ? and level = \'1\'' : 's.slug = ? and s.parentid = ? '; 
	  		$vars = $index == 0 ? array( $struct ) : array( $struct, $prev->getId() );
	  		
			$elem = $this->createQuery('s')
	  				->where( $sql, $vars )
	  				->fetchOne();
	  				
	  		
	  		if(!is_object($elem))
	  			break;
	  		else{
	  			$prev = $elem;
	  			$elem->focus = $index;
	  		}
	  	}
	  	
	  	return $prev;
	}
	
	public function getNodesByIDs( array $nodes )
	{
		$q = Doctrine_Query::create()
      	->from('Structure s')
      	->whereIn('s.id', $nodes );
      
      return $q->execute();
      
		
	}
	
	public function getLangNode( $lang ){
		
		$sql = 'n.lang = ? and type = ? and level = ?';
		$vars = array( $lang, 'lang', 1 );
		
		$langNode = $this->createQuery( 'n' )
			->where( $sql, $vars )
			->fetchOne();
			
		return $langNode;
	}
	
	public function getFirstActualLevel( $lang  ){
		
		$langNode = $this->getLangNode( $lang );
		return $this->getNodeChildren( $langNode->id );
		
	}
	
	
	public function getNodeChildren( $nodeID )
	{
		$children = $this->createQuery( 'c' )
			->where( 'c.parentID = ? ', array($nodeID) )
			->orderBy( 'c.lft asc' )
			->execute();
			
		//print_r($children->toArray());
		return $children;
	}
	
	
	

	
	public function getRoot()
	{
		return $this->createQuery( 'c' )
			->where( 'c.parentID is null and level = ?', array(0) )
			->fetchOne();
	}

	public function getLanguages()
	{
		return $this->createQuery( 'l' )
			->where( 'l.level = ? and l.type = ?', array(1, 'lang') )
			->orderBy( 'l.pri' )
			->execute();
	}


	// INDEXING FOR website SEARCH
	static public function getLuceneIndex()
	{
	  ProjectConfiguration::registerZend();

	  if (file_exists($index = self::getLuceneIndexFile()))
	  {
	    return Zend_Search_Lucene::open($index);
	  }

	  return Zend_Search_Lucene::create($index);
	}

	static public function getLuceneIndexFile()
	{
		//sfConfig::get('sf_environment')
	  return sfConfig::get('sf_data_dir').'/structure.index/index';
	}

	

}