<?php

/**
 * TransUnitVariable filter form base class.
 *
 * @package    jobeet
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseTransUnitVariableFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'variable'  => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'multilang' => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
    ));

    $this->setValidators(array(
      'variable'  => new sfValidatorPass(array('required' => false)),
      'multilang' => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
    ));

    $this->widgetSchema->setNameFormat('trans_unit_variable_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'TransUnitVariable';
  }

  public function getFields()
  {
    return array(
      'id'        => 'Number',
      'variable'  => 'Text',
      'multilang' => 'Boolean',
    );
  }
}
