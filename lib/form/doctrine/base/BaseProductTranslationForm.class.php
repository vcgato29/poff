<?php

/**
 * ProductTranslation form base class.
 *
 * @method ProductTranslation getObject() Returns the current form's model object
 *
 * @package    jobeet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseProductTranslationForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                   => new sfWidgetFormInputHidden(),
      'slug'                 => new sfWidgetFormInputText(),
      'country'              => new sfWidgetFormInputText(),
      'synopsis'             => new sfWidgetFormTextarea(),
      'producer_description' => new sfWidgetFormTextarea(),
      'critics'              => new sfWidgetFormTextarea(),
      'language'             => new sfWidgetFormTextarea(),
      'name'                 => new sfWidgetFormTextarea(),
      'description'          => new sfWidgetFormTextarea(),
      'lang'                 => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'id'                   => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'slug'                 => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'country'              => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'synopsis'             => new sfValidatorString(array('required' => false)),
      'producer_description' => new sfValidatorString(array('max_length' => 700, 'required' => false)),
      'critics'              => new sfValidatorString(array('max_length' => 700, 'required' => false)),
      'language'             => new sfValidatorString(array('max_length' => 700, 'required' => false)),
      'name'                 => new sfValidatorString(array('max_length' => 1000, 'required' => false)),
      'description'          => new sfValidatorString(array('max_length' => 6000, 'required' => false)),
      'lang'                 => new sfValidatorChoice(array('choices' => array($this->getObject()->get('lang')), 'empty_value' => $this->getObject()->get('lang'), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('product_translation[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'ProductTranslation';
  }

}
