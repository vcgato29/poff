<?php

/**
 * PublicUser form base class.
 *
 * @method PublicUser getObject() Returns the current form's model object
 *
 * @package    jobeet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BasePublicUserForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'       => new sfWidgetFormInputHidden(),
      'name'     => new sfWidgetFormInputText(),
      'email'    => new sfWidgetFormInputText(),
      'currency' => new sfWidgetFormInputText(),
      'login'    => new sfWidgetFormInputText(),
      'password' => new sfWidgetFormInputText(),
      'address1' => new sfWidgetFormInputText(),
      'address2' => new sfWidgetFormInputText(),
      'city'     => new sfWidgetFormInputText(),
      'state'    => new sfWidgetFormInputText(),
      'country'  => new sfWidgetFormInputText(),
      'zip'      => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'       => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false)),
      'name'     => new sfValidatorString(array('max_length' => 255)),
      'email'    => new sfValidatorString(array('max_length' => 255)),
      'currency' => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'login'    => new sfValidatorString(array('max_length' => 255)),
      'password' => new sfValidatorString(array('max_length' => 255)),
      'address1' => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'address2' => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'city'     => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'state'    => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'country'  => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'zip'      => new sfValidatorString(array('max_length' => 255, 'required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorDoctrineUnique(array('model' => 'PublicUser', 'column' => array('login')))
    );

    $this->widgetSchema->setNameFormat('public_user[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'PublicUser';
  }

}
