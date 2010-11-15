<?php

/**
 * TransUnitVariableTranslation filter form base class.
 *
 * @package    jobeet
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseTransUnitVariableTranslationFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'target' => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'target' => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('trans_unit_variable_translation_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'TransUnitVariableTranslation';
  }

  public function getFields()
  {
    return array(
      'msg_id' => 'Number',
      'target' => 'Text',
      'lang'   => 'Text',
    );
  }
}
