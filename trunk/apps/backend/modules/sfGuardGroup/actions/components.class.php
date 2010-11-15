<?php
class sfGuardGroupComponents extends sfComponents
{
	
	
	public function executeHeader()
	{
		$this->username = $this->getUser()->getGuardUser()->getUsername();
	}
	
	public function executeListUserGroups()
	{
		$this->userGroups = Doctrine::getTable('AdminUserGroup')->findAll()->toArray();
	}
	
	
	public function executeListUsers()
	{
		$this->users = Doctrine::getTable('AdminUser')->findAll()->toArray();
	}
		
}