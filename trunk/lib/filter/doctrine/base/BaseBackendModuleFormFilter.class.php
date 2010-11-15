<?php

/**
 * BackendModule filter form base class.
 *
 * @package    jobeet
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseBackendModuleFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'module_name'        => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'action'             => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'title'              => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'credential'         => new sfWidgetFormFilterInput(),
      'frontend_module_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('FrontendModule'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'module_name'        => new sfValidatorPass(array('required' => false)),
      'action'             => new sfValidatorPass(array('required' => false)),
      'title'              => new sfValidatorPass(array('required' => false)),
      'credential'         => new sfValidatorPass(array('required' => false)),
      'frontend_module_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('FrontendModule'), 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('backend_module_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'BackendModule';
  }

  public function getFields()
  {
    return array(
      'id'                 => 'Number',
      'module_name'        => 'Text',
      'action'             => 'Text',
      'title'              => 'Text',
      'credential'         => 'Text',
      'frontend_module_id' => 'ForeignKey',
    );
  }
}
