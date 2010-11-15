<?php

class Picture{
	
	public $name;
	public $type;
	public $width;
	public $height;
	public $ext = '.jpg';
	public $title;
	public $redo = false;
	
	public $params = array(
			'resize' => array( false, true ),
			'thumbnail' => array( 'center', null ) 
	);
	
	public $imageTransformer; # link to object that resizes, cropes and performes other picture transformations..

	public function __construct( $data ){
		$this->name = $data['name'];
		$this->title = isset( $data['title'] ) ? $data['title'] : 'no description';
		$this->type = $data['type'];
		$this->id = $data['id'];
		$this->width = $data['width'] == 0 ? 'original' : $data['width'];
		$this->height = $data['height'] == 0 ? 'original' : $data['height'];
		$this->ext  = isset( $data['ext'] ) ? $data['ext'] : '.jpg';
		$this->redo = $data['redo'];
		
		try{
			$this->imageTransformer = new sfImage( $this->getPicturePath() );
		}catch( sfImageTransformException $z ){
			$this->name = 'notfound';
			$this->type = '';
			$this->id = '';
			$this->width = 50;
			$this->height = 50;
			$this->ext = '.jpg';
			$this->imageTransformer = new sfImage( $this->getPicturePath() );
		}
		
	//$this->imageTransformer = new imageTransform(); # old image transformer
	}
	
	public function getLink(){
		return "/frontend_dev.php/pic/" . $this->name . "/" . $this->type . '/' . $this->width . '/' . $this->height . '/';
	}
	
	
	public function getRawLink( $mode ){
		
		$str =  $this->createCacheFile( $mode );
		$str = preg_replace('/(.*)uploads\/(.*)/i', '/uploads/\\2', $str);
		return 'http://' . $_SERVER['HTTP_HOST'] . $str;
			 
	}
	
	public function createCacheFile( $mode = 'resize' ){
		if( !file_exists( $this->getCacheDirectory( $mode ) ) ){
			if( !mkdir( $this->getCacheDirectory( $mode ), 0777 ) ){
					chmod( $this->getCacheDirectory( $mode ), 0777 );
			}
		}else{
			chmod( $this->getCacheDirectory( $mode ), 0777 );
		}
		
		
		if( !file_exists( $this->getCacheFile( $mode ) )  || $this->getRedo() ){
			$this->imageTransformer
				->$mode( $this->getWidth(), 
						 $this->getHeight(), $this->params[$mode][0], $this->params[$mode][1] )
				->saveAs( $this->getCacheFile( $mode ) );
		}else{
//			echo "aaa";
//			exit;
		}
		
		return $this->getCacheFile($mode);
	}
	
	public function getCacheDirectory( $mode ){
		return  dirname( $this->getPicturePath() ). "/cache_$mode" . '_' . $this->getWidth() . 'x' . $this->getHeight();
	}
	
	public function getCacheFile( $mode ){
		 return  $this->getCacheDirectory( $mode )  . '/' . basename( $this->getPicturePath() );
	}
	
	public function getBinaryData(){
		return file_get_contents( $this->getPicturePath() );
	}
	
	public function getPicturePath(){
		return $this->getFilesDirectory() . $this->type. '/' . $this->name . $this->ext;		
	}
	
	public function flushBinaryData(){
  		$this->imageTransformer->view( 'resize', $this->getPicturePath() , $this->getWidth() . 'x'. $this->getHeight(), true ); 
	}

	
	public function getWidth(){
		if( isset( $this->width ) && $this->width != 'original' && $this->height != 'original' )
			return $this->width;
		else if( $this->width == 'original' ){
			list($width, $height, $type, $attr) = getimagesize( $this->getPicturePath() );
			return $width;
		}
		else
			return 100;
	}
	
	public function getHeight(){
		if( isset( $this->height ) && $this->height != 'original' && $this->height != 'original' )
			return $this->height;
		else if( $this->height == 'original' ){
			list($width, $height, $type, $attr) = getimagesize( $this->getPicturePath() );
			return $height;
		}
			
		else
			return 100;
	}
	
  	public function getFilesDirectory(){
  		return  ( sfConfig::get('sf_upload_dir') ) . '/';
  	}
  	
  	public function setRedo( $redo ){
  		$this->redo = $redo;
  	}
  	
  	public function getRedo(){
  		return $this->redo;
  	}
  	
  	
  	static function getInstance( $id, $name = 'notfound', $type = 'standard', $width = 100, $height=100,  $redo = false ){
  		$data = array();
  		$data['name'] = self::fileWithouExtension( $name );
  		$data['ext'] = self::fileExt( $name );
  		$data['type'] = $type;
  		$data['width'] = $width;
  		$data['height'] = $height;
  		$data['id'] = $id;
  		$data['redo'] = $redo;
  		
		return new Picture($data);
  		
  	}
  	
  	
  	static function fileWithouExtension( $filename ){
		return preg_replace( '/\.(jpg|png|gif)$/i', '', $filename );
  	}
  	
  	
  	static function fileExt( $filename ){
  		return '.' . pathinfo($filename, PATHINFO_EXTENSION);
  	}
	
	
}