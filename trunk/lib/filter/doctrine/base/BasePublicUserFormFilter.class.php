<?php

/**
 * PublicUser filter form base class.
 *
 * @package    jobeet
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BasePublicUserFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'name'     => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'email'    => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'currency' => new sfWidgetFormFilterInput(),
      'login'    => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'password' => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'address1' => new sfWidgetFormFilterInput(),
      'address2' => new sfWidgetFormFilterInput(),
      'city'     => new sfWidgetFormFilterInput(),
      'state'    => new sfWidgetFormFilterInput(),
      'country'  => new sfWidgetFormFilterInput(),
      'zip'      => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'name'     => new sfValidatorPass(array('required' => false)),
      'email'    => new sfValidatorPass(array('required' => false)),
      'currency' => new sfValidatorPass(array('required' => false)),
      'login'    => new sfValidatorPass(array('required' => false)),
      'password' => new sfValidatorPass(array('required' => false)),
      'address1' => new sfValidatorPass(array('required' => false)),
      'address2' => new sfValidatorPass(array('required' => false)),
      'city'     => new sfValidatorPass(array('required' => false)),
      'state'    => new sfValidatorPass(array('required' => false)),
      'country'  => new sfValidatorPass(array('required' => false)),
      'zip'      => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('public_user_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'PublicUser';
  }

  public function getFields()
  {
    return array(
      'id'       => 'Number',
      'name'     => 'Text',
      'email'    => 'Text',
      'currency' => 'Text',
      'login'    => 'Text',
      'password' => 'Text',
      'address1' => 'Text',
      'address2' => 'Text',
      'city'     => 'Text',
      'state'    => 'Text',
      'country'  => 'Text',
      'zip'      => 'Text',
    );
  }
}
