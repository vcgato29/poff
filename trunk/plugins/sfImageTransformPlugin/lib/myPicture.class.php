<?php


class myPicture{
  
  private $perfomredActions = array();
  private $originalFilePath = false;

  private $sfImageInstance = false;
  
  public function __construct( $filename='', $mime='', $adapter='' ){
  	$this->originalFilePath = $filename;

	if(!file_exists($this->originalFilePath) || !is_file($this->originalFilePath))
			throw new sfImageTransformException();
  	//parent::__construct($filename, $mime, $adapter);
  }
	
  public function resize($width, $height, $inflate = true, $proportional = false){

	  $width = $width <= 0 ? 100 : $width;
	  $height = $height <= 0 ? 100 : $height;

  	$ar['method'] = 'resize';
  	$ar['params'] = array($width, $height, $inflate, $proportional);
  	
  	$this->performedActions[] = $ar;
  	
  	return $this;
  }
  
  
  public function thumbnail($width, $height, $method='fit', $background=null){
  	$ar['method'] = 'thumbnail';
  	$ar['params'] = array($width, $height, $method, $background);
  	$this->performedActions[] = $ar;
  	
  	return $this;
  }

  
  public function executeActions(){
  	if(!$this->performedActions) return $this;


  	
  	foreach($this->performedActions as $ar){
  		$last = $this->getSfImageInstance()->$ar['method']($ar['params'][0], $ar['params'][1], $ar['params'][2], $ar['params'][3]);
  	}
  	
  }
  
  
  public function getSfImageInstance(){
	  if(!$this->sfImageInstance){
		  $this->sfImageInstance = new sfImage($this->getOriginalFilePath());
	  }

	  return $this->sfImageInstance;
  }

  public function url($redo = false, $full = false){

  	
  	if($redo || !file_exists($this->getCachedFileFullPath()) ){
	  	$this->executeActions();
		
	  	if(!file_exists(dirname($this->getCachedFileFullPath()))) mkdir( dirname( $this->getCachedFileFullPath() ), 0777, true);
	  	
	  	$this->getSfImageInstance()->saveAs($this->getCachedFileFullPath());
  	}
  	
  	return $this->getCachedFileWebPath();
  }
  
  
  public function getCachedFileWebPath(){

  	return dirname($this->getOriginalFileWebPath()) . '/' . $this->getCacheFolderName() . '/' . basename($this->getOriginalFileWebPath());
  }
  
  public function getOriginalFileWebPath(){
  	return  str_replace( '\\', '/', str_replace(sfConfig::get('sf_web_dir'),'',$this->getOriginalFilePath()) );
  }
  
  public function getCachedFileFullPath(){
  	return str_replace( '\\', '/', dirname( $this->getOriginalFilePath() ) . '/' . $this->getCacheFolderName() . '/' . basename( $this->getOriginalFilePath() ) );
  }
  
  public function getCacheFolderName(){
  	
  	
  	$name = "cache_";
    foreach($this->performedActions as $ar){
  		$name = $name . $ar['method'];
  		foreach($ar['params'] as $val)
  			$name .= '_' . $val;
  	}
  	return $name;
  }
  
  public function getOriginalFilePath(){
  	return $this->originalFilePath;
  }
	
	
  static function getInstance($filename, $redo = false){
  	try{
		return  new myPicture( sfConfig::get('sf_upload_dir')  . $filename);
  	}catch(sfImageTransformException $e){
  		return  new myPicture( sfConfig::get('sf_upload_dir') . DIRECTORY_SEPARATOR . 'notfound.jpg');	
  	}
  	
  }
  

	
	
}