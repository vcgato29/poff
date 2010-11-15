<?php

/**
 * TransUnitVariableTranslation form base class.
 *
 * @method TransUnitVariableTranslation getObject() Returns the current form's model object
 *
 * @package    jobeet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseTransUnitVariableTranslationForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'msg_id' => new sfWidgetFormInputHidden(),
      'target' => new sfWidgetFormTextarea(),
      'lang'   => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'msg_id' => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'msg_id', 'required' => false)),
      'target' => new sfValidatorString(array('max_length' => 65532, 'required' => false)),
      'lang'   => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'lang', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('trans_unit_variable_translation[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'TransUnitVariableTranslation';
  }

}
