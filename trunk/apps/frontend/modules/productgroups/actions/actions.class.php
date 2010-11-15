<?php
require_once( dirname( dirname( dirname(__FILE__) ) ) . '/init/actions/actions.class.php' );

class productgroupsActions extends initActions
{
    public $myName = 'productgroups';
	public $z = 0;
  public function executeIndex(sfWebRequest $request){
  		
  		$this->forward('productgroups','specMethod');
  }
  
  public function executeSpecMethod($request){
  	
  	$this->buildLayoutModulesContent();  	
  	$paramRequest = $this->getRequestParameter( 'addparams_'.$this->myName );
  	
  }
  
  public function executeProdGroupNew($request){
  
  }
  
  public function getCurrentComponents(){
  	return array( 'header' => array( 'job/headlines', 'init/hello' ) );
  }
}