<?php

/**
 * ProductOrderMasterCard form base class.
 *
 * @method ProductOrderMasterCard getObject() Returns the current form's model object
 *
 * @package    jobeet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedInheritanceTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseProductOrderMasterCardForm extends ProductOrderForm
{
  protected function setupInheritance()
  {
    parent::setupInheritance();

    $this->widgetSchema->setNameFormat('product_order_master_card[%s]');
  }

  public function getModelName()
  {
    return 'ProductOrderMasterCard';
  }

}
