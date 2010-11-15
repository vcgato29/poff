<?php

require_once dirname(__FILE__).'/../lib/structureGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/structureGeneratorHelper.class.php';

/**
 * structure actions.
 *
 * @package    jobeet
 * @subpackage structure
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class structureActions extends autoStructureActions
{
	public function preExecute(){
		
		$curNodeID = $this->getRequest()->hasParameter('nodeid') ? $this->getRequestParameter('nodeid') : Doctrine::getTable('Structure')->getRoot()->getId();
		$this->getUser()->setAttribute('current.node', $curNodeID );
		
	}

    public function executeChangeLanguage($request)
    {
    	
		$abr = array();
		foreach( Doctrine::getTable('Language')->findAll() as $lang )
			$abr[] = $lang->getAbr();
    	
      $this->form = new sfFormLanguage($this->getUser(), array('languages' => $abr));
      if ($this->form->process($request))
      {
        return $this->redirect('@homepage');
      }
 

      return $this->redirect('@homepage');
    }

	
	public function executeIndex( sfWebRequest $request ){
	  	$this->setParameters();
	  	$structureList = array();
		//$this->structureList = $this->curStruct->getStructureChilds();
		foreach( $this->curStruct->getStructureChilds() as  $child ){
			$structureList[$child->id] = $child->toArray();
			if( $child->created_by )
				$structureList[$child->id]['created_by_user'] = Doctrine::getTable('sfGuardUser')->find( $child->created_by );
			if( $child->updated_by )
				$structureList[$child->id]['updated_by_user'] = Doctrine::getTable('sfGuardUser')->find( $child->updated_by );
		}
		
		$this->structureList = $structureList;
	}
	
	public function executeOrder( sfWebRequest $request )
	{
		$this->nodeID = $request->getParameter('nodeid');
		
		$this->forwardSecureUnless( 
			Doctrine::getTable('Structure')
				->find( $this->nodeID )->getParent()->isPermittedForUser( $this->getUser(), myUser::PERM_RW ) );
		
		switch( $request->getParameter('order') ){
			case 'up':
				Doctrine::getTable('Structure')->increasePriority( $this->nodeID );
				break;
			case 'down':
				Doctrine::getTable('Structure')->decreasePriority( $this->nodeID );
				break;
		}
		
		
		$this->redirect( $this->getRequest()->getReferer() ); 

	}
	
	public function executeEdit(sfWebRequest $request)
	{
		$this->nodeID = $request->getParameter('id');
		
		$this->forwardSecureUnless( 
			Doctrine::getTable('Structure')
				->find( $this->nodeID )->isPermittedForUser( $this->getUser(), myUser::PERM_READ ) );
		
		$this->setLayout('popuplayout');
	  	$this->form = Doctrine::getTable('Structure')->find( $this->nodeID )->getCustomForm();
	}
	
	
	public function executeUpdate( sfWebRequest $request )
	{
		$this->setLayout('popuplayout');
		$this->nodeID = isset( $_GET['nodeid'] ) ? $_GET['nodeid'] : 0;
				
		$s = Doctrine::getTable('Structure')->find( $request->getParameter('id') );
		
		$this->forwardSecureUnless( 
			$s->isPermittedForUser( $this->getUser(), myUser::PERM_RW ) );
		
		
		$this->form = $s->getCustomForm();
		
		
  		if( $obj = $this->form->processForm( $request, $this ) ){
  			 $this->redirect(array('sf_route' => 'structure_edit', 'sf_subject' => $obj));
  		}
  		else
  			$this->setTemplate('edit');
		
	}
	
	
	public function executeNew( sfWebRequest $request )
	{
		$this->setLayout('popuplayout');
		$s = new Structure();
		$s->parentID = $request->getParameter('parentID');
		
		$this->forwardSecureUnless( 
			Doctrine::getTable('Structure')
				->find( $s->parentID )->isPermittedForUser( $this->getUser(), myUser::PERM_RW ) );
		
		$s->lang = $request->getParameter('lang', 'est');
		$this->form = new StructureForm( $s );
		
	}
	
	public function executeCreate( sfWebRequest $request )
	{
	
		$this->form = new StructureForm();
  		if( $obj = $this->form->processForm($request, $this ) )
  			$this->redirect( $this->generateUrl('structure_child_edit', $obj->toArray()) );
		else{
			$this->setLayout('popuplayout');
  			$this->setTemplate('new');			
		}
  		
	}
	
	public function executeDelete( sfWebRequest $request )
	{
		
		$struct = Doctrine::getTable('Structure')->find( $request->getParameter('id') );
		
		$this->forwardSecureUnless( 
			$struct->isPermittedForUser( $this->getUser(), myUser::PERM_RWD ) );
		
		$struct->getNode()->delete();
		$this->redirect( $this->getRequest()->getReferer() ); 
	}
	
	
	
	
	
	# common deletion stuff;
	public function executeCommonDelete( $request )
	{
		
		$this->setLayout('popuplayout');
		
		switch( $request->getMethod() ){
			case sfRequest::GET:
				$this->commonDeleteForm( $request );
				break;
			case sfRequest::POST:
				$this->commonDeleteHandlePost( $request );
				break;
		}
		
	}
	
	public function commonDeleteForm( $request )
	{
		$nodes = $request->getParameter( 'struct' );
		$this->curNodes = Doctrine::getTable('Structure')->getNodesByIDs( $nodes );
		
		foreach( $this->curNodes as $node )
			$this->forwardSecureUnless( 
				$node->isPermittedForUser( $this->getUser(), myUser::PERM_RWD ) );
	}
	
	public function commonDeleteHandlePost( $request )
	{
		$nodes = $request->getParameter( 'struct' );
		
		foreach( $nodes as $node ){
			$nodeObj = Doctrine::getTable('Structure')->find( $node );
			
			$this->forwardSecureUnless( 
				$nodeObj->isPermittedForUser( $this->getUser(), myUser::PERM_RWD ) );
			
			$nodeObj->getNode()->delete();
		}
		
		$this->setLayout( 'closePopup' );
		$this->setTemplate('closePopup');
		
	}
	
	
	# common move stuff
	public function executeCommonMove( $request )
	{
		$this->setLayout('popuplayout');	
		switch( $request->getMethod() )
		{
			case sfRequest::GET:
				$this->commonMoveForm( $request );
				break;
			case sfRequest::POST:
				$this->commonMoveHandlePost( $request );
				break;
		}
			
		
	}	
	
	public function commonMoveForm( $request )
	{
		$nodes = $request->getParameter( 'struct' );
		$this->curNodes = Doctrine::getTable('Structure')->getNodesByIDs( $nodes );
		
		foreach( $this->curNodes as $node )
			$this->forwardSecureUnless( 
				$node->isPermittedForUser( $this->getUser(), myUser::PERM_RWD ) );
	}
	
	public function commonMoveHandlePost( $request )
	{
		
		$nodes = $request->getParameter( 'struct' );
		$destinationNodeID = 	$request->getParameter( 'selected_node' );
		$destinationNode = Doctrine::getTable('Structure')->find( $destinationNodeID );
		
		$this->forwardSecureUnless( 
				$destinationNode->isPermittedForUser( $this->getUser(), myUser::PERM_RW ) );
		
		foreach( $nodes as $node ){
			$nodeObj = Doctrine::getTable('Structure')->find( $node );
			
			$this->forwardSecureUnless( 
				$nodeObj->isPermittedForUser( $this->getUser(), myUser::PERM_RWD ) );
				
			$nodeObj->moveAsLastChildOfRecursively( $destinationNode );
		}
		
		
		$this->setLayout( 'closePopup' );
		$this->setTemplate('closePopup');
	}
	
	# common copy stuff
	public function executeCommonCopy( $request )
	{
		$this->setLayout('popuplayout');	
		switch( $request->getMethod() )
		{
			case sfRequest::GET:
				$this->commonCopyForm( $request );
				break;
			case sfRequest::POST:
				$this->commonCopyHandlePost( $request );
				break;
		}
			
		
	}	
	
	public function commonCopyForm( $request )
	{
		$nodes = $request->getParameter( 'struct' );
		$this->curNodes = Doctrine::getTable('Structure')->getNodesByIDs( $nodes );
		
		foreach( $this->curNodes as $node )
			$this->forwardSecureUnless( 
				$node->isPermittedForUser( $this->getUser(), myUser::PERM_READ ) );
	}
	
	public function commonCopyHandlePost( $request )
	{
		//Doctrine_Manager::getInstance()->setAttribute(Doctrine::ATTR_USE_DQL_CALLBACKS, false);
//		echo "Aaa";
//		exit;
		
		$nodes = $request->getParameter( 'struct' );
		$destinationNodeID = 	$request->getParameter( 'selected_node' );
		$destinationNode = Doctrine::getTable('Structure')->find( $destinationNodeID );
		
		$this->forwardSecureUnless( 
				$destinationNode->isPermittedForUser( $this->getUser(), myUser::PERM_RW ) );
		
		foreach( $nodes as $node ){
			
			$nodeObj = Doctrine::getTable('Structure')->find( $node );

			$this->forwardSecureUnless( 
				$nodeObj->isPermittedForUser( $this->getUser(), myUser::PERM_READ ) );
				
			$copy = $nodeObj->copy(true);
			$copy->setPri( 0 );
			$copy->insertAsLastChildOfRecursively( $destinationNode );
			
		}
		
		
		$this->setLayout( 'closePopup' );
		$this->setTemplate('closePopup');
	}
	
	public function executeCommonEdit( $request )
	{
		$this->structQuery = $_SERVER['QUERY_STRING']; // contains struct[]=1&struct[]=2 etc.
		$this->setLayout('popuplayout');
		switch( $request->getMethod() )
		{
			case sfRequest::GET:
				$this->commonEditForm( $request );
				break;
			case sfRequest::POST:
				$this->commonEditHandlePost( $request );
				break;
		}	
		
	}
	
	
	public function commonEditForm( $request )
	{
		$nodes = $request->getParameter( 'struct' );
		$forms = array();
		foreach( $nodes as $node ){
			if( $node == $request->getParameter('id') ){ // one form is already created in commonEditHandlePost method
				$forms[$node] = $this->form;
			}else{
				$nodeObj = Doctrine::getTable('Structure')->find( $node );
				$this->forwardSecureUnless( 
					$nodeObj->isPermittedForUser( $this->getUser(), myUser::PERM_READ ) );
				
				$forms[$node] = new StructureForm( $nodeObj );
			}
		}
		
		$this->forms = $forms;
	}
	
	
	public function commonEditHandlePost( $request )
	{
		$s = Doctrine::getTable('Structure')->find( $request->getParameter('id') );
		
		$this->forwardSecureUnless( 
				$s->isPermittedForUser( $this->getUser(), myUser::PERM_RW ) );
				
		$this->form = new StructureForm( $s );
		
  		if( $obj = $this->form->processForm( $request, $this ) ){
			$referer = $this->getRequest()->getReferer();
			$this->redirect($referer);
  		}
  		else
  			$this->commonEditForm( $request );
	}
	

	
	public function executeSettings(){

	    $structureList = array();
		foreach( Doctrine::getTable('Structure')->getLanguages() as  $child ){
			$structureList[$child->id] = $child->toArray();
			if( $child->created_by )
				$structureList[$child->id]['created_by_user'] = Doctrine::getTable('sfGuardUser')->find( $child->created_by );
			if( $child->updated_by )
				$structureList[$child->id]['updated_by_user'] = Doctrine::getTable('sfGuardUser')->find( $child->updated_by );
		}  
		$this->languageList = $structureList;
	}
	
	public function executeAddLanguage( $request )
	{


		$this->forwardSecureUnless( 
				Doctrine::getTable('Structure')->getRoot()->isPermittedForUser( $this->getUser(), myUser::PERM_RW ) );
				

		
		switch( $request->getMethod() )
		{
			case sfRequest::GET:
				$this->setLayout('popuplayout');
				$this->form = new StructureLanguageForm();

				break;
			case sfRequest::POST:
				$this->addLanguageHandlePost( $request );
				break;
		}
		

	}
	
	public function addLanguageHandlePost( $request )
	{
		$newLangNode = Doctrine::getTable( 'StructureLanguage' )->createLangNode( Doctrine::getTable('Language')->find( $request->getParameter( 'language' ) ) );
		$newLangNode->save();
		
		$this->setLayout( 'closePopup' );
		$this->setTemplate('closePopup');
			
	}
	
	

	
	
	
	public function executeEditLayout( $request )
	{
		$this->node = Doctrine::getTable( 'Structure' )->find( $request->getParameter( 'id' ) );
		
		$this->forwardSecureUnless( 
			$this->node->isPermittedForUser( $this->getUser(), myUser::PERM_RW ) );
		
		switch( $request->getMethod() )
		{
			case sfRequest::GET:
				$this->editLayoutForm( $request );
				break;
			case sfRequest::POST:
				$this->editLayoutHandlePost( $request );
				break;
		}
		
	}
	
	
	public function editLayoutForm( $request )
	{

		$this->setLayout('popuplayout');
		$this->nodeModules = $this->node->getMyModules();

		$groupedModules = array();
		foreach( Doctrine::getTable('PlaceholdersVsModules')->findAll() as $pm ){
			$groupedModules[$pm['placeholder']][] = $pm->getFrontendModule();	
		}
		
		$this->groupedModules = $groupedModules;
	}
	
	
	public function editLayoutHandlePost( $request )
	{
		
		$placeHolder = new PlaceHolder();
		$placeHolder->name = $request->getParameter('placeholder');
		$placeHolder->structure_id = $this->node->id;
		$placeHolder->frontend_module_id = $request->getParameter('frontend_module_id');
		
		$placeHolder->save();
		
		
		$this->redirect( $referer = $this->getRequest()->getReferer() );
		
	}
	
	
	public function executeDeleteLayoutModule( $request )
	{
	
		$this->forwardSecureUnless( 
				Doctrine::getTable('Placeholder')->find( $request->getParameter( 'id' ) )->getStructure()
					->isPermittedForUser( $this->getUser(), myUser::PERM_RWD ) );
					
		Doctrine::getTable( 'Placeholder' )->find( $request->getParameter( 'id' ) )->delete();
		$this->redirect( $referer = $this->getRequest()->getReferer() );
	}
	
	
	public function executeChangeModulePriority( $request )
	{

		$this->forwardSecureUnless( 
				Doctrine::getTable('Placeholder')->find( $request->getParameter( 'moduleID' ) )->getStructure()
					->isPermittedForUser( $this->getUser(), myUser::PERM_RW ) );
					
		switch( $request->getParameter( 'order' ) ){
			case 'up':
				Doctrine::getTable('Placeholder')->increasePriority($request->getParameter( 'moduleID' ));
				break;
			case 'down':
				Doctrine::getTable('Placeholder')->decreasePriority($request->getParameter( 'moduleID' ));
				break;
		}
		
		$this->redirect( $this->getRequest()->getReferer() );
	}
	
	
	
	public function executeCommonRights( $request ){
		$this->setLayout('popuplayout');
		
		switch( $request->getMethod() )
		{
			case sfRequest::GET:
				$this->commonRightsForm( $request );
				break;
			case sfRequest::POST:
				$this->commonRightsHandlePost( $request );
				break;
		}	
		
	}
	
	public function commonRightsForm( $request )
	{
		$result = array();
		$nodes = $request->getParameter('struct');
		$userGroups = Doctrine::getTable( 'AdminUserGroup' )->findAll();
		
			
		foreach( $nodes as $node ){
			$result[$node]['node_title'] = Doctrine::getTable( 'Structure' )->find( $node )->getTitle();
			
			$this->forwardSecureUnless( 
				Doctrine::getTable( 'Structure' )->find( $node )->isPermittedForUser( $this->getUser(), myUser::PERM_READ ) );
			
			foreach( $userGroups as $userGroup ){
				$result[$node]['user_groups'][$userGroup->id][] = $userGroup->toArray();
				$result[$node]['user_groups'][$userGroup->id]['permission'] = Doctrine::getTable( 'Structure' )->find( $node )->getPermissionForUserGroup( $userGroup->id );
				$result[$node]['user_groups'][$userGroup->id]['group_title'] = $userGroup->getName();
				$result[$node]['user_groups'][$userGroup->id]['not_inherited'] = 
					Doctrine::getTable('AdminUserGroupVsStructure')->
						find(array($node, $userGroup->id)) instanceof AdminUserGroupVsStructure;
				
				
			}
		}
		
		$this->resultArray = $result;
			
	}
	
	public function commonRightsHandlePost( $request )
	{
			$structArray = $request->getParameter('struct');
			
			
			foreach( $structArray as $structID => $groupArray  ){
				
				$this->forwardSecureUnless( 
					Doctrine::getTable( 'Structure' )->find( $structID )->isPermittedForUser( $this->getUser(), myUser::PERM_RWD ) || $this->getUser()->isSuperAdmin() );
				
				foreach( $groupArray as $groupID => $permission ){
					$rel = Doctrine::getTable('AdminUserGroupVsStructure')->find(array($structID, $groupID));
					if( !$rel instanceof AdminUserGroupVsStructure ){
						$rel = new AdminUserGroupVsStructure();
						$rel->setStructureId( $structID );
						$rel->setAdminUserGroupId( $groupID );
					}					
					if( $permission != -1 ){
						$rel->setPermission( $permission );

						$rel->save();
					}else{
						$rel->delete();
					}
				}
			}

			$this->redirect( $referer = $this->getRequest()->getReferer() );
	}
	
	
  public function setParameters(){
  	
  	$this->selectedLanguage = $this->getRequestParameter('lang');
  	if( !$this->nodeID )
  		$this->nodeID = isset( $_GET['nodeid'] ) ? $_GET['nodeid'] : false;

  	if( !$this->nodeID && $this->getUser()->getAttribute('current.node')){
		$this->nodeID = $this->getUser()->getAttribute('current.node');
  	}else{
  		$this->curStruct = false;
  	}
  	
  	if($this->nodeID){
  		$this->curStruct = Doctrine::getTable('Structure')->find( $this->nodeID );
  		$this->selectedLanguage = $this->curStruct->getLang();
  	}
  	
  }
	
	
	
	
}
