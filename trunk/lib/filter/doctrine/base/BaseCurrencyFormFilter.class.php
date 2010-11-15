<?php

/**
 * Currency filter form base class.
 *
 * @package    jobeet
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseCurrencyFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'name'        => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'factor'      => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'symbol'      => new sfWidgetFormFilterInput(),
      'abbr'        => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'prefix'      => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'language_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Language'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'name'        => new sfValidatorPass(array('required' => false)),
      'factor'      => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'symbol'      => new sfValidatorPass(array('required' => false)),
      'abbr'        => new sfValidatorPass(array('required' => false)),
      'prefix'      => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'language_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Language'), 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('currency_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Currency';
  }

  public function getFields()
  {
    return array(
      'id'          => 'Number',
      'name'        => 'Text',
      'factor'      => 'Number',
      'symbol'      => 'Text',
      'abbr'        => 'Text',
      'prefix'      => 'Boolean',
      'language_id' => 'ForeignKey',
    );
  }
}
