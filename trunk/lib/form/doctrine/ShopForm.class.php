<?php

/**
 * Shop form.
 *
 * @package    jobeet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class ShopForm extends BaseShopForm
{
  public function configure(){
  	
  	parent::configure();
  	
  	$this->setI18Languages();
  	
  	
  	
  }
  
  public function setI18Languages(){
  	$this->embedI18n($this->getLanguages());
  	
  	foreach( $this->getLanguages() as $lang ){
  		$this->widgetSchema[$lang]['address'] = new sfWidgetFormTextarea();
  	}
  	
  }

  public function getLanguages(){
  	return array('et','fr','en');
  }
}
