<?php
require_once(dirname(__FILE__) . '/productPreviewFilterForm.class.php');
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of evnetsScheduleConfiguration
 *
 * @author aneto
 */
class productPreviewConfiguration {

	public function getFilterForm(){
		$form = new productPreviewFilterForm();


		$ws = $form->getWidgetSchema();
		foreach($this->getFilters() as $index => $val)
			$ws[$index]->setDefault($val);

		return $form;

	}

	  public function getFilters()
	  {
		return sfContext::getInstance()->getUser()->getAttribute('products_frontend.filters', array());
	  }

	  public function setFilters($filters)
	  {
		return sfContext::getInstance()->getUser()->setAttribute('products_frontend.filters', $filters);
	  }


}