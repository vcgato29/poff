<?php

if(!class_exists('BaseProductGeneratorHelper'))
    require_once dirname(__FILE__).'/BaseProductGeneratorHelper.class.php';
/**
 * product module helper.
 *
 * @package    jobeet
 * @subpackage product
 * @author     Your name here
 * @version    SVN: $Id: helper.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class productGeneratorHelper extends BaseProductGeneratorHelper
{

    public function getEditRoute(){
	return 'product_edit';
    }

    public function getEditRouteParams($product){
	return array('id' => $product['id']);
    }

    public function  getIndexRoute(){
	return 'product';
    }

    public function getNewRoute(){
	return 'product_new';
    }

    public function getModuleName(){
	return 'product';
    }
}
