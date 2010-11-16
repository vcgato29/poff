<?php

class SimpleWebRequest{

	protected $url;
	protected $method;
	protected $responseCode;
	protected $responseContent;
	protected $requestData;
	protected $requestSender;

	protected $mainURL = 'http://webservice.vifi.ee';


	protected $responseInterpetator = null;

	public function send(){
		if( $this->getRequestSender() ){
			return $this->getRequestSender()->send( $this ) ;
		}else{
			echo "no sender";
			return false;
		}
	}






	public function __construct( $params ){

		$this->setUrl( $params['url'] );
		$this->setRequestData( $params['request_data'] );

		$this->setMethod( $params['method'] );
		$this->setRequestSender( new SimpleWebRequestSender() );

	}

	public function getUrl(){
		return $this->url;
	}


	public function getMethod(){
		return $this->method;
	}


	public function getResponseCode(){
		return $this->responseCode;
	}

	public function getRequestdata(){
		return $this->requestData;
	}


	public function setUrl( $url ){
		$this->url = $url;
	}

	public function setMethod( $method ){
		$this->method = $method;
	}


	public function setRequestData( $requestData ){
		$this->requestData = $requestData;
	}


	public function setRequestSender( $requestSender ){
		$this->requestSender = $requestSender;
	}


	public function getRequestSender(){
		return $this->requestSender;
	}

}