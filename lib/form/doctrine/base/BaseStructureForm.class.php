<?php

/**
 * Structure form base class.
 *
 * @method Structure getObject() Returns the current form's model object
 *
 * @package    jobeet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseStructureForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'              => new sfWidgetFormInputHidden(),
      'title'           => new sfWidgetFormInputText(),
      'parameter'       => new sfWidgetFormInputText(),
      'picture'         => new sfWidgetFormInputText(),
      'content'         => new sfWidgetFormTextarea(),
      'inherits_layout' => new sfWidgetFormInputCheckbox(),
      'type'            => new sfWidgetFormInputText(),
      'description'     => new sfWidgetFormTextarea(),
      'pageTitle'       => new sfWidgetFormInputText(),
      'layout'          => new sfWidgetFormInputText(),
      'metaDescription' => new sfWidgetFormTextarea(),
      'metaKeywords'    => new sfWidgetFormTextarea(),
      'status'          => new sfWidgetFormInputText(),
      'is_first'        => new sfWidgetFormInputCheckbox(),
      'lang'            => new sfWidgetFormInputText(),
      'pri'             => new sfWidgetFormInputText(),
      'parentID'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Parent'), 'add_empty' => true)),
      'isHidden'        => new sfWidgetFormInputCheckbox(),
      'slug'            => new sfWidgetFormInputText(),
      'created_at'      => new sfWidgetFormDateTime(),
      'updated_at'      => new sfWidgetFormDateTime(),
      'lft'             => new sfWidgetFormInputText(),
      'rgt'             => new sfWidgetFormInputText(),
      'level'           => new sfWidgetFormInputText(),
      'created_by'      => new sfWidgetFormInputText(),
      'updated_by'      => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'              => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false)),
      'title'           => new sfValidatorString(array('max_length' => 255)),
      'parameter'       => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'picture'         => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'content'         => new sfValidatorString(array('max_length' => 9999999999999999999999999999999999999999, 'required' => false)),
      'inherits_layout' => new sfValidatorBoolean(array('required' => false)),
      'type'            => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'description'     => new sfValidatorString(array('max_length' => 700, 'required' => false)),
      'pageTitle'       => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'layout'          => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'metaDescription' => new sfValidatorString(array('max_length' => 500, 'required' => false)),
      'metaKeywords'    => new sfValidatorString(array('max_length' => 700, 'required' => false)),
      'status'          => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'is_first'        => new sfValidatorBoolean(array('required' => false)),
      'lang'            => new sfValidatorString(array('max_length' => 10)),
      'pri'             => new sfValidatorInteger(array('required' => false)),
      'parentID'        => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Parent'), 'required' => false)),
      'isHidden'        => new sfValidatorBoolean(array('required' => false)),
      'slug'            => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'created_at'      => new sfValidatorDateTime(),
      'updated_at'      => new sfValidatorDateTime(),
      'lft'             => new sfValidatorInteger(array('required' => false)),
      'rgt'             => new sfValidatorInteger(array('required' => false)),
      'level'           => new sfValidatorInteger(array('required' => false)),
      'created_by'      => new sfValidatorInteger(array('required' => false)),
      'updated_by'      => new sfValidatorInteger(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('structure[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Structure';
  }

}
