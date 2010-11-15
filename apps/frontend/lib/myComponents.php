<?php

class myComponents extends sfComponents{
	
	
	public function getObject(){	
		return	$this->getContext()
					->getController()
      				->getAction( $this->getRequestParameter('module'), $this->getRequestParameter('action') )
      				->getRoute()
      				->getObject();
	}
	
	public function getRoute(){
		return	$this->getAction()->getRoute();
	}
	
	public function getAction(){
		return $this->getContext()
							->getController()
		      				->getAction( $this->getRequestParameter('module'), $this->getRequestParameter('action') );
	}
	
	
}