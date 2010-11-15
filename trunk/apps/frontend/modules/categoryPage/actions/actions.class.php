<?php
require_once dirname(__FILE__).'/../../categoriesLeftMenuWidget/lib/CategoriesLeftMenuHelper.class.php';

class categoryPageActions extends myFrontendAction{


	public function executeIndex( sfWebRequest $request ){
		$this->forward('homepage', 'index');

	}




}