<?php
class product_groupComponents extends sfComponents
{
	
	//method ready for refactoring 
	public function executeTree(){
		
	    $q = Doctrine::getTable('ProductGroup')
	        ->createQuery('c')
	        ->orderBy('lft');
        
    	$productGroups = $q->execute(array(), Doctrine::HYDRATE_RECORD_HIERARCHY);
		
        # selecting groups
        $selectedGroups = array( $this->getRequestParameter('group_id') );
        $storedSelected = $this->getUser()->getAttribute( 'product_group.selected_groups', array() );
        

    	$selectedGroups = @array_unique( @array_merge( $selectedGroups,$storedSelected ) );


    	$this->selectedGroups = $selectedGroups;
    	
        	
        $this->productGroups = $productGroups->toArray();
		
	}
}