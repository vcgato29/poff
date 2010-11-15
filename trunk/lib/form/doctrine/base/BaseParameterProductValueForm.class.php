<?php

/**
 * ParameterProductValue form base class.
 *
 * @method ParameterProductValue getObject() Returns the current form's model object
 *
 * @package    jobeet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseParameterProductValueForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'              => new sfWidgetFormInputHidden(),
      'param_id'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Parameter'), 'add_empty' => false)),
      'product_id'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Product'), 'add_empty' => false)),
      'common_value'    => new sfWidgetFormTextarea(),
      'common_filename' => new sfWidgetFormInputText(),
      'created_at'      => new sfWidgetFormDateTime(),
      'updated_at'      => new sfWidgetFormDateTime(),
      'created_by'      => new sfWidgetFormInputText(),
      'updated_by'      => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'              => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false)),
      'param_id'        => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Parameter'))),
      'product_id'      => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Product'))),
      'common_value'    => new sfValidatorString(array('max_length' => 9999, 'required' => false)),
      'common_filename' => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'created_at'      => new sfValidatorDateTime(),
      'updated_at'      => new sfValidatorDateTime(),
      'created_by'      => new sfValidatorInteger(array('required' => false)),
      'updated_by'      => new sfValidatorInteger(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('parameter_product_value[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'ParameterProductValue';
  }

}
