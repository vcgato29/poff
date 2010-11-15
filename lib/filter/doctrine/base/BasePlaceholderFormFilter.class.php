<?php

/**
 * Placeholder filter form base class.
 *
 * @package    jobeet
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BasePlaceholderFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'frontend_module_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('FrontendModule'), 'add_empty' => true)),
      'structure_id'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Structure'), 'add_empty' => true)),
      'action'             => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'name'               => new sfWidgetFormFilterInput(),
      'pri'                => new sfWidgetFormFilterInput(array('with_empty' => false)),
    ));

    $this->setValidators(array(
      'frontend_module_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('FrontendModule'), 'column' => 'id')),
      'structure_id'       => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Structure'), 'column' => 'id')),
      'action'             => new sfValidatorPass(array('required' => false)),
      'name'               => new sfValidatorPass(array('required' => false)),
      'pri'                => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('placeholder_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Placeholder';
  }

  public function getFields()
  {
    return array(
      'id'                 => 'Number',
      'frontend_module_id' => 'ForeignKey',
      'structure_id'       => 'ForeignKey',
      'action'             => 'Text',
      'name'               => 'Text',
      'pri'                => 'Number',
    );
  }
}
