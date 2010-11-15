<?php

class ArticleLeftMenuHelper{
	
	public function hiddenNode( $node ){
		$context = sfContext::getInstance();
		$sf_user = $context->getUser();
		
		// if signed in -> do not show "register"
		// if not signed in -> show only "register"
		return ( $node['isHidden'] || $node['parameter'] == 'register' && $sf_user->isAuthenticated() )  || (!$sf_user->isAuthenticated() &&  ( $node['parameter'] == 'my settings'  || $node['parameter'] == 'orders') );
		
	}

        public function isActive($node, $activeNodes){
            return in_array($node['id'], $activeNodes);
        }
	
}