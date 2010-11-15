<?php

class frontendConfiguration extends sfApplicationConfiguration
{
  public function configure()
  {
  	
  	$this->dispatcher->connect('user.signed_in', array('UsersManager', 'currencyChangeListener'));
  	$this->dispatcher->connect('user.signed_in', array('UsersManager', 'basketActionsListener'));
  	$this->dispatcher->connect('user.signed_in', array('UsersManager', 'userSignedInListener'));
  	
  	$this->dispatcher->connect('user.registered', array('UsersManager', 'currencyChangeListener'));
  	$this->dispatcher->connect('user.registered', array('UsersManager', 'registerActionListener'));
  	
  	$this->dispatcher->connect('user.settings_updated', array('UsersManager', 'currencyChangeListener'));
  	
  	
  }
  
  
}
