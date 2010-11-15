<?php
class SimpleWebResponse{
	
	protected $code;
	protected $content;
	protected $responseInterpretator;
	// compiles result into Object
	// for example: Doctrine_Collection
	// 				textual link for Movies
	//				status code about user
	//				
	
	public function __construct( $code, $content ){
		$this->setCode( $code );
		$this->setContent( $content );
	}
	
	
	public function setCode( $code ){
		$this->code = $code;
	}
	
	public function setContent( $content ){
		$this->content = $content;
	}
	
	public function getCode(){
		return $this->code;
	}
	
	public function getContent(){
		return $this->content;
	}
	
	public function setResponseInterpretator( $inter ){
		$this->responseInterpretator = $inter;
	}
	
	public function getResponseInterpretator(){
		return $this->responseInterpretator; 
	}
	
	public function interpret(){
		if( $this->getResponseInterpretator() )
			return $this->getResponseInterpretator()->execute($this);
		return false;
	}
	
	public function processResponse(){
		//delegates to interpretators with interpret method
		//returns
	}
	
	public function __toString(){
		return $this->getCode() . " \n " . $this->getContent();
	}
	
	
}