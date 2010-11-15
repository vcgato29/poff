<?php

/**
 * ShippingZone form.
 *
 * @package    jobeet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class ShippingZoneForm extends BaseShippingZoneForm
{
	
  static $multiLangFields = array('name' => array('title' => 'Nimi'));
   
  public function configure(){
  	
  	$this->setI18Languages();
  	
  }

//  public function setupMultilanguageFields(){
//  	
//  	$this->setI18Languages();
//  	
//  	foreach( $this->getLanguages() as $lang )
//  		foreach( self::$multiLangFields as $input => $info )
//  			$this->widgetSchema[$lang][$input] = new sfWidgetFormInputText(  array(), array('size' => 25, 'class' => 'formInput') );
//  		
//  }
  
  public function setI18Languages(){
  	$this->embedI18n($this->getLanguages());
  }
  
  public function getLanguages(){
  	return array('et','fr','en');
  }
  
}
