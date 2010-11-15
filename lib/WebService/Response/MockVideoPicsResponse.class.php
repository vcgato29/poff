<?php
class MockVideoPicsResponse extends SimpleWebResponse{
	
	public function __construct(){
		parent::__construct(200, file_get_contents( dirname(__FILE__) . '/video_pics.txt' ));	
	}
	
	
	public function send(){
		
		
		
	}
	
}