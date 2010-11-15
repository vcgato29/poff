<?php

class TransUnitTable extends Doctrine_Table
{

	public function getUniqueTransUnits( ){
		$query = Doctrine_Query::create()
   			 ->select(' distinct( source ) as source  ')
   			 ->from('TransUnit t');
   		
   		return $query;
	} 
	
	public function findOneByLangAndCategory( $source, $cat_id ){
		return $this->createQuery('t')
    		->where('t.cat_id = ? and t.source LIKE ?', array($cat_id, $source))
    		->fetchOne();

		
	}
	
}