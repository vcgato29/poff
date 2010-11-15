<?php

/**
 * ShippingZoneInterval form base class.
 *
 * @method ShippingZoneInterval getObject() Returns the current form's model object
 *
 * @package    jobeet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseShippingZoneIntervalForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'         => new sfWidgetFormInputHidden(),
      'my_zone_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('ShippingZone'), 'add_empty' => false)),
      'start'      => new sfWidgetFormInputText(),
      'end'        => new sfWidgetFormInputText(),
      'price'      => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'         => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false)),
      'my_zone_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('ShippingZone'))),
      'start'      => new sfValidatorInteger(),
      'end'        => new sfValidatorInteger(),
      'price'      => new sfValidatorNumber(),
    ));

    $this->widgetSchema->setNameFormat('shipping_zone_interval[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'ShippingZoneInterval';
  }

}
