<?php

class VideoPicsMapper extends SimpleWebResponseInterpretator{
	
	public function execute( $response ){
		parent::execute($response);

				
		$this->transientNewItemsCreate();
		
		foreach( $this->getResultCollection() as $pic ){
			$pic->save();
		}
		
		
	}
	
	
	public function transientNewItemsCreate(){
		
		
		foreach( $this->getResponseArray() as $item ){
			
			$prod = Doctrine::getTable('Product')->findOneByCode($item['product_code']);
			if( !$prod )continue;

			$picObj = Doctrine::getTable('ProductPictures')->findOneByProductIdAndParameter( $prod['id'], $item['parameter'] );
				
			
			if( $picObj ){ 	# do some sort of syncronizing...

			}else{	# create totally new object
				
				$item['product_id'] = $prod['id'];
				
				$prodPic = new ProductPictures();
				$prodPic->fromArray( $item );
				
				$this->downloadVideoPic( $item['file'] );
				
				
				$this->getResultCollection()->add($prodPic);
			}
			
		}
		
		//exit;
		
	}
	
	
	public function downloadVideoPic( $file ){
		
		$content = file_get_contents('http://webservice.vifi.ee' . $file );
		
		@mkdir( dirname( $this->getPictureFilePath($file) ), 0777, true );
		file_put_contents( $this->getPictureFilePath($file), $content );
		
		
	}
	
	
	public function getPictureFilePath( $file ){
		return sfConfig::get('sf_upload_dir') . $file;
	}
	
	
	public function getImportCodes(){
		return array();
	}
	
	public function convertResponse2Array(){
		$result = array();
		$picsXML = new SimpleXMLElementExtended( $this->getXMLContent() );
				
		foreach( $picsXML->vod_titles->vod_title as $pic ){
			
			foreach( $pic->images->image as $im ){
				$picAr = array();
				$im = (array)($im);
				
				$picAr['product_code'] = (int)$pic->id;
				$picAr['file'] = $im['url'];
				$picAr['parameter'] = $im['type'];

				$result[] = $picAr;
			}
		}

		return $result;
		
		
	}
	
	public function getResultCollection(){
		if( $this->collection === false ){
			$this->collection = new Doctrine_collection('ProductPictures');
		}	
		
		return $this->collection;
	}
}