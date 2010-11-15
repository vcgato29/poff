<?php

/**
 * Structure filter form base class.
 *
 * @package    jobeet
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseStructureFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'title'           => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'parameter'       => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'picture'         => new sfWidgetFormFilterInput(),
      'content'         => new sfWidgetFormFilterInput(),
      'inherits_layout' => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'type'            => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'description'     => new sfWidgetFormFilterInput(),
      'pageTitle'       => new sfWidgetFormFilterInput(),
      'layout'          => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'metaDescription' => new sfWidgetFormFilterInput(),
      'metaKeywords'    => new sfWidgetFormFilterInput(),
      'status'          => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'is_first'        => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'lang'            => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'pri'             => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'parentID'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Parent'), 'add_empty' => true)),
      'isHidden'        => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'slug'            => new sfWidgetFormFilterInput(),
      'created_at'      => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'      => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'lft'             => new sfWidgetFormFilterInput(),
      'rgt'             => new sfWidgetFormFilterInput(),
      'level'           => new sfWidgetFormFilterInput(),
      'created_by'      => new sfWidgetFormFilterInput(),
      'updated_by'      => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'title'           => new sfValidatorPass(array('required' => false)),
      'parameter'       => new sfValidatorPass(array('required' => false)),
      'picture'         => new sfValidatorPass(array('required' => false)),
      'content'         => new sfValidatorPass(array('required' => false)),
      'inherits_layout' => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'type'            => new sfValidatorPass(array('required' => false)),
      'description'     => new sfValidatorPass(array('required' => false)),
      'pageTitle'       => new sfValidatorPass(array('required' => false)),
      'layout'          => new sfValidatorPass(array('required' => false)),
      'metaDescription' => new sfValidatorPass(array('required' => false)),
      'metaKeywords'    => new sfValidatorPass(array('required' => false)),
      'status'          => new sfValidatorPass(array('required' => false)),
      'is_first'        => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'lang'            => new sfValidatorPass(array('required' => false)),
      'pri'             => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'parentID'        => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Parent'), 'column' => 'id')),
      'isHidden'        => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'slug'            => new sfValidatorPass(array('required' => false)),
      'created_at'      => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'      => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'lft'             => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'rgt'             => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'level'           => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'created_by'      => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'updated_by'      => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('structure_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Structure';
  }

  public function getFields()
  {
    return array(
      'id'              => 'Number',
      'title'           => 'Text',
      'parameter'       => 'Text',
      'picture'         => 'Text',
      'content'         => 'Text',
      'inherits_layout' => 'Boolean',
      'type'            => 'Text',
      'description'     => 'Text',
      'pageTitle'       => 'Text',
      'layout'          => 'Text',
      'metaDescription' => 'Text',
      'metaKeywords'    => 'Text',
      'status'          => 'Text',
      'is_first'        => 'Boolean',
      'lang'            => 'Text',
      'pri'             => 'Number',
      'parentID'        => 'ForeignKey',
      'isHidden'        => 'Boolean',
      'slug'            => 'Text',
      'created_at'      => 'Date',
      'updated_at'      => 'Date',
      'lft'             => 'Number',
      'rgt'             => 'Number',
      'level'           => 'Number',
      'created_by'      => 'Number',
      'updated_by'      => 'Number',
    );
  }
}
