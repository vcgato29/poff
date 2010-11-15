<?php

/**
 * ProductOrderSeb form.
 *
 * @package    jobeet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class ProductOrderSebForm extends BaseProductOrderSebForm
{
  /**
   * @see ProductOrderForm
   */
  public function configure()
  {
    parent::configure();
    
    $this->useFields(array('product_id', 'type'));
    
    $this->widgetSchema['product_id'] = new sfWidgetFormInputHidden();
    $this->widgetSchema['type'] = new sfWidgetFormInputHidden();
    
    $this->widgetSchema->setNameFormat('pay_form[%s]');
    
    
  }
  

}
