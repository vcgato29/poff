<?php

class parameter_groupActions extends MyAction{
	
	public function executeIndex(){
		
	}
	
	public function executeToggleGroup($request){
		
		$storedSelected = $this->getUser()->getAttribute('parameter_group.selected_groups', array());
		
		if($request->hasParameter('group_id') && in_array($request->getParameter('group_id'), $storedSelected)){
			unset( $storedSelected[ array_search( $this->getRequestParameter('group_id'), $storedSelected ) ] );
		}else{
			$storedSelected[] = $request->getParameter('group_id');
		}
		
		$this->getUser()->setAttribute('parameter_group.selected_groups', $storedSelected);
		
		$this->redirect($request->getReferer());
	}
	
	public function executeToggleAll($request){
		if( $this->hasRequestParameter('toggle') ){
	   		
			$selectedGroups = array();
			
    		if( !$this->getRequestParameter('toggle') ){
    			
    		}else{
    			
				$ar = Doctrine::getTable('ParameterGroup')
					->createQuery('z')
					->select('id')
					->execute(array(),Doctrine::HYDRATE_NONE);
					
				foreach( $ar as $subAr )
					$selectedGroups[] = $subAr[0];
					
				$selectedGroups = array_unique( $selectedGroups );
    		}
    		
    		$this->getUser()->setAttribute('parameter_group.selected_groups', $selectedGroups);
    	}
    	$this->redirect($request->getReferer());
	}
	
	public function executeOrder( sfWebRequest $request ){
		
		switch( $request->getParameter('order') ){
			case 'up':
				Doctrine::getTable('ParameterGroup')->increasePriority( $request->getParameter('id') );
				break;
			case 'down':
				Doctrine::getTable('ParameterGroup')->decreasePriority( $request->getParameter('id') );
				break;
		}

		$this->redirect( $request->getReferer() );
		
	}
	
	
	public function executeNew( sfWebRequest $request ){
		$this->setLayout('popuplayout');	
		$this->form = new ParameterGroupForm();
		$this->languages = Doctrine::getTable('Language')->findAll();
	}
	
	public function executeCreate( sfWebRequest $request ){
		$this->form = new ParameterGroupForm();
		$this->processForm( $request, $this->form );
		
		$this->setTemplate('new');
		$this->setLayout('popuplayout');	
		$this->languages = Doctrine::getTable('Language')->findAll();
		
	}
	
	public function executeEdit( sfWebRequest $request ){
		$this->setLayout('popuplayout');	
		
		$this->form = new ParameterGroupForm( 
				Doctrine::getTable('ParameterGroup')->find($request->getParameter('id')) );
				
		$this->languages = Doctrine::getTable('Language')->findAll();
		
	}
	
	
	public function executeUpdate( sfWebRequest $request ){
		
		$this->form = new ParameterGroupForm( 
				Doctrine::getTable('ParameterGroup')->find( $request->getParameter('id') ) );
				
				
		$this->processForm( $request, $this->form );
		
		$this->setTemplate('edit');
		$this->setLayout('popuplayout');	
		$this->languages = Doctrine::getTable('Language')->findAll();
	}
	 
	
	public function processForm(sfWebRequest $request, $form ){

		 $form->bind($request->getParameter($form->getName()));
		 
	    if ($form->isValid())
	    {
			$paramGroup = $form->save();
			
			
			if( $request->hasParameter('parent_id') ){
				$paramGroup->getNode()->insertAsLastChildOf( 
					Doctrine::getTable('ParameterGroup')
						->find( $request->getParameter('parent_id') ) );
			}

			
			$this->redirect('@admin_page?module=parameter_group&action=edit&id=' . $paramGroup->getId() );
	    }else{
			
	    }

	}
	
	
	public function executeParameterPriority( sfWebRequest $request )
	{

		switch( $request->getParameter('order') ){
			case 'up':
				Doctrine::getTable('Parameter')->increasePriority( $request->getParameter('id') );
				break;
			case 'down':
				Doctrine::getTable('Parameter')->decreasePriority( $request->getParameter('id') );
				break;
		}
		
		$this->redirect( $request->getReferer() );
		
	}
	
	
	public function executeDelete( sfWebRequest $request ){
		
		Doctrine::getTable('ParameterGroup')
			->find( $request->getParameter('id') )
			->getNode()
			->delete();
		
		$this->redirect( $request->getReferer() );
	}
	
}