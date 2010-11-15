<?php

require_once dirname(__FILE__).'/../lib/bannerGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/bannerGeneratorHelper.class.php';

/**
 * banner actions.
 *
 * @package    jobeet
 * @subpackage banner
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class bannerActions extends autoBannerActions
{
	public function executeEdit( sfWebRequest $request )
	{
		$this->banner = $this->getRoute()->getObject();
    	$this->form = $this->banner->getEditForm();
	}
	
  public function executeUpdate(sfWebRequest $request)
  {
  	
	$this->banner = $this->getRoute()->getObject();
    $this->form = $this->banner->getEditForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }
	
	public function executeNew( sfWebRequest $request )
	{
		parent::executeNew( $request );
	}
	
	public function executeCreate( sfWebRequest $request )
	{
		parent::executeCreate( $request );
	}
	
	public function executeIndex( sfWebRequest $request )
	{
		if( $request->hasParameter('group_id') || $request->hasParameter('nodeid') )
			$this->setFilters($this->configuration->getFilterDefaults());
		parent::executeIndex( $request );
	}
	
	
	
  public function executeBatch(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    if ( (!$ids = $request->getParameter('ids')) && $request->getParameter('batch_action') != 'batchPriority'  )
    {
      $this->getUser()->setFlash('error', 'You must at least select one item.');

      $this->redirect('@banner');
    }

    if (!$action = $request->getParameter('batch_action'))
    {
      $this->getUser()->setFlash('error', 'You must select an action to execute on the selected items.');

      $this->redirect('@banner');
    }

    if (!method_exists($this, $method = 'execute'.ucfirst($action)))
    {
      throw new InvalidArgumentException(sprintf('You must create a "%s" method for action "%s"', $method, $action));
    }

    if (!$this->getUser()->hasCredential($this->configuration->getCredentials($action)))
    {
      $this->forward(sfConfig::get('sf_secure_module'), sfConfig::get('sf_secure_action'));
    }

    $validator = new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Banner'));
    try
    {
      // validate ids
      if( $ids )
      	$ids = $validator->clean($ids);

      // execute batch
      $this->$method($request);
    }
    catch (sfValidatorError $e)
    {
      $this->getUser()->setFlash('error', 'A problem occurs when deleting the selected items as some items do not exist anymore.');
    }

    $this->redirect('@banner');
  }
	
  
	
  public function executeBatchPriority( sfWebRequest $request )
  {
  	
  	foreach( $request->getParameter('product_pri') as $prodID => $prodPri ){

  		$prod = Doctrine::getTable('Banner')->find($prodID); 
  		$prod->setPri( $prodPri );
  		$prod->save();	
  	}	
  	
  	
  	$this->redirect('@banner');
  }
	
	
}
