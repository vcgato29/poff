<?php

/**
 * PlaceholdersVsModules form base class.
 *
 * @method PlaceholdersVsModules getObject() Returns the current form's model object
 *
 * @package    jobeet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BasePlaceholdersVsModulesForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                 => new sfWidgetFormInputHidden(),
      'placeholder'        => new sfWidgetFormInputText(),
      'frontend_module_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('FrontendModule'), 'add_empty' => false)),
    ));

    $this->setValidators(array(
      'id'                 => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false)),
      'placeholder'        => new sfValidatorString(array('max_length' => 255)),
      'frontend_module_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('FrontendModule'))),
    ));

    $this->widgetSchema->setNameFormat('placeholders_vs_modules[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'PlaceholdersVsModules';
  }

}
