<?php

class contactUsFormComponents extends myComponents
{
  public function executeRender(){
	/*$this->getAction()
			->redirect($this->getAction()->getComponent('linker', 'structureActions',
							array('node' => $this->getRoute()->getObject()
							))
	);*/
	echo   $this->getAction()->getComponent('linker', 'structureActions', array('node' => $this->getRoute()->getObject()));

  }
}