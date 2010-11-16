<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of actions
 *
 * @author aneto
 */
class eventsScheduleActions extends myFrontendAction {


	public function preExecute(){
		$this->configuration = new evnetsScheduleConfiguration();
	}

	
  public function executeFilter(sfWebRequest $request)
  {
    
    $this->filters = $this->configuration->getFilterForm();

    $this->filters->bind($request->getParameter($this->filters->getName()));
    if ($this->filters->isValid())
    {
      $this->configuration->setFilters($this->filters->getValues());
    }

	$this->redirect($request->getReferer());

  }
}
?>
