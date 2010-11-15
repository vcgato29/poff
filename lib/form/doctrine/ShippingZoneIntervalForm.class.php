<?php

/**
 * ShippingZoneInterval form.
 *
 * @package    jobeet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class ShippingZoneIntervalForm extends BaseShippingZoneIntervalForm
{
  public function configure()
  {
  	$this->widgetSchema['my_zone_id'] = new sfWidgetFormInputHidden();
  	
  }
}
