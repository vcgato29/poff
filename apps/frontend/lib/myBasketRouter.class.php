<?php

class myBasketRouter  extends myProductRouter{
	
	protected $video = false;	

	protected function getObjectForParameters($parameters){
		return Doctrine::getTable('Structure')->findOneByLangAndParameter($parameters['p0'], 'basket');
	}

	
	protected function getObjectsForParameters($parameters){
		return new Doctrine_Collection('Structure','id');
	}
	
}
