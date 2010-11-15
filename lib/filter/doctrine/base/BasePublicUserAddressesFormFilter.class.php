<?php

/**
 * PublicUserAddresses filter form base class.
 *
 * @package    jobeet
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BasePublicUserAddressesFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'public_user_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('PublicUser'), 'add_empty' => true)),
      'title'          => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'name'           => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'address'        => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'city'           => new sfWidgetFormFilterInput(),
      'state'          => new sfWidgetFormFilterInput(),
      'country'        => new sfWidgetFormFilterInput(),
      'zip'            => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'public_user_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('PublicUser'), 'column' => 'id')),
      'title'          => new sfValidatorPass(array('required' => false)),
      'name'           => new sfValidatorPass(array('required' => false)),
      'address'        => new sfValidatorPass(array('required' => false)),
      'city'           => new sfValidatorPass(array('required' => false)),
      'state'          => new sfValidatorPass(array('required' => false)),
      'country'        => new sfValidatorPass(array('required' => false)),
      'zip'            => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('public_user_addresses_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'PublicUserAddresses';
  }

  public function getFields()
  {
    return array(
      'id'             => 'Number',
      'public_user_id' => 'ForeignKey',
      'title'          => 'Text',
      'name'           => 'Text',
      'address'        => 'Text',
      'city'           => 'Text',
      'state'          => 'Text',
      'country'        => 'Text',
      'zip'            => 'Text',
    );
  }
}
