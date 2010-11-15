<?php

/**
 * translations module configuration.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage translations
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: configuration.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseTranslationsGeneratorConfiguration extends sfModelGeneratorConfiguration
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
    return array(  '_delete' => NULL,);
  }

  public function getListActions()
  {
    return array(  '_new' => NULL,);
  }

  public function getListBatchActions()
  {
    return array(  'save' => NULL,  'setLanguages' => NULL,  '_delete' => NULL,);
  }

  public function getListParams()
  {
    return '%%=source%%';
  }

  public function getListLayout()
  {
    return 'tabular';
  }

  public function getListTitle()
  {
    return 'Translations List';
  }

  public function getEditTitle()
  {
    return 'Edit Translations';
  }

  public function getNewTitle()
  {
    return 'New Translations';
  }

  public function getFilterDisplay()
  {
    return array(  0 => 'source',  1 => 'target',);
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
    return array(  0 => '=source',);
  }

  public function getFieldsDefault()
  {
    return array(
      'msg_id' => array(  'is_link' => true,  'is_real' => true,  'is_partial' => false,  'is_component' => false,  'type' => 'Text',),
      'cat_id' => array(  'is_link' => false,  'is_real' => true,  'is_partial' => false,  'is_component' => false,  'type' => 'ForeignKey',),
      'id' => array(  'is_link' => false,  'is_real' => true,  'is_partial' => false,  'is_component' => false,  'type' => 'Text',),
      'source' => array(  'is_link' => false,  'is_real' => true,  'is_partial' => false,  'is_component' => false,  'type' => 'Text',),
      'target' => array(  'is_link' => false,  'is_real' => true,  'is_partial' => false,  'is_component' => false,  'type' => 'Text',),
      'comments' => array(  'is_link' => false,  'is_real' => true,  'is_partial' => false,  'is_component' => false,  'type' => 'Text',),
      'type' => array(  'is_link' => false,  'is_real' => true,  'is_partial' => false,  'is_component' => false,  'type' => 'Text',),
      'date_created' => array(  'is_link' => false,  'is_real' => true,  'is_partial' => false,  'is_component' => false,  'type' => 'Text',),
      'date_modified' => array(  'is_link' => false,  'is_real' => true,  'is_partial' => false,  'is_component' => false,  'type' => 'Text',),
      'author' => array(  'is_link' => false,  'is_real' => true,  'is_partial' => false,  'is_component' => false,  'type' => 'Text',),
      'translated' => array(  'is_link' => false,  'is_real' => true,  'is_partial' => false,  'is_component' => false,  'type' => 'Text',),
      'variable_id' => array(  'is_link' => false,  'is_real' => true,  'is_partial' => false,  'is_component' => false,  'type' => 'ForeignKey',),
    );
  }

  public function getFieldsList()
  {
    return array(
      'msg_id' => array(),
      'cat_id' => array(),
      'id' => array(),
      'source' => array(),
      'target' => array(),
      'comments' => array(),
      'type' => array(),
      'date_created' => array(),
      'date_modified' => array(),
      'author' => array(),
      'translated' => array(),
      'variable_id' => array(),
    );
  }

  public function getFieldsFilter()
  {
    return array(
      'msg_id' => array(),
      'cat_id' => array(),
      'id' => array(),
      'source' => array(),
      'target' => array(),
      'comments' => array(),
      'type' => array(),
      'date_created' => array(),
      'date_modified' => array(),
      'author' => array(),
      'translated' => array(),
      'variable_id' => array(),
    );
  }

  public function getFieldsForm()
  {
    return array(
      'msg_id' => array(),
      'cat_id' => array(),
      'id' => array(),
      'source' => array(),
      'target' => array(),
      'comments' => array(),
      'type' => array(),
      'date_created' => array(),
      'date_modified' => array(),
      'author' => array(),
      'translated' => array(),
      'variable_id' => array(),
    );
  }

  public function getFieldsEdit()
  {
    return array(
      'msg_id' => array(),
      'cat_id' => array(),
      'id' => array(),
      'source' => array(),
      'target' => array(),
      'comments' => array(),
      'type' => array(),
      'date_created' => array(),
      'date_modified' => array(),
      'author' => array(),
      'translated' => array(),
      'variable_id' => array(),
    );
  }

  public function getFieldsNew()
  {
    return array(
      'msg_id' => array(),
      'cat_id' => array(),
      'id' => array(),
      'source' => array(),
      'target' => array(),
      'comments' => array(),
      'type' => array(),
      'date_created' => array(),
      'date_modified' => array(),
      'author' => array(),
      'translated' => array(),
      'variable_id' => array(),
    );
  }


  /**
   * Gets the form class name.
   *
   * @return string The form class name
   */
  public function getFormClass()
  {
    return 'TransUnitForm';
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
    return 'TransUnitFormFilter';
  }

  public function getPagerClass()
  {
    return 'sfDoctrinePager';
  }

  public function getPagerMaxPerPage()
  {
    return 10;
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
