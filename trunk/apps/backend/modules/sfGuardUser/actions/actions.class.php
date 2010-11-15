<?php

require_once(sfConfig::get('sf_plugins_dir').'/sfDoctrineGuardPlugin/modules/sfGuardUser/lib/sfGuardUserGeneratorConfiguration.class.php' );
require_once(sfConfig::get('sf_plugins_dir').'/sfDoctrineGuardPlugin/modules/sfGuardUser/lib/sfGuardUserGeneratorHelper.class.php' );

class sfGuardUserActions extends autoSfGuardUserActions
{
	public function executeAdminNew( sfWebRequest $request )
	{
		
	}
	
	public function executeListUsers( sfWebRequest $request )
	{
			
	}
	
	public function executeEdit( sfWebRequest $request )
	{
		parent::executeEdit( $request );
	}

  public function executeIndex(sfWebRequest $request)
  {
    // sorting
    if ($request->getParameter('sort') && $this->isValidSortColumn($request->getParameter('sort')))
    {
      $this->setSort(array($request->getParameter('sort'), $request->getParameter('sort_type')));
    }

    // pager
    if ($request->getParameter('page'))
    {
      $this->setPage($request->getParameter('page'));
    }

    $this->pager = $this->getPager();
    $this->sort = $this->getSort();
  }
	
	public function executeNew( sfWebRequest $request )
	{
		//$this->setLayout('popuplayout');
		
		parent::executeNew( $request );
	}
	
}
