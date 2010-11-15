<?php

class MockVideosResponse extends SimpleWebResponse{
	
	public $selectedFile = false;
	
	public function __construct(){
		parent::__construct(200, $this->getXMLContent());

	}
	
	
	public function getXMLContent(){
		if( $this->getXMLFile() ){
			return file_get_contents( $this->getXMLFile() );
		}
		return '';
	}
	
	
	public function getXMLFile(){
		if( $this->selectedFile === false ){
			$handle = opendir( $this->getXMLQueueDirPath() );
		    while (false !== ($file = readdir($handle))) {
		      	if ($file != "." && $file != "..") {
	            		$this->selectedFile = $this->getXMLQueueDirPath() . $file;
	            		break;
	        	}
	    	}
		}
		
		return $this->selectedFile;
	}
	
	
	public function getXMLQueueDirPath(){
		return sfConfig::get('sf_upload_dir') .'/xml/videos/';
	}
	
	
	public function send(){}
	
}