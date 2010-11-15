<?php

require_once dirname(__FILE__).'/../lib/new_itemGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/new_itemGeneratorHelper.class.php';

/**
 * new_item actions.
 *
 * @package    jobeet
 * @subpackage new_item
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class new_itemActions extends autoNew_itemActions
{
	public function executeEdit( sfWebRequest $request )
	{
		$this->setLayout('popuplayout');
		parent::executeEdit( $request );
	}
	
	public function executeNew( sfWebRequest $request )
	{
		$this->setLayout('popuplayout');
		parent::executeNew( $request );
	}
	
	public function executeCreate( sfWebRequest $request )
	{
		$this->setLayout('popuplayout');
		parent::executeCreate( $request );
	}
	
	public function executeUpdate( sfWebRequest $request )
	{
		$this->setLayout('popuplayout');
		parent::executeUpdate( $request );
	}
	
	public function executeIndex( sfWebRequest $request )
	{
		if( $request->hasParameter('group_id') || $request->hasParameter('nodeid') )
			$this->setFilters($this->configuration->getFilterDefaults());
			

		parent::executeIndex( $request );
	}
	
  public function executeBatchPriority( sfWebRequest $request )
  {
  	
  	foreach( $request->getParameter('product_pri') as $prodID => $prodPri ){

  		$prod = Doctrine::getTable('NewItem')->find($prodID); 
  		$prod->setPri( $prodPri );
  		$prod->save();	
  	}	
  	
  	
  	$this->redirect('@new_item');
  }
  
  public function executeBatch(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    if ( (!$ids = $request->getParameter('ids')) && $request->getParameter('batch_action') != 'batchPriority'  )
    {
      $this->getUser()->setFlash('error', 'You must at least select one item.');

      $this->redirect('@new_item');
    }

    if (!$action = $request->getParameter('batch_action'))
    {
      $this->getUser()->setFlash('error', 'You must select an action to execute on the selected items.');

      $this->redirect('@new_item');
    }

    if (!method_exists($this, $method = 'execute'.ucfirst($action)))
    {
      throw new InvalidArgumentException(sprintf('You must create a "%s" method for action "%s"', $method, $action));
    }

    if (!$this->getUser()->hasCredential($this->configuration->getCredentials($action)))
    {
      $this->forward(sfConfig::get('sf_secure_module'), sfConfig::get('sf_secure_action'));
    }

    $validator = new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'NewItem'));
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

    $this->redirect('@new_item');
  }
  
  
	
}
