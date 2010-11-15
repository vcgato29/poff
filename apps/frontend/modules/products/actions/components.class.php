<?php
class productsComponents extends myComponents
{
		
 public function executeRender(){
 	
 }
	
  public function executeBreadcrumbs(){

	$this->category = $this->getRoute()->getCategoryObject();
  	$this->video = $this->getRoute()->getVideoObject();
  	   
  }
}