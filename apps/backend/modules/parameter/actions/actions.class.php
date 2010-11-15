<?php

require_once dirname(__FILE__).'/../lib/parameterGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/parameterGeneratorHelper.class.php';

/**
 * parameter actions.
 *
 * @package    jobeet
 * @subpackage parameter
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class parameterActions extends autoParameterActions
{
	public function executeNew( sfWebRequest $request )
	{
//		$this->setLayout( 'popuplayout' );
		parent::executeNew($request);
	}
	
	
	public function executeCreate( sfWebRequest $request )
	{
//		$this->setLayout( 'popuplayout' );
		parent::executeCreate( $request );
	}
	
	
	public function executeEdit( sfWebRequest $request )
	{
//		$this->setLayout( 'popuplayout' );
		$this->parameter = $this->getRoute()->getObject();
		$this->form = $this->parameter->getEditForm();
    	//$this->form = $this->configuration->getForm($this->parameter);
	}
	
	
	public function executeUpdate( sfWebRequest $request )
	{
	    $this->parameter = $this->getRoute()->getObject();
	    $this->form = $this->parameter->getEditForm();
		
	    $this->processForm($request, $this->form);
//		$this->setLayout('popuplayout');
	    $this->setTemplate('edit');
	}
	
	public function executeDeleteOption( sfWebRequest $request )
	{
		Doctrine::getTable('ParameterOption')->find($request->getParameter('id'))->delete();
		
		$this->redirect( $request->getReferer() );
	}
	


	
	
}

