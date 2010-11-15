<?php

class mySearchRouter  extends myProductRouter{
	
	protected $video = false;	

	public function getVideoObject(){
		if( !$this->video ){
			$params = $this->getParameters();
			if( isset( $params['video_slug'] ) )
				$this->video = Doctrine::getTable('VideoProduct')->findOneById( $params['video_slug'] );
		}
		
		return $this->video;
	}
	

	
	protected function getObjectsForParameters($parameters){
		return new Doctrine_Collection('Structure','id');
	}
	
}
