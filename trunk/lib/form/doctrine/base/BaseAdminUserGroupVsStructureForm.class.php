<?php

/**
 * AdminUserGroupVsStructure form base class.
 *
 * @method AdminUserGroupVsStructure getObject() Returns the current form's model object
 *
 * @package    jobeet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseAdminUserGroupVsStructureForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'name'                => new sfWidgetFormInputText(),
      'permission'          => new sfWidgetFormInputText(),
      'structure_id'        => new sfWidgetFormInputHidden(),
      'admin_user_group_id' => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'name'                => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'permission'          => new sfValidatorInteger(array('required' => false)),
      'structure_id'        => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'structure_id', 'required' => false)),
      'admin_user_group_id' => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'admin_user_group_id', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('admin_user_group_vs_structure[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'AdminUserGroupVsStructure';
  }

}
