<?php

/**
 * Banner form base class.
 *
 * @method Banner getObject() Returns the current form's model object
 *
 * @package    jobeet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseBannerForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'              => new sfWidgetFormInputHidden(),
      'name'            => new sfWidgetFormInputText(),
      'pri'             => new sfWidgetFormInputText(),
      'type'            => new sfWidgetFormInputText(),
      'link'            => new sfWidgetFormTextarea(),
      'content'         => new sfWidgetFormTextarea(),
      'flash_vars'      => new sfWidgetFormTextarea(),
      'is_active'       => new sfWidgetFormInputCheckbox(),
      'displayed'       => new sfWidgetFormInputText(),
      'clicked'         => new sfWidgetFormInputText(),
      'file'            => new sfWidgetFormInputText(),
      'width'           => new sfWidgetFormInputText(),
      'height'          => new sfWidgetFormInputText(),
      'banner_group_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('BannerGroup'), 'add_empty' => false)),
    ));

    $this->setValidators(array(
      'id'              => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false)),
      'name'            => new sfValidatorString(array('max_length' => 255)),
      'pri'             => new sfValidatorInteger(array('required' => false)),
      'type'            => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'link'            => new sfValidatorString(array('max_length' => 400, 'required' => false)),
      'content'         => new sfValidatorString(array('max_length' => 5000, 'required' => false)),
      'flash_vars'      => new sfValidatorString(array('max_length' => 400, 'required' => false)),
      'is_active'       => new sfValidatorBoolean(array('required' => false)),
      'displayed'       => new sfValidatorInteger(array('required' => false)),
      'clicked'         => new sfValidatorInteger(array('required' => false)),
      'file'            => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'width'           => new sfValidatorInteger(array('required' => false)),
      'height'          => new sfValidatorInteger(array('required' => false)),
      'banner_group_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('BannerGroup'))),
    ));

    $this->widgetSchema->setNameFormat('banner[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Banner';
  }

}
