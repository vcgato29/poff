<?php

/**
 * PublicUser form.
 *
 * @package    jobeet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class PublicUserForm extends BasePublicUserForm
{
  public function configure(){

  	$this->widgetSchema['password'] = new sfWidgetFormInputPassword();
  	$this->validatorSchema['password'] = new sfValidatorString(array('max_length' => 128, 'required' => false));
  }
  
  	public function bind(array $taintedValues = null, array $taintedFiles = null) {
  		if( (isset( $taintedValues['password'] )) && !$taintedValues['password'] ){
  			unset($this['password']);
  			unset($taintedValues['password']);
  		}
  		
  		return parent::bind($taintedValues, $taintedFiles);
  		
  		
  	}
}
