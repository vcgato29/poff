<?php

require_once dirname(__FILE__).'/../lib/bannergroupGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/bannergroupGeneratorHelper.class.php';

/**
 * bannergroup actions.
 *
 * @package    jobeet
 * @subpackage bannergroup
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class bannergroupActions extends autoBannergroupActions
{
	public function executeEdit( sfWebRequest $request )
	{
		//$this->setLayout('popuplayout');
		parent::executeEdit( $request );
	}
	
	public function executeNew( sfWebRequest $request )
	{
		//$this->setLayout('popuplayout');
		parent::executeNew( $request );
	}
	
	public function executeCreate( sfWebRequest $request )
	{
		//$this->setLayout('popuplayout');
		parent::executeCreate( $request );
	}
	
	public function executeUpdate( sfWebRequest $request )
	{
		//$this->setLayout('popuplayout');
		parent::executeUpdate( $request );
	}
	
	
	
	public function executeIndex( sfWebRequest $request )
	{
		if( $request->hasParameter('nodeid') ){
			$this->setFilters($this->configuration->getFilterDefaults());
		}
		parent::executeIndex( $request );
	}
	
	protected function processForm(sfWebRequest $request, sfForm $form)
	  {
	    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
	    if ($form->isValid())
	    {
	      $notice = $form->getObject()->isNew() ? 'The item was created successfully.' : 'The item was updated successfully.';
	
	      try {
	      	
	        $banner_group = $form->save();
			$banner_group->updateConnections( $request->getParameter('connections', array()) );
//	        if( ( $request->getParameter('connections') ) )
//	        	$banner_group->updateConnections( $request->getParameter('connections') );
	        	
//	        if( ( $request->getParameter('product_group_connections') ) )
//	        	$banner_group->updateProductGroupConnections( $request->getParameter('product_group_connections') );
			$banner_group->updateProductGroupConnections( $request->getParameter('product_group_connections', array() ) );
	        
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
	
	      $this->dispatcher->notify(new sfEvent($this, 'admin.save_object', array('object' => $banner_group)));
	
	      if ($request->hasParameter('_save_and_add'))
	      {
	        $this->getUser()->setFlash('notice', $notice.' You can add another one below.');
	
	        $this->redirect('@banner_group_new');
	      }
	      else
	      {
	        $this->getUser()->setFlash('notice', $notice);
	
	        $this->redirect(array('sf_route' => 'banner_group_edit', 'sf_subject' => $banner_group));
	      }
	    }
	    else
	    {
	      $this->getUser()->setFlash('error', 'The item has not been saved due to some errors.', false);
	    }
	  }
}
