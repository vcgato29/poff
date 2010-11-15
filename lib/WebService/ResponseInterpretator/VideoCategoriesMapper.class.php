<?php
class VideoCategoriesMapper extends SimpleWebResponseInterpretator{
	
	
	public function getResultCollection(){
		if( $this->collection === false ){
			$this->collection = new Doctrine_collection('ProductGroup', 'import_code');
		}	
		
		return $this->collection;
	}
	
	
	
	public function execute( $response ){
		parent::execute( $response );
		
		
		$this->getResultCollection()->merge( $this->getExistingCategories() );		
		$this->getResultCollection()->synchronizeFromArray( $this->getResponseArray() );
		
		
		return $this->getResultCollection();

	}
	
	
	
	public function getExistingCategories(){
		
		$q = Doctrine::getTable('ProductGroup')->createQuery('bycodes')
			->from('ProductGroup pg')
			->whereIn('import_code', $this->getImportCodes());
			
		$cats = $q->execute();
		
		return $cats;

	}
	
	
	
	public function convertResponse2Array(){
	
		$result = array();
		$categoriesXML = new SimpleXMLElementExtended( $this->getXMLContent() );
		
		foreach( $categoriesXML->category as $cat ){
			$result[(int)$cat->id] = array( 'import_code' => (int)$cat->id, 'title' => (string)$cat->name );
		}
		
		return $result;
	} 
	
}