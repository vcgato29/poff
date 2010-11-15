<?php
require_once dirname(__FILE__).'/../lib/ProductPageHelper.class.php';

class productPageComponents extends myComponents{




    public function executePageLayout(){
		$this->product = $this->getRoute()->getProductObject();
		$this->category = $this->getRoute()->getCategoryObject();

		$this->additionalActions = $this->getAddActions();

		$helper = new ProductPageHelper();
		$params =   $this->parameterArticles = $helper->getProductParameters($this->product);


		$this->parameterArticles = $params['article'];

        
    }

	public function getAddActions(){
     return array(
								array('title' => 'Info', 'action' => 'index','use' => true),
								array('title' => 'Gallery', 'action' => 'gallery','use' => true),
								array('title' => 'Files', 'action' => 'files','use' => true),
								array('title' => 'Calculator', 'action' => 'calc','use' => $this->getRoute()->getProductObject()->getParameter() == 'roof_product')
							);
		
	}

}

?>
