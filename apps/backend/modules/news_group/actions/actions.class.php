<?php

require_once dirname(__FILE__).'/../lib/news_groupGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/news_groupGeneratorHelper.class.php';

/**
 * news_group actions.
 *
 * @package    jobeet
 * @subpackage news_group
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class news_groupActions extends autoNews_groupActions
{
	
	
	
	public function executeEdit( sfWebRequest $request )
	{
		
		 $this->forwardSecureUnless( 
			Doctrine::getTable('NewsGroup')
				->find( $request->getParameter('id') )->isPermittedForUser( $this->getUser(), myUser::PERM_RW ) );
		 
		
		
		$this->setLayout('popuplayout');
		parent::executeEdit( $request );
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
	
	public function executeNew( sfWebRequest $request )
	{
		$this->setLayout('popuplayout');
		parent::executeNew( $request );
	}
	
	public function executeIndex( sfWebRequest $request )
	{
		if( $request->hasParameter('nodeid') ){
			$this->setFilters($this->configuration->getFilterDefaults());
		}
		return parent::executeIndex( $request );
	}
	
  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $notice = $form->getObject()->isNew() ? 'The item was created successfully.' : 'The item was updated successfully.';

      try {
        $news_group = $form->save();
        
        $news_group->updateConnections( $request->getParameter('connections') );
        
        // news_group is saved
      } catch (Doctrine_Validator_Exception $e) {

        $errorStack = $form->getObject()->getErrorStack();

        $message = get_class($form->getObject()) . ' has ' . count($errorStack) . " field" . (count($errorStack) > 1 ?  's' : null) . " with validation errors: ";
        foreach ($errorStack as $field => $errors) {
            $message .= "$field (" . implode(", ", $errors) . "), ";
        }
        $message = trim($message, ', ');

        $this->getUser()->setFlash('error', $message);
        return sfView::SUCCESS;
      }

      $this->dispatcher->notify(new sfEvent($this, 'admin.save_object', array('object' => $news_group)));

      if ($request->hasParameter('_save_and_add'))
      {
        $this->getUser()->setFlash('notice', $notice.' You can add another one below.');

        $this->redirect('@news_group_new');
      }
      else
      {
        $this->getUser()->setFlash('notice', $notice);

        $this->redirect(array('sf_route' => 'news_group_edit', 'sf_subject' => $news_group));
      }
    }
    else
    {
      $this->getUser()->setFlash('error', 'The item has not been saved due to some errors.', false);
    }
  }
  
  public function executeBatchPriority( sfWebRequest $request )
  {
  	
  	foreach( $request->getParameter('product_pri') as $prodID => $prodPri ){

  		$prod = Doctrine::getTable('NewsGroup')->find($prodID); 
  		$prod->setPri( $prodPri );
  		$prod->save();	
  	}	
  	
  	
  	$this->redirect('@news_group');
  }
  
  public function executeBatch(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    if ( (!$ids = $request->getParameter('ids')) && $request->getParameter('batch_action') != 'batchPriority'  )
    {
      $this->getUser()->setFlash('error', 'You must at least select one item.');

      $this->redirect('@news_group');
    }

    if (!$action = $request->getParameter('batch_action'))
    {
      $this->getUser()->setFlash('error', 'You must select an action to execute on the selected items.');

      $this->redirect('@news_group');
    }

    if (!method_exists($this, $method = 'execute'.ucfirst($action)))
    {
      throw new InvalidArgumentException(sprintf('You must create a "%s" method for action "%s"', $method, $action));
    }

    if (!$this->getUser()->hasCredential($this->configuration->getCredentials($action)))
    {
      $this->forward(sfConfig::get('sf_secure_module'), sfConfig::get('sf_secure_action'));
    }

    $validator = new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'NewsGroup'));
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

    $this->redirect('@news_group');
  }
 
}