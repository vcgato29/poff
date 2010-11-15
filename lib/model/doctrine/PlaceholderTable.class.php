<?php

class PlaceholderTable extends PriorityTable
{

	public function getRecordsByStructureOrdered( $structID )
	{
		return Doctrine_Query::create()
					   			 ->select('p.*')
					   			 ->from('Placeholder p')
					   			 ->where('p.Structure.id =  ?', array( $structID ))
					   			 ->orderBy('p.pri' )
					   			 ->execute();
	}
}