<?php

/**
 * ProductOrderBilling form base class.
 *
 * @method ProductOrderBilling getObject() Returns the current form's model object
 *
 * @package    jobeet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseProductOrderBillingForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'       => new sfWidgetFormInputHidden(),
      'country'  => new sfWidgetFormInputText(),
      'city'     => new sfWidgetFormInputText(),
      'street'   => new sfWidgetFormInputText(),
      'zip'      => new sfWidgetFormInputText(),
      'receiver' => new sfWidgetFormInputText(),
      'email'    => new sfWidgetFormInputText(),
      'order_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('ProductOrder'), 'add_empty' => false)),
    ));

    $this->setValidators(array(
      'id'       => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'country'  => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'city'     => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'street'   => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'zip'      => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'receiver' => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'email'    => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'order_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('ProductOrder'))),
    ));

    $this->widgetSchema->setNameFormat('product_order_billing[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'ProductOrderBilling';
  }

}
