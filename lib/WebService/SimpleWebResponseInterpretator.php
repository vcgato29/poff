<?php

abstract class SimpleWebResponseInterpretator{

	public $response;
	
	protected $collection = false;
	protected $responseArray;
	
	public function setResponseArray( $responseArray ){
		$this->responseArray = $responseArray;
	}
	
	public function getResponseArray(){
		if( !$this->responseArray ){
			$this->setResponseArray( $this->convertResponse2Array( trim( $this->response->getContent() ) ) );
		}
		return $this->responseArray;
	}
	
	
	public function getForeignObjectByCode( $code ){
		$array = $this->getResponseArray();
		
		if( isset( $array[$code] ) )
			return $array[$code];
			
		return false;
	}
	
	
	public function getImportCodes(){
		$result = array();
		foreach( $this->getResponseArray() as $elem ){
			$result[] = $elem['import_code'];
		}
		return $result;
		
	}
	
	public function setResponse( $response ){
		$this->response = $response;
	}
	
	public function getResponse(){
		return $this->response;
	}
	
	public function getXMLContent(){
		$str = mb_convert_encoding( $this->response->getContent(), "UTF-8", 'auto'  );
		return <<<EOD
<data>
	{$str}
</data>
EOD;
	}
	
	
	
	abstract function convertResponse2Array();
	
	public function execute($response){
		$this->setResponse( $response );
	}
	
	public function getResultCollection(){}
	
}

/*
 * 			switch( $cat->state() ){
				case Doctrine_Record::STATE_PROXY:
					echo "proxy";
					break;
				case Doctrine_Record::STATE_TCLEAN:
					echo "tclean";
					break;
				case Doctrine_Record::STATE_TDIRTY:
					echo "tdirty";
					break;
				case Doctrine_Record::STATE_DIRTY:
					echo "dirty";
					break;
				case Doctrine_Record::STATE_CLEAN:
					echo "clean";
					break;
				case Doctrine_Record::STATE_LOCKED:
					echo "locked";
					break;
					
			}
 */