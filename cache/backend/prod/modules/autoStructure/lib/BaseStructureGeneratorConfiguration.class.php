<?php

/**
 * structure module configuration.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage structure
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: configuration.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseStructureGeneratorConfiguration extends sfModelGeneratorConfiguration
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
    return array(  '_delete' => NULL,);
  }

  public function getListParams()
  {
    return '%%id%% - %%title%% - %%parameter%% - %%picture%% - %%content%% - %%inherits_layout%% - %%type%% - %%description%% - %%pageTitle%% - %%layout%% - %%metaDescription%% - %%metaKeywords%% - %%status%% - %%is_first%% - %%lang%% - %%pri%% - %%parentID%% - %%isHidden%% - %%slug%% - %%created_at%% - %%updated_at%% - %%lft%% - %%rgt%% - %%level%% - %%created_by%% - %%updated_by%%';
  }

  public function getListLayout()
  {
    return 'tabular';
  }

  public function getListTitle()
  {
    return 'Structure List';
  }

  public function getEditTitle()
  {
    return 'Edit Structure';
  }

  public function getNewTitle()
  {
    return 'New Structure';
  }

  public function getFilterDisplay()
  {
    return array();
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
    return array(  0 => 'id',  1 => 'title',  2 => 'parameter',  3 => 'picture',  4 => 'content',  5 => 'inherits_layout',  6 => 'type',  7 => 'description',  8 => 'pageTitle',  9 => 'layout',  10 => 'metaDescription',  11 => 'metaKeywords',  12 => 'status',  13 => 'is_first',  14 => 'lang',  15 => 'pri',  16 => 'parentID',  17 => 'isHidden',  18 => 'slug',  19 => 'created_at',  20 => 'updated_at',  21 => 'lft',  22 => 'rgt',  23 => 'level',  24 => 'created_by',  25 => 'updated_by',);
  }

  public function getFieldsDefault()
  {
    return array(
      'id' => array(  'is_link' => true,  'is_real' => true,  'is_partial' => false,  'is_component' => false,  'type' => 'Text',),
      'title' => array(  'is_link' => false,  'is_real' => true,  'is_partial' => false,  'is_component' => false,  'type' => 'Text',),
      'parameter' => array(  'is_link' => false,  'is_real' => true,  'is_partial' => false,  'is_component' => false,  'type' => 'Text',),
      'picture' => array(  'is_link' => false,  'is_real' => true,  'is_partial' => false,  'is_component' => false,  'type' => 'Text',),
      'content' => array(  'is_link' => false,  'is_real' => true,  'is_partial' => false,  'is_component' => false,  'type' => 'Text',),
      'inherits_layout' => array(  'is_link' => false,  'is_real' => true,  'is_partial' => false,  'is_component' => false,  'type' => 'Boolean',),
      'type' => array(  'is_link' => false,  'is_real' => true,  'is_partial' => false,  'is_component' => false,  'type' => 'Text',),
      'description' => array(  'is_link' => false,  'is_real' => true,  'is_partial' => false,  'is_component' => false,  'type' => 'Text',),
      'pageTitle' => array(  'is_link' => false,  'is_real' => true,  'is_partial' => false,  'is_component' => false,  'type' => 'Text',),
      'layout' => array(  'is_link' => false,  'is_real' => true,  'is_partial' => false,  'is_component' => false,  'type' => 'Text',),
      'metaDescription' => array(  'is_link' => false,  'is_real' => true,  'is_partial' => false,  'is_component' => false,  'type' => 'Text',),
      'metaKeywords' => array(  'is_link' => false,  'is_real' => true,  'is_partial' => false,  'is_component' => false,  'type' => 'Text',),
      'status' => array(  'is_link' => false,  'is_real' => true,  'is_partial' => false,  'is_component' => false,  'type' => 'Text',),
      'is_first' => array(  'is_link' => false,  'is_real' => true,  'is_partial' => false,  'is_component' => false,  'type' => 'Boolean',),
      'lang' => array(  'is_link' => false,  'is_real' => true,  'is_partial' => false,  'is_component' => false,  'type' => 'Text',),
      'pri' => array(  'is_link' => false,  'is_real' => true,  'is_partial' => false,  'is_component' => false,  'type' => 'Text',),
      'parentID' => array(  'is_link' => false,  'is_real' => true,  'is_partial' => false,  'is_component' => false,  'type' => 'ForeignKey',),
      'isHidden' => array(  'is_link' => false,  'is_real' => true,  'is_partial' => false,  'is_component' => false,  'type' => 'Boolean',),
      'slug' => array(  'is_link' => false,  'is_real' => true,  'is_partial' => false,  'is_component' => false,  'type' => 'Text',),
      'created_at' => array(  'is_link' => false,  'is_real' => true,  'is_partial' => false,  'is_component' => false,  'type' => 'Date',),
      'updated_at' => array(  'is_link' => false,  'is_real' => true,  'is_partial' => false,  'is_component' => false,  'type' => 'Date',),
      'lft' => array(  'is_link' => false,  'is_real' => true,  'is_partial' => false,  'is_component' => false,  'type' => 'Text',),
      'rgt' => array(  'is_link' => false,  'is_real' => true,  'is_partial' => false,  'is_component' => false,  'type' => 'Text',),
      'level' => array(  'is_link' => false,  'is_real' => true,  'is_partial' => false,  'is_component' => false,  'type' => 'Text',),
      'created_by' => array(  'is_link' => false,  'is_real' => true,  'is_partial' => false,  'is_component' => false,  'type' => 'Text',),
      'updated_by' => array(  'is_link' => false,  'is_real' => true,  'is_partial' => false,  'is_component' => false,  'type' => 'Text',),
    );
  }

  public function getFieldsList()
  {
    return array(
      'id' => array(),
      'title' => array(),
      'parameter' => array(),
      'picture' => array(),
      'content' => array(),
      'inherits_layout' => array(),
      'type' => array(),
      'description' => array(),
      'pageTitle' => array(),
      'layout' => array(),
      'metaDescription' => array(),
      'metaKeywords' => array(),
      'status' => array(),
      'is_first' => array(),
      'lang' => array(),
      'pri' => array(),
      'parentID' => array(),
      'isHidden' => array(),
      'slug' => array(),
      'created_at' => array(),
      'updated_at' => array(),
      'lft' => array(),
      'rgt' => array(),
      'level' => array(),
      'created_by' => array(),
      'updated_by' => array(),
    );
  }

  public function getFieldsFilter()
  {
    return array(
      'id' => array(),
      'title' => array(),
      'parameter' => array(),
      'picture' => array(),
      'content' => array(),
      'inherits_layout' => array(),
      'type' => array(),
      'description' => array(),
      'pageTitle' => array(),
      'layout' => array(),
      'metaDescription' => array(),
      'metaKeywords' => array(),
      'status' => array(),
      'is_first' => array(),
      'lang' => array(),
      'pri' => array(),
      'parentID' => array(),
      'isHidden' => array(),
      'slug' => array(),
      'created_at' => array(),
      'updated_at' => array(),
      'lft' => array(),
      'rgt' => array(),
      'level' => array(),
      'created_by' => array(),
      'updated_by' => array(),
    );
  }

  public function getFieldsForm()
  {
    return array(
      'id' => array(),
      'title' => array(),
      'parameter' => array(),
      'picture' => array(),
      'content' => array(),
      'inherits_layout' => array(),
      'type' => array(),
      'description' => array(),
      'pageTitle' => array(),
      'layout' => array(),
      'metaDescription' => array(),
      'metaKeywords' => array(),
      'status' => array(),
      'is_first' => array(),
      'lang' => array(),
      'pri' => array(),
      'parentID' => array(),
      'isHidden' => array(),
      'slug' => array(),
      'created_at' => array(),
      'updated_at' => array(),
      'lft' => array(),
      'rgt' => array(),
      'level' => array(),
      'created_by' => array(),
      'updated_by' => array(),
    );
  }

  public function getFieldsEdit()
  {
    return array(
      'id' => array(),
      'title' => array(),
      'parameter' => array(),
      'picture' => array(),
      'content' => array(),
      'inherits_layout' => array(),
      'type' => array(),
      'description' => array(),
      'pageTitle' => array(),
      'layout' => array(),
      'metaDescription' => array(),
      'metaKeywords' => array(),
      'status' => array(),
      'is_first' => array(),
      'lang' => array(),
      'pri' => array(),
      'parentID' => array(),
      'isHidden' => array(),
      'slug' => array(),
      'created_at' => array(),
      'updated_at' => array(),
      'lft' => array(),
      'rgt' => array(),
      'level' => array(),
      'created_by' => array(),
      'updated_by' => array(),
    );
  }

  public function getFieldsNew()
  {
    return array(
      'id' => array(),
      'title' => array(),
      'parameter' => array(),
      'picture' => array(),
      'content' => array(),
      'inherits_layout' => array(),
      'type' => array(),
      'description' => array(),
      'pageTitle' => array(),
      'layout' => array(),
      'metaDescription' => array(),
      'metaKeywords' => array(),
      'status' => array(),
      'is_first' => array(),
      'lang' => array(),
      'pri' => array(),
      'parentID' => array(),
      'isHidden' => array(),
      'slug' => array(),
      'created_at' => array(),
      'updated_at' => array(),
      'lft' => array(),
      'rgt' => array(),
      'level' => array(),
      'created_by' => array(),
      'updated_by' => array(),
    );
  }


  /**
   * Gets the form class name.
   *
   * @return string The form class name
   */
  public function getFormClass()
  {
    return 'StructureForm';
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
    return 'StructureFormFilter';
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
    return array(null, null);
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
