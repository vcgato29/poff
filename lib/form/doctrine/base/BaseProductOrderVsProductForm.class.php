<?php

/**
 * ProductOrderVsProduct form base class.
 *
 * @method ProductOrderVsProduct getObject() Returns the current form's model object
 *
 * @package    jobeet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseProductOrderVsProductForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'product_id' => new sfWidgetFormInputHidden(),
      'order_id'   => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'product_id' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('product_id')), 'empty_value' => $this->getObject()->get('product_id'), 'required' => false)),
      'order_id'   => new sfValidatorChoice(array('choices' => array($this->getObject()->get('order_id')), 'empty_value' => $this->getObject()->get('order_id'), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('product_order_vs_product[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'ProductOrderVsProduct';
  }

}
