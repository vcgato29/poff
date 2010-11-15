<?php
class parameter_groupComponents extends sfComponents
{
	
	public function executeTree(){

        $this->parameterGroups = Doctrine::getTable('ParameterGroup')->getFullHierarchy()->toArray();
        
        # selecting groups
        $selectedGroups = array( $this->getRequestParameter('group_id') );
        $storedSelected = $this->getUser()->getAttribute( 'parameter_group.selected_groups', array() );
        			
        			
    	$selectedGroups = @array_unique( @array_merge( $selectedGroups,$storedSelected ) );
    	

    	$this->getUser()->setAttribute( 'parameter_group.selected_groups', $selectedGroups );
    	$this->selectedGroups = $selectedGroups;
    	
		
	}
}