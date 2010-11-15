<?php

/**
 * ProductOrderVisa filter form base class.
 *
 * @package    jobeet
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedInheritanceTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseProductOrderVisaFormFilter extends ProductOrderFormFilter
{
  protected function setupInheritance()
  {
    parent::setupInheritance();

    $this->widgetSchema->setNameFormat('product_order_visa_filters[%s]');
  }

  public function getModelName()
  {
    return 'ProductOrderVisa';
  }
}
