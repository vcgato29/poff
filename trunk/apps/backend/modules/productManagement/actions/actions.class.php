<?php
require_once dirname(__FILE__).'/../../product/actions/actions.class.php';


/**
 * product actions.
 *
 * @package    jobeet
 * @subpackage product
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class productManagementActions extends productActions
{

	public function preExecute(){
	    parent::preExecute();

	    require_once dirname(__FILE__).'/../lib/productManagementHelper.class.php';
	    $this->helper = new productManagementHelper();
	}

	public function executeIndex(sfWebRequest $request){

	    $this->setLayout('layout_productManagement');
	    parent::executeIndex($request);
	}

	public function executeUpdate(sfWebRequest $request){
	    parent::executeUpdate($request);
	}

	public function executeFilter(sfWebRequest $request){
		parent::executeFilter($request);
		$this->redirect($request->getReferer());

	}

	public function executeEdit(sfWebRequest $request){
	    parent::executeEdit($request);
	}

	protected function buildQuery()
	{
	  $q = parent::buildQuery();
	    return $q->andWhere($q->getRootAlias().'.created_by = ?', $this->getUser()->getGuardUser()->getId());
	}
	
	
}
