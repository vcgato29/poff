<?php

/**
 * PlaceholdersVsModules filter form base class.
 *
 * @package    jobeet
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BasePlaceholdersVsModulesFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'placeholder'        => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'frontend_module_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('FrontendModule'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'placeholder'        => new sfValidatorPass(array('required' => false)),
      'frontend_module_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('FrontendModule'), 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('placeholders_vs_modules_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'PlaceholdersVsModules';
  }

  public function getFields()
  {
    return array(
      'id'                 => 'Number',
      'placeholder'        => 'Text',
      'frontend_module_id' => 'ForeignKey',
    );
  }
}
