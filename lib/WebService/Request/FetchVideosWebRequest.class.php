<?php

class FetchVideosWebRequest extends SimpleWebRequest{
	
	public function send(){
//		$response = parent::send();
//		
//		if( $response ){
//			$response->setResponseInterpretator( new VideosMapper($this) );
//		}
//		
//		return $response;

		
		return $response;
		
	}
	
	
	public function getContentForResponse(){
		
	}
	
	
	public function __construct( $params ){
		
//		$params['url'] = 'http://webservice.vifi.ee/videos';
//		$params['request_data'] = "release_date_start=" . time();
//		$params['request_data'] = '';
//		$params['method'] = 'POST';
//	
//		parent::__construct( $params );
	}
	
}