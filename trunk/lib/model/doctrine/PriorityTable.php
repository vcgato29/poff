<?php


class PriorityTable extends Doctrine_Table
{
	
	
	public function fixPriorities( $nodeID ){
		
		$node = $this->find( $nodeID );
		
		if( $node->pri === 0 )
			$node->pri = $node->id;
		
		
		foreach( $node->getSameLevelNodes() as $sibling ){
			if( !$sibling->pri )
				$sibling->pri = $sibling->id;
			$sibling->save();
		}
		$node->save();
	}
	
	public function increasePriority( $nodeID )
	{
		$this->fixPriorities( $nodeID );
		
		$node = $this->find( $nodeID );
		
		$minDif = 999999;
		$brot = null;
		foreach( $node->getSameLevelNodes() as $sibling ){
			
			if( $sibling->pri < $node->pri && ( $node->pri - $sibling->pri < $minDif ) ){
				$minDif = $node->pri - $sibling->pri;
				$brot = $sibling;
			}
		
		}
		
		
		if( $brot ){
			$this->swapPriorities( $node, $brot );
			$node->save();
			$brot->save();
		}
		
		
	}
	
	public function swapPriorities( $node1, $node2 )
	{
	
		$tmp = $node1->pri;
		$node1->pri = $node2->pri;
		$node2->pri = $tmp;
	}
	
	
	public function decreasePriority( $nodeID )
	{
		$this->fixPriorities( $nodeID );
		
		$node = $this->find( $nodeID );
		
		$minDif = 999999;

		$brot = null;
		foreach( $node->getSameLevelNodes() as $sibling ){
			if( $sibling->pri > $node->pri && ( $sibling->pri - $node->pri < $minDif ) ){
				$minDif = $sibling->pri - $node->pri;
				$brot = $sibling;
			}
		}
		
		
		
		if( $brot ){
			$this->swapPriorities( $node, $brot );
			$node->save();
			$brot->save();
		}
		
	}
}