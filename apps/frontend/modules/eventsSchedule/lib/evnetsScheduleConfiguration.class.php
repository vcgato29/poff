<?php
require_once(dirname(__FILE__) . '/eventsScheduleFilterForm.class.php');
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of evnetsScheduleConfiguration
 *
 * @author aneto
 */
class evnetsScheduleConfiguration {

	public function getFilterForm(){
		$form = new eventsScheduleFilterForm();

		$form->setDefaults($this->getFilters());

		return $form;
		
	}

	  public function getFilters()
	  {
		return sfContext::getInstance()->getUser()->getAttribute('product_exemplar_frontend.filters', array('scheduled_time' => 'from_now'));
	  }

	  public function setFilters($filters)
	  {
		return sfContext::getInstance()->getUser()->setAttribute('product_exemplar_frontend.filters', $filters);
	  }


}