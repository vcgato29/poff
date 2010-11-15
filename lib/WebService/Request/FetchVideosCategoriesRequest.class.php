<?php

class FetchVideosCategoriesRequest extends SimpleWebRequest{
	
	public function send(){
		$response = parent::send();
		
		if( $response ){
			$response->setResponseInterpretator( new VideoCategoriesMapper($this) );
		}
		
		return $response;
	}
	
	
	public function __construct( $params ){
		
		$params['url'] = 'http://webservice.vifi.ee/videos/categories';
		$params['request_data'] = "";
		$params['method'] = 'POST';
		

		
		parent::__construct( $params );
	}
	
}