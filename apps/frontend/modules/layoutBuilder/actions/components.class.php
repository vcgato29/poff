<?php
class layoutBuilderComponents extends myComponents{
	
	public function executeBuildLayout( sfWebRequest $request ){
		$this->modules = $this->getObject( $request )->getMyModules();
		$this->controller = $this->getContext()->getController()->getAction( $this->getRequestParameter('module'), $this->getRequestParameter('action') ); 
	}
	
}