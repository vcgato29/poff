<?php

class ParameterGroupTable extends PriorityNestedTable
{
	public function getFullHierarchy( $lang = 'et' ){
		
		$q = Doctrine::getTable('ParameterGroup')
	        ->createQuery('p')
	        ->select('t.name as title,p.*')
	        ->from( 'ParameterGroup p' )
	        ->leftJoin('p.Translation t')
	        ->where('t.lang = ?')
	        ->orderBy('lft');
        
    	return $q->execute( array( $lang ), Doctrine::HYDRATE_RECORD_HIERARCHY);
	}
	
	

}