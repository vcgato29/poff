<?php

class sfGuardAuthComponents extends sfComponents
{
	public function executeHeader()
	{
		$this->username = $this->getUser()->getGuardUser()->getUsername();
	}
		
}