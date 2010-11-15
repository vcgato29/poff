<?php

/**
 * ProductGroup form base class.
 *
 * @method ProductGroup getObject() Returns the current form's model object
 *
 * @package    jobeet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseProductGroupForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'               => new sfWidgetFormInputHidden(),
      'title'            => new sfWidgetFormInputText(),
      'picture'          => new sfWidgetFormInputText(),
      'picture_inactive' => new sfWidgetFormInputText(),
      'import_code'      => new sfWidgetFormInputText(),
      'pri'              => new sfWidgetFormInputText(),
      'parameter'        => new sfWidgetFormInputText(),
      'lft'              => new sfWidgetFormInputText(),
      'rgt'              => new sfWidgetFormInputText(),
      'level'            => new sfWidgetFormInputText(),
      'created_at'       => new sfWidgetFormDateTime(),
      'updated_at'       => new sfWidgetFormDateTime(),
      'created_by'       => new sfWidgetFormInputText(),
      'updated_by'       => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'               => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'title'            => new sfValidatorString(array('max_length' => 255)),
      'picture'          => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'picture_inactive' => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'import_code'      => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'pri'              => new sfValidatorInteger(array('required' => false)),
      'parameter'        => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'lft'              => new sfValidatorInteger(array('required' => false)),
      'rgt'              => new sfValidatorInteger(array('required' => false)),
      'level'            => new sfValidatorInteger(array('required' => false)),
      'created_at'       => new sfValidatorDateTime(),
      'updated_at'       => new sfValidatorDateTime(),
      'created_by'       => new sfValidatorInteger(array('required' => false)),
      'updated_by'       => new sfValidatorInteger(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('product_group[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'ProductGroup';
  }

}
