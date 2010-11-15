<?php

/**
 * orders module helper.
 *
 * @package    jobeet
 * @subpackage orders
 * @author     Your name here
 * @version    SVN: $Id: helper.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class ordersGeneratorHelper extends BaseOrdersGeneratorHelper
{
	public function linkToInvoice($object, $params){		
		 return '<li class="sf_admin_action_edit">'.link_to(__('Invoice', array(), 'messages'), 'orders/invoice?id='.$object->getId(), array()).'</li>';
	}
}
