<?php
class PriorityNestedTable extends Doctrine_Table
{
	public function increasePriority( $nodeID ){

		$node = $this->find( $nodeID );

		if( $node->getNode()->hasPrevSibling() ){
			$node->getNode()->moveAsPrevSiblingOf( $node->getNode()->getPrevSibling() );

		}
	}
	
	public function decreasePriority( $nodeID ){
		$node = $this->find( $nodeID );
		 
		if( $node->getNode()->hasNextSibling() ){
			$node->getNode()->moveAsNextSiblingOf( $node->getNode()->getNextSibling() );
		}
	}	
}