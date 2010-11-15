<?php


class VideosWebService extends SimpleWebService{
	
	public function getRequest( $requestType, $params ){
		
		$request = null;
		
		switch( $requestType ){
			case 'videos_xml':
				$request = new FetchVideosXMLWebRequest( $params );
				break;
			case 'videos':
				$request = new FetchVideosWebRequest( $params );
				break;
			case 'category':
				$request = new FetchVideosCategoriesRequest( $params );
				break;
				
		}
				
		return $request;
	}
	
}
