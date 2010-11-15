<?php

/**
 * ShippingZoneInterval filter form base class.
 *
 * @package    jobeet
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseShippingZoneIntervalFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'my_zone_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('ShippingZone'), 'add_empty' => true)),
      'start'      => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'end'        => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'price'      => new sfWidgetFormFilterInput(array('with_empty' => false)),
    ));

    $this->setValidators(array(
      'my_zone_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('ShippingZone'), 'column' => 'id')),
      'start'      => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'end'        => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'price'      => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('shipping_zone_interval_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'ShippingZoneInterval';
  }

  public function getFields()
  {
    return array(
      'id'         => 'Number',
      'my_zone_id' => 'ForeignKey',
      'start'      => 'Number',
      'end'        => 'Number',
      'price'      => 'Number',
    );
  }
}
