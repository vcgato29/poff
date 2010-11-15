<?php

/**
 * NewsGroupVsStructure form base class.
 *
 * @method NewsGroupVsStructure getObject() Returns the current form's model object
 *
 * @package    jobeet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseNewsGroupVsStructureForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'group_id'     => new sfWidgetFormInputHidden(),
      'structure_id' => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'group_id'     => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'group_id', 'required' => false)),
      'structure_id' => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'structure_id', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('news_group_vs_structure[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'NewsGroupVsStructure';
  }

}