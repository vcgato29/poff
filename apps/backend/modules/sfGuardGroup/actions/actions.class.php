<?php

require_once(sfConfig::get('sf_plugins_dir').'/sfDoctrineGuardPlugin/modules/sfGuardGroup/lib/sfGuardGroupGeneratorConfiguration.class.php' );
require_once(sfConfig::get('sf_plugins_dir').'/sfDoctrineGuardPlugin/modules/sfGuardGroup/lib/sfGuardGroupGeneratorHelper.class.php' );

class sfGuardGroupActions extends autosfGuardGroupActions
{
	
	public function executeListUserGroups( $request )
	{
		//print_r($_GET)
	}
	
	public function executeAdminNew(sfWebRequest $request)
	{
		//$this->setLayout('popuplayout');
	  	$this->form = new AdminUserGroupForm();
	}
	 
	public function executeAdminCreate(sfWebRequest $request)
	{

		//$this->setLayout('popuplayout');
	  $this->form = new AdminUserGroupForm();
	  $this->processAdminForm($request, $this->form);
	  $this->setTemplate('adminNew');
	}
	 
	public function executeAdminEdit(sfWebRequest $request)
	{
//		$this->setLayout('popuplayout');
	  	$this->form = new AdminUserGroupForm( Doctrine::getTable('AdminUserGroup')->find( $request->getParameter('id') ) );
	}
	 
	public function executeAdminUpdate(sfWebRequest $request)
	{
	  
		$blank = new AdminUserGroupForm();
	  	$ar = $request->getParameter($blank->getName());
	  	$obj = Doctrine::getTable('AdminUserGroup')->find( $ar['id'] );
			  
	  	$this->form = new AdminUserGroupForm( $obj );
	  
	  	$this->processAdminForm($request, $this->form);
	  	$this->setTemplate('edit');
	}
	
	
	 
	public function executeAdminDelete(sfWebRequest $request)
	{
		Doctrine::getTable('AdminUserGroup')->find( $request->getParameter('id') )->delete();
	  	$this->redirect( $this->getRequest()->getReferer() );
	}
	 
	protected function processAdminForm(sfWebRequest $request, sfForm $form)
	{
	  $form->bind($request->getParameter($form->getName()));
	 
	  if ($form->isValid())
	  {
	  	
	    $job = $form->save();
	    $this->redirect( '@sf_guard_group_page?action=adminEdit&id='.$job->id );
	  }else{
	  	//$job = $form->save();
	  }
	}
}
