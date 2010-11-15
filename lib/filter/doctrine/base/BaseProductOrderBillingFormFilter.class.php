<?php

/**
 * ProductOrderBilling filter form base class.
 *
 * @package    jobeet
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseProductOrderBillingFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'country'  => new sfWidgetFormFilterInput(),
      'city'     => new sfWidgetFormFilterInput(),
      'street'   => new sfWidgetFormFilterInput(),
      'zip'      => new sfWidgetFormFilterInput(),
      'receiver' => new sfWidgetFormFilterInput(),
      'email'    => new sfWidgetFormFilterInput(),
      'order_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('ProductOrder'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'country'  => new sfValidatorPass(array('required' => false)),
      'city'     => new sfValidatorPass(array('required' => false)),
      'street'   => new sfValidatorPass(array('required' => false)),
      'zip'      => new sfValidatorPass(array('required' => false)),
      'receiver' => new sfValidatorPass(array('required' => false)),
      'email'    => new sfValidatorPass(array('required' => false)),
      'order_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('ProductOrder'), 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('product_order_billing_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'ProductOrderBilling';
  }

  public function getFields()
  {
    return array(
      'id'       => 'Number',
      'country'  => 'Text',
      'city'     => 'Text',
      'street'   => 'Text',
      'zip'      => 'Text',
      'receiver' => 'Text',
      'email'    => 'Text',
      'order_id' => 'ForeignKey',
    );
  }
}
