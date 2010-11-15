<?php

require_once dirname(__FILE__).'/../../query/lib/queryHelper.class.php';

class CSIActions extends myFrontendAction{

	public function preExecute(){
		$this->helper = new queryHelper();
	}


	public function executeSubmit(sfWebRequest $request){

		echo "test";

	}


}