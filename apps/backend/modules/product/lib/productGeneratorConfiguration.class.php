<?php

if(!class_exists('BaseProductGeneratorConfiguration'))
    require_once dirname(__FILE__).'/BaseProductGeneratorConfiguration.class.php';

/**
 * product module configuration.
 *
 * @package    jobeet
 * @subpackage product
 * @author     Your name here
 * @version    SVN: $Id: configuration.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class productGeneratorConfiguration extends BaseProductGeneratorConfiguration
{

  public function getFilterDisplay()
  {
    return array(  0 => 'code',  1 => 'name', 2 => 'price', 4 => 'product_group', );
  }

}
