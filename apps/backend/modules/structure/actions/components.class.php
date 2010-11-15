<?php
class structureComponents extends sfComponents
{
	
	public function preExecute()
	{
		

	}
	
	public function executeBackendModulesBox( $request )
	{
		
		
		$this->setParameters();
		if( !$this->nodeID ){
			return sfView::NONE;
		}		
		
		$node = Doctrine::getTable('Structure')->find( $this->nodeID );
		$groupedModules = $node->getMyModules();
		
		$backendModules = array();
		
		
		foreach( $groupedModules as $placeHolder => $moduleArray ){
			foreach( $moduleArray as $frontendModule ){
				$backendModules[$frontendModule['name']]['submodules'] = $frontendModule->getBackendModules()->toArray();
				
				foreach( $backendModules[$frontendModule['name']]['submodules'] as $mod )
					if( $request->getParameter('module') == $mod['module_name'] ){
							$backendModules[$frontendModule['name']]['selected'] = true;
					}
			}
		}
		
		
		# because we want to show ALL banner_groups, banners, news_groups, news, under THE ROOT node in module box
		$this->structRoot = Doctrine::getTable('Structure')->getRoot();
		if( $this->nodeID == $this->structRoot->id ){
			$this->nodeID = 0;
		}
		
		$this->backendModules = $backendModules;
		
	}
	
	
	
  public function executeLeftmenu()
  {
  	
  	 $this->setParameters();
	 $this->languages = Doctrine::getTable( 'Structure' )->getLanguages();
	 
  }
  
  
  
  public function executeLeftmenubody()
  {
  	$this->setParameters();
  	
  	$result = array();
  	$firstLevel = Doctrine_Core::getTable('Structure')->getFirstActualLevel( $this->selectedLanguage );
  	if( $this->nodeID ){
		$this->curStruct = Doctrine::getTable('Structure')->find( $this->nodeID );
	  	$this->selectedNodes =  array_merge( $this->curStruct->getStructureParentsIDs(),
	  								 	array( $this->curStruct->id ));
  	}
  	
  	
  	foreach( $firstLevel as $firstElement ){
  		$elementArray = $firstElement->toArray();
  		if( $this->nodeID )
	  		$firstElement->populateWithChildren( $elementArray,	$this->selectedNodes );
  		$result[] = $elementArray;	
  	}
  	
  	$this->structureMenu = $result;
  	
  }
  
  
  /* automatically hiding current folder and all descendants */
  public function executeOpenedNodesLedder()
  {
  	
  	$randID = $this->exceptNodes[0]['id'];
  	$struct = Doctrine::getTable('Structure')->find( $randID );
  	
  	$parent = $struct->getNode()->getParent();
  	
  	$ignoreList = array();
  	$selectedList = array();
  	
  	foreach( $parent->getNode()->getDescendants() as $ignoreNode )
  		$ignoreList[] = $ignoreNode->id;
  		
  	$ignoreList[] = $parent->id;
  		
  	$tree = Doctrine::getTable('Structure')->getTree()->fetchTree();
	foreach( $tree as $node  )
		$selectedList[] = $node->id;
  	
  	
	
	//echo $this->permission;
	$tree[0]->populateWithChildren( $elementArray,	$selectedList, $this->checkPermissions, $this->permission, $this->getUser() );
  	
  	$this->ignoreNodeList = $ignoreList;
  	$this->structureMenu = $elementArray;
  	

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