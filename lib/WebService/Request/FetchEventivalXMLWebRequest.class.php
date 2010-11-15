<?php

class FetchEventivalXMLWebRequest extends SimpleWebRequest{

	public function send() {
		$this->response = parent::send();
		if( $this->response ){
			$xmlObject = new EventivalXMLMapper();
			$xmlObject->execute($this->response->getContent());
		}

		return $xmlObject;
	}

	public function __construct( $params ){

		//$params['url'] = '';
		$params['request_data'] = "";
		$params['method'] = 'GET';

		parent::__construct( $params );
	}
}