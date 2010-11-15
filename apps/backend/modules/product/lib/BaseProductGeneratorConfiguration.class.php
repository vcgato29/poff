<?php

/**
 * product module configuration.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage product
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: configuration.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseProductGeneratorConfiguration extends sfModelGeneratorConfiguration
{
  public function getActionsDefault()
  {
    return array();
  }

  public function getFormActions()
  {
    return array(  '_delete' => NULL,  '_list' => NULL,  '_save' => NULL,  '_save_and_add' => NULL,);
  }

  public function getNewActions()
  {
    return array();
  }

  public function getEditActions()
  {
    return array();
  }

  public function getListObjectActions()
  {
    return array(  '_edit' => NULL,  '_delete' => NULL,);
  }

  public function getListActions()
  {
    return array(  '_new' => NULL,);
  }

  public function getListBatchActions()
  {
    return array(  '_delete' => NULL,  'priority' => NULL,);
  }

  public function getListParams()
  {
    return '%%code%% - %%name%% - %%pri_form%% - %%price%% - %%productGroupsForList%%';
  }

  public function getListLayout()
  {
    return 'tabular';
  }

  public function getListTitle()
  {
    return 'Product List';
  }

  public function getEditTitle()
  {
    return 'Edit Product';
  }

  public function getNewTitle()
  {
    return 'New Product';
  }

  public function getFilterDisplay()
  {
    return array(  0 => 'code',  1 => 'name',  2 => 'price',  3 => 'product_group', 4 => 'margin', 5=>'barcode');
  }

  public function getFormDisplay()
  {
    return array();
  }

  public function getEditDisplay()
  {
    return array();
  }

  public function getNewDisplay()
  {
    return array();
  }

  public function getListDisplay()
  {
    return array(  0 => 'code',  1 => 'name',  2 => 'pri_form',  3 => 'price',  4 => 'productGroupsForList',);
  }

  public function getFieldsDefault()
  {
    return array(
      'id' => array(  'is_link' => true,  'is_real' => true,  'is_partial' => false,  'is_component' => false,  'type' => 'Text',),
      'code' => array(  'is_link' => false,  'is_real' => true,  'is_partial' => false,  'is_component' => false,  'type' => 'Text',  'label' => 'Code',),
      'type' => array(  'is_link' => false,  'is_real' => true,  'is_partial' => false,  'is_component' => false,  'type' => 'Text',),
      'parameter' => array(  'is_link' => false,  'is_real' => true,  'is_partial' => false,  'is_component' => false,  'type' => 'Text',),
      'vatrate' => array(  'is_link' => false,  'is_real' => true,  'is_partial' => false,  'is_component' => false,  'type' => 'Text',),
      'mass' => array(  'is_link' => false,  'is_real' => true,  'is_partial' => false,  'is_component' => false,  'type' => 'Text',),
      'pri' => array(  'is_link' => false,  'is_real' => true,  'is_partial' => false,  'is_component' => false,  'type' => 'Text',),
      'price' => array(  'is_link' => false,  'is_real' => true,  'is_partial' => false,  'is_component' => false,  'type' => 'Text',),
      'scheduled' => array(  'is_link' => false,  'is_real' => true,  'is_partial' => false,  'is_component' => false,  'type' => 'Text',),
      'discount_price' => array(  'is_link' => false,  'is_real' => true,  'is_partial' => false,  'is_component' => false,  'type' => 'Text',),
      'is_active' => array(  'is_link' => false,  'is_real' => true,  'is_partial' => false,  'is_component' => false,  'type' => 'Boolean',),
      'created_at' => array(  'is_link' => false,  'is_real' => true,  'is_partial' => false,  'is_component' => false,  'type' => 'Date',),
      'updated_at' => array(  'is_link' => false,  'is_real' => true,  'is_partial' => false,  'is_component' => false,  'type' => 'Date',),
      'created_by' => array(  'is_link' => false,  'is_real' => true,  'is_partial' => false,  'is_component' => false,  'type' => 'Text',),
      'updated_by' => array(  'is_link' => false,  'is_real' => true,  'is_partial' => false,  'is_component' => false,  'type' => 'Text',),
      'connected_products_list' => array(  'is_link' => false,  'is_real' => false,  'is_partial' => false,  'is_component' => false,  'type' => 'Text',),
      'parameter_options_list' => array(  'is_link' => false,  'is_real' => false,  'is_partial' => false,  'is_component' => false,  'type' => 'Text',),
      'product_order_list' => array(  'is_link' => false,  'is_real' => false,  'is_partial' => false,  'is_component' => false,  'type' => 'Text',),
      'pri_form' => array(  'is_link' => false,  'is_real' => false,  'is_partial' => false,  'is_component' => false,  'type' => 'Text',  'label' => 'Priority',),
      'productGroupsForList' => array(  'is_link' => false,  'is_real' => false,  'is_partial' => false,  'is_component' => false,  'type' => 'Text',  'label' => 'Groups',),
    );
  }

  public function getFieldsList()
  {
    return array(
      'id' => array(),
      'code' => array(),
      'type' => array(),
      'parameter' => array(),
      'vatrate' => array(),
      'mass' => array(),
      'pri' => array(),
      'price' => array(),
      'scheduled' => array(),
      'discount_price' => array(),
      'is_active' => array(),
      'created_at' => array(),
      'updated_at' => array(),
      'created_by' => array(),
      'updated_by' => array(),
      'connected_products_list' => array(),
      'parameter_options_list' => array(),
      'product_order_list' => array(),
    );
  }

  public function getFieldsFilter()
  {
    return array(
      'id' => array(),
      'code' => array(),
      'type' => array(),
      'parameter' => array(),
      'vatrate' => array(),
      'mass' => array(),
      'pri' => array(),
      'price' => array(),
      'scheduled' => array(),
      'discount_price' => array(),
      'is_active' => array(),
      'created_at' => array(),
      'updated_at' => array(),
      'created_by' => array(),
      'updated_by' => array(),
      'connected_products_list' => array(),
      'parameter_options_list' => array(),
      'product_order_list' => array(),
    );
  }

  public function getFieldsForm()
  {
    return array(
      'id' => array(),
      'code' => array(),
      'type' => array(),
      'parameter' => array(),
      'vatrate' => array(),
      'mass' => array(),
      'pri' => array(),
      'price' => array(),
      'scheduled' => array(),
      'discount_price' => array(),
      'is_active' => array(),
      'created_at' => array(),
      'updated_at' => array(),
      'created_by' => array(),
      'updated_by' => array(),
      'connected_products_list' => array(),
      'parameter_options_list' => array(),
      'product_order_list' => array(),
    );
  }

  public function getFieldsEdit()
  {
    return array(
      'id' => array(),
      'code' => array(),
      'type' => array(),
      'parameter' => array(),
      'vatrate' => array(),
      'mass' => array(),
      'pri' => array(),
      'price' => array(),
      'scheduled' => array(),
      'discount_price' => array(),
      'is_active' => array(),
      'created_at' => array(),
      'updated_at' => array(),
      'created_by' => array(),
      'updated_by' => array(),
      'connected_products_list' => array(),
      'parameter_options_list' => array(),
      'product_order_list' => array(),
    );
  }

  public function getFieldsNew()
  {
    return array(
      'id' => array(),
      'code' => array(),
      'type' => array(),
      'parameter' => array(),
      'vatrate' => array(),
      'mass' => array(),
      'pri' => array(),
      'price' => array(),
      'scheduled' => array(),
      'discount_price' => array(),
      'is_active' => array(),
      'created_at' => array(),
      'updated_at' => array(),
      'created_by' => array(),
      'updated_by' => array(),
      'connected_products_list' => array(),
      'parameter_options_list' => array(),
      'product_order_list' => array(),
    );
  }


  /**
   * Gets the form class name.
   *
   * @return string The form class name
   */
  public function getFormClass()
  {
    return 'ProductForm';
  }

  public function hasFilterForm()
  {
    return true;
  }

  /**
   * Gets the filter form class name
   *
   * @return string The filter form class name associated with this generator
   */
  public function getFilterFormClass()
  {
    return 'ProductFormFilter';
  }

  public function getPagerClass()
  {
    return 'sfDoctrinePager';
  }

  public function getPagerMaxPerPage()
  {
    return 20;
  }

  public function getDefaultSort()
  {
    return array('pri', 'asc');
  }

  public function getTableMethod()
  {
    return '';
  }

  public function getTableCountMethod()
  {
    return '';
  }
}