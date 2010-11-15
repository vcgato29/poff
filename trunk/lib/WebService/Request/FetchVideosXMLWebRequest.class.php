<?php

class FetchVideosXMLWebRequest extends SimpleWebRequest{
	
	public function send(){
		$response = parent::send();
		
		if( $response ){
			$response->setResponseInterpretator( new VideoXMLQueueBuilder($this) );
		}
		
		return $response;
	}
	
	
	public function __construct( $params ){
		
		$params['url'] = 'http://webservice.vifi.ee/videos';
		$params['request_data'] = "";
		$params['method'] = 'POST';
		
		parent::__construct( $params );
	}
	
}