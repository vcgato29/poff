<?php

/**
 * ParameterProductValueTranslation filter form base class.
 *
 * @package    jobeet
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseParameterProductValueTranslationFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'value'    => new sfWidgetFormFilterInput(),
      'filename' => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'value'    => new sfValidatorPass(array('required' => false)),
      'filename' => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('parameter_product_value_translation_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'ParameterProductValueTranslation';
  }

  public function getFields()
  {
    return array(
      'id'       => 'Number',
      'value'    => 'Text',
      'filename' => 'Text',
      'lang'     => 'Text',
    );
  }
}
