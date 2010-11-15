<?php

class errorsActions extends sfActions{
	
	public function executeError404(sfWebRequest $request){
		$this->setLayout(false);
		//echo "Item not found";
	}
}