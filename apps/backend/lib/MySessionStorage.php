<?php
class MySessionStorage extends sfSessionStorage
{
  public function initialize( $parameters = null )
  {
  
    //Shitty work-around for swfuploader
	$context = sfContext::getInstance();
	$request =  sfContext::getInstance()->getRequest();
	
    if( $request->getParameter('action') ==  "swfupload")
    { 
      $sessionName = $parameters["session_name"];

      if($value = $context->getRequest()->getParameter($sessionName))
      {
        session_name($sessionName);
        session_id($value);
      } 
    }
    
    parent::initialize( $parameters);
  }
}
