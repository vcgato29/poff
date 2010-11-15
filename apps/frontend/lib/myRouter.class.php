<?php

class myRouter extends sfDoctrineRoute{
	
	protected function getObjectForParameters($parameters){
		$result = array();
		for( $i = 0; $i < count($parameters); ++$i ){
			if( isset( $parameters['p'.$i] ) )
				$result[$i] = $parameters['p'.$i];
		}

  		return Doctrine::getTable('Structure')->getLastStructureElement( $result );
	}
	
	protected function getObjectsForParameters($parameters){
		return new Doctrine_Collection('Structure','id');
	}
	
	
	
	public function getCategoryObject(){
		throw new Exception('not implemented');
	}
	
	public function getGalleryObject(){
		throw new Exception('not implemented');
	}


}