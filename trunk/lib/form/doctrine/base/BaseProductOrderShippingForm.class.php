<?php

/**
 * ProductOrderShipping form base class.
 *
 * @method ProductOrderShipping getObject() Returns the current form's model object
 *
 * @package    jobeet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseProductOrderShippingForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                  => new sfWidgetFormInputHidden(),
      'information'         => new sfWidgetFormTextarea(),
      'name'                => new sfWidgetFormInputText(),
      'vatrate'             => new sfWidgetFormInputText(),
      'cost'                => new sfWidgetFormInputText(),
      'price_currency'      => new sfWidgetFormInputText(),
      'mass_interval_start' => new sfWidgetFormInputText(),
      'mass_interval_end'   => new sfWidgetFormInputText(),
      'order_id'            => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('ProductOrder'), 'add_empty' => false)),
    ));

    $this->setValidators(array(
      'id'                  => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'information'         => new sfValidatorString(array('max_length' => 3000, 'required' => false)),
      'name'                => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'vatrate'             => new sfValidatorInteger(array('required' => false)),
      'cost'                => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'price_currency'      => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'mass_interval_start' => new sfValidatorInteger(array('required' => false)),
      'mass_interval_end'   => new sfValidatorInteger(array('required' => false)),
      'order_id'            => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('ProductOrder'))),
    ));

    $this->widgetSchema->setNameFormat('product_order_shipping[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'ProductOrderShipping';
  }

}
