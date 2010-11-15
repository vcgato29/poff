<?php
require_once dirname(__FILE__).'/../../productPage/lib/ProductPageHelper.class.php';
require_once dirname(__FILE__).'/../../productPage/lib/productPageConfiguration.class.php';
require_once dirname(__FILE__).'/../../productPage/lib/CalculatorForm.class.php';

class calculatorWidgetComponents extends myComponents{

    public function executeRender(){
		$this->configuration = new productPageConfiguration();
		$this->helper = new ProductPageHelper();

		$this->form = $this->configuration->getCalculatorForm();
		$this->data = $this->configuration->getCalculatorData();

	}
}
