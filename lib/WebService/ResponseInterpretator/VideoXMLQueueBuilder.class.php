<?php

class VideoXMLQueueBuilder extends SimpleWebResponseInterpretator{
	
	public function execute( $response ){
		parent::execute( $response );
		
		$this->createXMLQueueFiles();
		
		
	}
	
	
	public function createXMLQueueFiles(){
		$xml = new SimpleXMLElementExtended( $this->getXMLContent() );
		
		$c = 0;
		$n = 0;
		$time = time();
		$result = array();
		foreach( $xml->vod_title as $vid ){
			
			$result[] = $vid->asXML();
			++$c;
			
			if( $c >= 50 ){
				$c = 0;
				file_put_contents( sfConfig::get('sf_upload_dir') . '/xml/videos/videos_' . $time . '_' . $n++ . '.xml', implode(PHP_EOL, $result) );
				$result = array();	
			}
		}
		
		if( !empty( $result ) ){
				file_put_contents( sfConfig::get('sf_upload_dir') . '/xml/videos/videos_' . $time . '_' . $n++ . '.xml', implode(PHP_EOL, $result) );
				$result = array();			
		}
			
		
		
	}
	
	
	
	
	public function convertResponse2Array(){}
	
	
}