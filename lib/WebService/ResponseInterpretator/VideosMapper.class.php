<?php
class VideosMapper extends SimpleWebResponseInterpretator{
	
	/*
	 	- Parse response XML to Array
	 	- Foreach product in Array apply one of scenarium ( update, insert, delete )
	 */
	public function execute( $response ){
		parent::execute($response);

		$this->transientExistingItemsDelete();	# find items not present in XML, put status DROPPED 
		$this->transientExistingItemsUpdate();	# find items present in XML and DB, syncronize DB fields
		$this->transientNewItemsCreate();		# find items not present in DB, create new objects
		
		
		foreach( $this->getResultCollection() as $item )
			$item->save();
				 
	}
	
	
	
	
	public function transientExistingItemsDelete(){
		$import_codes = $this->getImportCodes();
		
		$q = Doctrine::getTable('Product')->createQuery('prodsync')
			->select('p.*')
			->from('Product p')
			->whereNotIn('p.code', $import_codes);
			
		$coll = $q->execute();
		
		foreach( $coll as $item ){
			$item['status'] = 'dropped';
		}
		
		$this->getResultCollection()->merge( $coll );
		
	}

	/* 
	 *	- Syncronize local videos fields with WebService response info
	 *	- Merge with result collection  
	 */
	public function transientExistingItemsUpdate(){
		$existingVideos = $this->getExistingVideos();

		foreach( $this->getResponseArray() as $item ){
			if( $existingVideos->contains( $item['code'] ) ){
				$fromArray = $this->prepareArrayForObjectCreation($item);
				$existingVideos->get($item['code'])->fromArray( $fromArray );
			}
		}
		
		$this->getResultCollection()->merge($existingVideos);
				
	}
	
	
	/*
	 * - Get videos from DB accordingly to CODEs in XML 
	 */
	public function getExistingVideos(){
		$import_codes= $this->getImportCodes();
		
		$q = Doctrine::getTable('Product')->createQuery('prodsync')
			->select('p.*')
			->from('Product p')
			->whereIn('p.code', $import_codes);
			
		
		
		$coll = new Doctrine_Collection('Product', 'code');
		$coll->merge($q->execute());
		
		return $coll;
		
	}
	
	
	public function transientNewItemsCreate(){
		$import_codes = $this->getImportCodes();
		
		foreach( $this->getResponseArray() as $item ){
			if( !$this->getResultCollection()->contains( $item['code'] ) ){
				$this->getResultCollection()->add( $this->createTransientItem( $item ) );
			}
		}
		
	}
	
	
	public function createTransientItem( $dataArray ){
		$video = new VideoProduct();
		
		$video->fromArray( $this->createNewItemConnections( 
							$this->prepareArrayForObjectCreation( $dataArray ) ) );

		return $video;
	}
	
	
	public function createNewItemConnections( $dataArray ){		
		$this->loadCategoriesConnections( $dataArray['categories'], $dataArray );
		return $dataArray;
	}
	
	
	public function loadCategoriesConnections( $cats, &$dataArray ){
		
		$coll = new Doctrine_Collection( 'ProductGroup', 'import_code' );
		
		$allCats = Doctrine::getTable('ProductGroup')->createQuery('imported_groups')
			->from('ProductGroup pg')
			->where('pg.import_code != ?', 'NULL')
			->execute();
		
		$allCats = $coll->merge( $allCats );
		
		
		
		
		foreach( $cats as $index => $cat ){
			if( $allCats->contains( $cat['id'] ) ){
				$cat_obj = $allCats->get($cat['id']);
				$dataArray['ProductGroups'][$index]['group_id'] = $cat_obj['id'];
			}
		}

	}
	

	
	public function prepareArrayForObjectCreation( $dataArray ){
		$result = $dataArray;
		
		$str = '';
		foreach( $dataArray['actors'] as $actAr )
			$str .= $actAr['name'] . PHP_EOL;
		$result['actors'] = $str;
		
		
		$str = '';
		foreach( $dataArray['directors'] as $actAr )
			$str .= $actAr['name'] . PHP_EOL;
		$result['director'] = $str;
		
		
		
		unset( $result['languages'] );
		$result['Translation']['fi']['description'] = $result['description'];
		$result['status'] = 'new';
		$result['type'] = 'video';
		unset( $result['description'] ); 
		
		
		return $result;
	}

	
	public function getImportCodes(){
		$result = array();
		
		foreach( $this->getResponseArray() as $video )
			$result[] = $video['code'];
		
		return $result;
	}
	
	public function convertResponse2Array(){
		$result = array();
		$videosXML = new SimpleXMLElementExtended( $this->getXMLContent() );
		
		foreach( $videosXML->vod_title as $vid ){
			
			$ar = (array)$vid;
			
			// categories
			$cats = array();
			foreach( $ar['categories']->category as $cat ){
				$cats[] = (array)$cat;
			}
			$ar['categories'] = $cats;

			// code
			$ar['code'] = $ar['id'];
			unset($ar['id']);
			
			// actors
			$acts = array();
			if( isset( $ar['actors'] ) && $ar['actors']->actor ){
				foreach( $ar['actors']->actor as $actor)
					$acts[] = (array)$actor;
			}
			$ar['actors'] = $acts;
			
			
			//directors
			$acts = array();
			foreach( $ar['directors']->director as $actor){
				$acts[] = (array)$actor;
			}
			$ar['directors'] = $acts;
			
			//countries
			$acts = array();
			foreach( $ar['countries']->country as $actor){
				$acts[] = (array)$actor;
			}
			$ar['countries'] = $acts;
			

			// languages
			//$ar['languages'] = (array)$ar['languages'];
			//$ar['languages'] = (array)$ar['languages']['language'];
			
			$result[] = $ar;
		}
		
		return $result;
	}
	
	
	public function getResultCollection(){
		if( $this->collection === false ){
			$this->collection = new Doctrine_collection('Product', 'code');
		}	
		
		return $this->collection;
	}
	
}