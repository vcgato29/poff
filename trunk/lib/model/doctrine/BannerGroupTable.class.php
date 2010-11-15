<?php

class BannerGroupTable extends Doctrine_Table
{
	public function findArrayOfApropriateStructureElements(){

		$nodes = Doctrine::getTable('Structure')->getRoot()->getNode()->getDescendants();
		$result = array();
		
		foreach( $nodes as $node )
			$result[$node->id] = str_repeat( '-> ', $node->level - 1 ) . $node->title;
			
			
		return $result;
	}
	
	
	public function findArrayOfApropriateProductGroupElements(){
		$nodes = Doctrine::getTable('ProductGroup')->getRoot()->getNode()->getDescendants();
		

		
		$result = array();
		
		foreach( $nodes as $node ){
			$result[$node->id] = str_repeat( '-> ', $node->level - 1 ) . $node->title;
		}
		
		return $result;
	}
}