<?php

/**
 * Placeholder form base class.
 *
 * @method Placeholder getObject() Returns the current form's model object
 *
 * @package    jobeet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BasePlaceholderForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                 => new sfWidgetFormInputHidden(),
      'frontend_module_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('FrontendModule'), 'add_empty' => false)),
      'structure_id'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Structure'), 'add_empty' => false)),
      'action'             => new sfWidgetFormInputText(),
      'name'               => new sfWidgetFormInputText(),
      'pri'                => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'                 => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false)),
      'frontend_module_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('FrontendModule'))),
      'structure_id'       => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Structure'))),
      'action'             => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'name'               => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'pri'                => new sfValidatorInteger(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('placeholder[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Placeholder';
  }

}
