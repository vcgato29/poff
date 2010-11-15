<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of productManagementHelper
 *
 * @author aneto
 */
class productManagementHelper extends productGeneratorHelper{
    public function getEditRoute(){
	return 'product_management_edit';
    }

    public function getEditRouteParams($product){
	return array('module' => 'productManagement','action' => 'edit', 'id' => $product['id']);
    }

    public function  getIndexRoute(){
	return 'product_management';
    }

    public function getNewRoute(){
	return 'product_management_new';
    }

    public function getModuleName(){
	return 'productManagement';
    }

  public function getUrlForAction($action)
  {
	return 'list' == $action ? 'product_management' : 'product_management_'.$action;
  }
}
?>
