<?php

/**
 * BackendModule form base class.
 *
 * @method BackendModule getObject() Returns the current form's model object
 *
 * @package    jobeet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseBackendModuleForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                 => new sfWidgetFormInputHidden(),
      'module_name'        => new sfWidgetFormInputText(),
      'action'             => new sfWidgetFormInputText(),
      'title'              => new sfWidgetFormInputText(),
      'credential'         => new sfWidgetFormInputText(),
      'frontend_module_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('FrontendModule'), 'add_empty' => false)),
    ));

    $this->setValidators(array(
      'id'                 => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false)),
      'module_name'        => new sfValidatorString(array('max_length' => 50)),
      'action'             => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'title'              => new sfValidatorString(array('max_length' => 50)),
      'credential'         => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'frontend_module_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('FrontendModule'))),
    ));

    $this->widgetSchema->setNameFormat('backend_module[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'BackendModule';
  }

}
