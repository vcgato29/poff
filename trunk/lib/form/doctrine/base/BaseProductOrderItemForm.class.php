<?php

/**
 * ProductOrderItem form base class.
 *
 * @method ProductOrderItem getObject() Returns the current form's model object
 *
 * @package    jobeet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseProductOrderItemForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                => new sfWidgetFormInputHidden(),
      'order_id'          => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('ProductOrder'), 'add_empty' => false)),
      'price_currency'    => new sfWidgetFormInputText(),
      'product_id'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Product'), 'add_empty' => true)),
      'mass'              => new sfWidgetFormInputText(),
      'vatrate'           => new sfWidgetFormInputText(),
      'code'              => new sfWidgetFormInputText(),
      'order_shipping_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('ProductOrderShipping'), 'add_empty' => false)),
      'name'              => new sfWidgetFormInputText(),
      'quanity'           => new sfWidgetFormInputText(),
      'price'             => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'                => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'order_id'          => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('ProductOrder'))),
      'price_currency'    => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'product_id'        => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Product'), 'required' => false)),
      'mass'              => new sfValidatorInteger(array('required' => false)),
      'vatrate'           => new sfValidatorInteger(array('required' => false)),
      'code'              => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'order_shipping_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('ProductOrderShipping'))),
      'name'              => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'quanity'           => new sfValidatorInteger(array('required' => false)),
      'price'             => new sfValidatorNumber(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('product_order_item[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'ProductOrderItem';
  }

}
