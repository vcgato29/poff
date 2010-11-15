<?php

/**
 * orders module configuration.
 *
 * @package    jobeet
 * @subpackage orders
 * @author     Your name here
 * @version    SVN: $Id: configuration.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class ordersGeneratorConfiguration extends BaseOrdersGeneratorConfiguration
{
	
	public function getFilterDefaults(){
		return array('is_archived' => 0);
	}
}
