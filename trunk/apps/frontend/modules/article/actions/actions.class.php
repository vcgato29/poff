<?php

class articleActions extends sfActions{

	public function executePlainView(sfWebRequest $request){ // most simple view of structure
		$this->setLayout(false);
		$this->node = Doctrine::getTable('Structure')->find($request->getParameter('node'));
	}
	
	public function executeTermsAndConds(sfWebRequest $request){
		$this->setLayout(false);
		$this->node = Doctrine::getTable('Structure')->find($request->getParameter('nodeID'));
	}
	
}