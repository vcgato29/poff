<?php

/**
 * ParameterGroup form.
 *
 * @package    jobeet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class ParameterGroupForm extends BaseParameterGroupForm
{
	 public static $multiLangFields = array( 'name' => array( 'title'=> 'Nimi' ) );
	 
  public function configure()
  {

  	$this->useFields( array( 'id', 'title' ) );
  	
    $languages = array();
  	foreach( Doctrine::getTable('Language')->findAll() as $lang ){
  		$languages[] = $lang->getAbr();
  	}
  	
  	$this->embedI18n( $languages );
  	
  	foreach( $languages as $lang )
  		foreach( self::$multiLangFields as $input => $info )
  		$this->widgetSchema[$lang][$input] = new sfWidgetFormInputText(  array(), array('size' => 25, 'class' => 'formInput') );
  }
}
