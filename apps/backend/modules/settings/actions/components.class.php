<?php
class settingsComponents extends sfComponents
{
	public function executeSettingsBox()
	{
		$this->toggledModules = array( 	'sfGuardGroup' => array( 'route' => '@admin_page?module=sfGuardGroup&action=listUserGroups',
																'name' => 'Administrator Groups',
																'credential' => 'admin' ), 
		
	 									'sfGuardUser' => array( 'route' => '@sf_guard_user',
	 															'name' => 'Administrators',
																'credential' => 'admin' ),
		
										'translations' =>	array( 	'route' => '@admin_page?module=translations&action=index',
																	'name' => 'Translations',
																	'credential' => 'admin' ),
										'variables' => array(	'route' => '@admin_page?module=variables',
																'name' => 'Variables',
																'credential' => 'admin'));
		 
		$this->user = $this->getUser();
		$this->curModule = $this->getRequestParameter('module');
	}
}