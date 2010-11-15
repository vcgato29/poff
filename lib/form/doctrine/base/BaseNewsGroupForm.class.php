<?php

/**
 * NewsGroup form base class.
 *
 * @method NewsGroup getObject() Returns the current form's model object
 *
 * @package    jobeet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseNewsGroupForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'             => new sfWidgetFormInputHidden(),
      'name'           => new sfWidgetFormInputText(),
      'type'           => new sfWidgetFormInputText(),
      'pri'            => new sfWidgetFormInputText(),
      'is_active'      => new sfWidgetFormInputCheckbox(),
      'link_to_struct' => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'             => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false)),
      'name'           => new sfValidatorString(array('max_length' => 255)),
      'type'           => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'pri'            => new sfValidatorInteger(array('required' => false)),
      'is_active'      => new sfValidatorBoolean(array('required' => false)),
      'link_to_struct' => new sfValidatorInteger(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('news_group[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'NewsGroup';
  }

}
