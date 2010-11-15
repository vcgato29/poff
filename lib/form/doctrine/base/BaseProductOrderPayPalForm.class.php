<?php

/**
 * ProductOrderPayPal form base class.
 *
 * @method ProductOrderPayPal getObject() Returns the current form's model object
 *
 * @package    jobeet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedInheritanceTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseProductOrderPayPalForm extends ProductOrderForm
{
  protected function setupInheritance()
  {
    parent::setupInheritance();

    $this->widgetSchema->setNameFormat('product_order_pay_pal[%s]');
  }

  public function getModelName()
  {
    return 'ProductOrderPayPal';
  }

}
