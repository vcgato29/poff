<?php

class ParameterTable extends PriorityTable
{
	

	
	public function addParamGroupCriteria( $query, array $paramGroupsPrimeKeys ){
		if( empty($paramGroupsPrimeKeys) )
			$paramGroupsPrimeKeys = array( -11111111 );
			
		$query->andWhereIn('group_id', $paramGroupsPrimeKeys );
		return $this;
	}
	
	
	public function addMultilangCriteria( $query, $multilang ){
		
		if( $multilang == 0 )
			$query->where( '( multilang = ? OR ( type = ? OR type = ?  ) )', 
					array( $multilang, 'MANY_OPTIONS', 'SINGLE_OPTIONS' ) );
		else
			$query->where( '( multilang = ?  )',  $multilang )
					->andWhereNotIn( 'type', array( 'MANY_OPTIONS', 'SINGLE_OPTIONS' )  );			
		
		 return $this;
	}

	


}