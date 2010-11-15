<?php

class UsersManager{
	
	static function basketActionsListener(sfEvent $event){
		if( $event->getSubject()->getRequest()->hasParameter('basket') ){
			$event->getSubject()->redirect( $event->getSubject()->getComponent('linker', 'basket', array('action' => 'checkout')) );
		}
	}
	

	static function registerActionListener(sfEvent $event){
		if( $event->getSubject()->getRequest()->hasParameter('basket') ){
			$event->getSubject()->redirect( $event->getSubject()->getComponent('linker', 'basket', array('action' => 'checkout')) );
		}		
	}
	
	/*
	 * Change user currency after he is signed in to his DEFAULT currency
	 */
	static function currencyChangeListener(sfEvent $event){
		$user = $event->getSubject()->getUser();
		
		if($user->getObject() && $user->getObject()->getCurrency()){
			$cur = Doctrine::getTable('Currency')->findOneByAbbr($user->getObject()->getCurrency());
			if($cur instanceof Currency)
				$user->setCurrency($cur);
		}
	}
	
	
	/*
	 * If user signes in and has "user.signed_in.continue_url" attribute then redirect him to "user.signed_in.continue_url"
	 */
	static function userSignedInListener(sfEvent $event){
		$user = $event->getSubject()->getUser();

		if($user->hasAttribute('user.signed_in.continue_url') && $user->getAttribute('user.signed_in.continue_url')){
			$url = $user->getAttribute('user.signed_in.continue_url');
			$user->setAttribute('user.signed_in.continue_url', false);
			$event->getSubject()->redirect($url);
		}
	}
	
	
}