<?php

/**
 * StructureIndex form base class.
 *
 * @method StructureIndex getObject() Returns the current form's model object
 *
 * @package    jobeet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseStructureIndexForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'keyword'  => new sfWidgetFormInputHidden(),
      'field'    => new sfWidgetFormInputHidden(),
      'position' => new sfWidgetFormInputHidden(),
      'id'       => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'keyword'  => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'keyword', 'required' => false)),
      'field'    => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'field', 'required' => false)),
      'position' => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'position', 'required' => false)),
      'id'       => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('structure_index[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'StructureIndex';
  }

}
