<?php

/**
 * ProductExemplar form.
 *
 * @package    jobeet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class ProductExemplarForm extends BaseProductExemplarForm
{
  public function configure()
  {

//	  $this->validatorSchema['scheduled_time'] = new sfValidatorCallback(array('required' => true,'callback'  => array('ProductExemplarForm', 'validateScheduledTime'),'arguments' => array('form' => $this)), array('invalid'   => 'Vale aeg', 'required' => 'vale aeg'));
	  $this->embedI18n( Doctrine::getTable('Language')->getAbbr() );
	  $this->widgetSchema['scheduled_time'] = new sfWidgetFormInputText();

//	  if(!$this->isNew()){
//
//		  $this->widgetSchema['scheduled_time']->setAttribute('value', date('Y-m-d H:i',$this->getObject()->getScheduledTime()) );
//	  }

  }

//  public function updateObject($values = null)
//  {
//    $object = parent::updateObject( $values );
//    if( ($tm = $this->getValue('scheduled_time') ))
//    	$object->setScheduledTime(strtotime($tm));
//    return $object;
//
//  }


//  static function validateScheduledTime($validator, $value, $arguments){
//	return strtotime($value);
//  }
}
