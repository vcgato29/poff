<?php

/**
 * ProductOrderShipping filter form base class.
 *
 * @package    jobeet
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseProductOrderShippingFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'information'         => new sfWidgetFormFilterInput(),
      'name'                => new sfWidgetFormFilterInput(),
      'vatrate'             => new sfWidgetFormFilterInput(),
      'cost'                => new sfWidgetFormFilterInput(),
      'price_currency'      => new sfWidgetFormFilterInput(),
      'mass_interval_start' => new sfWidgetFormFilterInput(),
      'mass_interval_end'   => new sfWidgetFormFilterInput(),
      'order_id'            => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('ProductOrder'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'information'         => new sfValidatorPass(array('required' => false)),
      'name'                => new sfValidatorPass(array('required' => false)),
      'vatrate'             => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'cost'                => new sfValidatorPass(array('required' => false)),
      'price_currency'      => new sfValidatorPass(array('required' => false)),
      'mass_interval_start' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'mass_interval_end'   => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'order_id'            => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('ProductOrder'), 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('product_order_shipping_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'ProductOrderShipping';
  }

  public function getFields()
  {
    return array(
      'id'                  => 'Number',
      'information'         => 'Text',
      'name'                => 'Text',
      'vatrate'             => 'Number',
      'cost'                => 'Text',
      'price_currency'      => 'Text',
      'mass_interval_start' => 'Number',
      'mass_interval_end'   => 'Number',
      'order_id'            => 'ForeignKey',
    );
  }
}
