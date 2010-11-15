<?php
class myVideoComponents extends myComponents{

  static $usedMovies = array();	
	
  protected function getSimpleVideosQuery(){
  	$vTable = Doctrine::getTable('VideoProduct');
  	
  	$q = $vTable->findAllQuery()->limit( $this->getMaxVideos() );
  	
  	// pictures join
  	$this->setupPicturesJoin( $q );
  	
  	// categories join
  	$this->setupCategoriesJoin( $q );
  	
  	// translations join
  	$this->setupTranslationsJoin( $q );
  	
  	return $q;
  }
  
  
  protected static function getUsedVideosIds(){
  	return self::$usedMovies;
  }
  
  protected static function addUsedVideosIds( array $ar ){
  	self::$usedMovies = array_merge( self::$usedMovies, $ar );
  }
  
  protected function setupPicturesJoin( Doctrine_Query $q ){
  	Doctrine::getTable('VideoProduct')->addProductPicturesJoin( $q, 'default' );
  }
  
  protected function setupCategoriesJoin( Doctrine_Query $q ){
  	Doctrine::getTable('VideoProduct')->addProductCategoryJoin( $q );
  }
  
  protected function setupTranslationsJoin( Doctrine_Query $q ){
  	Doctrine::getTable('VideoProduct')->addProductTranslationJoin( $q, $this->getUser()->getCulture() );
  }
  
  
  protected function getMaxVideos(){
  	return 6;
  }
	
	
}