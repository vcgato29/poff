<?php

/**
 * ParameterProductOption form base class.
 *
 * @method ParameterProductOption getObject() Returns the current form's model object
 *
 * @package    jobeet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseParameterProductOptionForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'option_id'  => new sfWidgetFormInputHidden(),
      'product_id' => new sfWidgetFormInputHidden(),
      'priceadd'   => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'option_id'  => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'option_id', 'required' => false)),
      'product_id' => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'product_id', 'required' => false)),
      'priceadd'   => new sfValidatorNumber(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('parameter_product_option[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'ParameterProductOption';
  }

}
