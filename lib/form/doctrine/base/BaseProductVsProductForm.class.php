<?php

/**
 * ProductVsProduct form base class.
 *
 * @method ProductVsProduct getObject() Returns the current form's model object
 *
 * @package    jobeet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseProductVsProductForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'product1' => new sfWidgetFormInputHidden(),
      'product2' => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'product1' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('product1')), 'empty_value' => $this->getObject()->get('product1'), 'required' => false)),
      'product2' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('product2')), 'empty_value' => $this->getObject()->get('product2'), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('product_vs_product[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'ProductVsProduct';
  }

}
