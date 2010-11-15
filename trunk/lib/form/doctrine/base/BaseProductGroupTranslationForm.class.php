<?php

/**
 * ProductGroupTranslation form base class.
 *
 * @method ProductGroupTranslation getObject() Returns the current form's model object
 *
 * @package    jobeet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseProductGroupTranslationForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'               => new sfWidgetFormInputHidden(),
      'slug'             => new sfWidgetFormInputText(),
      'description'      => new sfWidgetFormTextarea(),
      'meta_title'       => new sfWidgetFormTextarea(),
      'meta_description' => new sfWidgetFormTextarea(),
      'meta_keywords'    => new sfWidgetFormTextarea(),
      'name'             => new sfWidgetFormTextarea(),
      'lang'             => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'id'               => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'slug'             => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'description'      => new sfValidatorString(array('max_length' => 755, 'required' => false)),
      'meta_title'       => new sfValidatorString(array('max_length' => 1000, 'required' => false)),
      'meta_description' => new sfValidatorString(array('max_length' => 1000, 'required' => false)),
      'meta_keywords'    => new sfValidatorString(array('max_length' => 1000, 'required' => false)),
      'name'             => new sfValidatorString(array('max_length' => 300, 'required' => false)),
      'lang'             => new sfValidatorChoice(array('choices' => array($this->getObject()->get('lang')), 'empty_value' => $this->getObject()->get('lang'), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('product_group_translation[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'ProductGroupTranslation';
  }

}
