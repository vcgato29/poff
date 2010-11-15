<?php

class product_groupActions extends MyAction{
	public function executeIndex(){
	}
	
	public function executeToggleGroup($request){
		
		$storedSelected = $this->getUser()->getAttribute('product_group.selected_groups', array());
		
		if($request->hasParameter('group_id') && in_array($request->getParameter('group_id'), $storedSelected)){
			unset( $storedSelected[ array_search( $this->getRequestParameter('group_id'), $storedSelected ) ] );
		}else{
			$storedSelected[] = $request->getParameter('group_id');
		}
		
		$this->getUser()->setAttribute('product_group.selected_groups', $storedSelected);
		
		$this->redirect($request->getReferer());
	}
	
	public function executeToggleAll($request){
		if( $this->hasRequestParameter('toggle') ){
	   		
			$selectedGroups = array();
			
    		if( !$this->getRequestParameter('toggle') ){
    			
    		}else{
    			
				$ar = Doctrine::getTable('ProductGroup')
					->createQuery('z')
					->select('id')
					->execute(array(),Doctrine::HYDRATE_NONE);
					
				foreach( $ar as $subAr )
					$selectedGroups[] = $subAr[0];
					
				$selectedGroups = array_unique( $selectedGroups );
    		}
    		
    		$this->getUser()->setAttribute('product_group.selected_groups', $selectedGroups);
    	}
    	$this->redirect($request->getReferer());
	}
	
	public function executeOrder( sfWebRequest $request ){
		
		switch( $request->getParameter('order') ){
			case 'up':
				Doctrine::getTable('ProductGroup')->increasePriority( $request->getParameter('id') );
				break;
			case 'down':
				Doctrine::getTable('ProductGroup')->decreasePriority( $request->getParameter('id') );
				break;
		}
		
		$this->redirect( $request->getReferer() );
		
	}
	
	
	public function executeNew( sfWebRequest $request ){
		$this->setLayout('popuplayout');	
		$this->form = new ProductGroupForm();
		$this->languages = Doctrine::getTable('Language')->findAll();
	}
	
	public function executeCreate( sfWebRequest $request ){
		$this->form = new ProductGroupForm();
		$this->processForm( $request, $this->form );
		
		$this->setTemplate('new');
		$this->setLayout('popuplayout');	
		$this->languages = Doctrine::getTable('Language')->findAll();
		
	}
	
	public function executeEdit( sfWebRequest $request ){
		$this->setLayout('popuplayout');	
		
		$this->form = new ProductGroupForm( 
				Doctrine::getTable('ProductGroup')->find($request->getParameter('id')) );
				
		$this->languages = Doctrine::getTable('Language')->findAll();
		
	}
	
	
	public function executeUpdate( sfWebRequest $request ){
		
		$this->form = new ProductGroupForm( 
				Doctrine::getTable('ProductGroup')->find( $request->getParameter('id') ) );
				
				
		$this->processForm( $request, $this->form );
		
		$this->setTemplate('edit');
		$this->setLayout('popuplayout');	
		$this->languages = Doctrine::getTable('Language')->findAll();
	}
	 
	
	public function processForm(sfWebRequest $request, $form ){

		 $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
		 
	    if ($form->isValid())
	    {
			$prodGroup = $form->save();
			
			
			if( $request->hasParameter('parent_id') ){
				$prodGroup->getNode()->insertAsLastChildOf( 
					Doctrine::getTable('ProductGroup')
						->find( $request->getParameter('parent_id') ) );
						
//				print_r($prodGroup->toArray());
//				exit;
			}
			
			if( $request->hasParameter('connections') ){
				$connections = $request->getParameter('connections');
				$prodGroup->updateParameterGroupConnections( $connections );
			}

			//update connections with structure
			$prodGroup->updateStructureConnections( $request->getParameter('structure_connections', array()) );

			
			$this->redirect('@admin_page?module=product_group&action=edit&id=' . $prodGroup->getId() );
	    }else{
			
	    }

	}
	
	
	public function executeDelete( sfWebRequest $request ){
		
		Doctrine::getTable('ProductGroup')
			->find( $request->getParameter('id') )
			->getNode()
			->delete();
		
		$this->redirect( $request->getReferer() );
	}
	
}