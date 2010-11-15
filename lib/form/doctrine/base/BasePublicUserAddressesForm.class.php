<?php

/**
 * PublicUserAddresses form base class.
 *
 * @method PublicUserAddresses getObject() Returns the current form's model object
 *
 * @package    jobeet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BasePublicUserAddressesForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'             => new sfWidgetFormInputHidden(),
      'public_user_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('PublicUser'), 'add_empty' => true)),
      'title'          => new sfWidgetFormInputText(),
      'name'           => new sfWidgetFormInputText(),
      'address'        => new sfWidgetFormInputText(),
      'city'           => new sfWidgetFormInputText(),
      'state'          => new sfWidgetFormInputText(),
      'country'        => new sfWidgetFormInputText(),
      'zip'            => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'             => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false)),
      'public_user_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('PublicUser'), 'required' => false)),
      'title'          => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'name'           => new sfValidatorString(array('max_length' => 255)),
      'address'        => new sfValidatorString(array('max_length' => 255)),
      'city'           => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'state'          => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'country'        => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'zip'            => new sfValidatorString(array('max_length' => 255, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('public_user_addresses[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'PublicUserAddresses';
  }

}
