<?php

/**
 * NewItem filter form base class.
 *
 * @package    jobeet
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseNewItemFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'name'         => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'description'  => new sfWidgetFormFilterInput(),
      'content'      => new sfWidgetFormFilterInput(),
      'active_start' => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'active_end'   => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'source'       => new sfWidgetFormFilterInput(),
      'tags'         => new sfWidgetFormFilterInput(),
      'group_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('NewsGroup'), 'add_empty' => true)),
      'pri'          => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'picture'      => new sfWidgetFormFilterInput(),
      'type'         => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'slug'         => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'name'         => new sfValidatorPass(array('required' => false)),
      'description'  => new sfValidatorPass(array('required' => false)),
      'content'      => new sfValidatorPass(array('required' => false)),
      'active_start' => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'active_end'   => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'source'       => new sfValidatorPass(array('required' => false)),
      'tags'         => new sfValidatorPass(array('required' => false)),
      'group_id'     => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('NewsGroup'), 'column' => 'id')),
      'pri'          => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'picture'      => new sfValidatorPass(array('required' => false)),
      'type'         => new sfValidatorPass(array('required' => false)),
      'slug'         => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('new_item_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'NewItem';
  }

  public function getFields()
  {
    return array(
      'id'           => 'Number',
      'name'         => 'Text',
      'description'  => 'Text',
      'content'      => 'Text',
      'active_start' => 'Date',
      'active_end'   => 'Date',
      'source'       => 'Text',
      'tags'         => 'Text',
      'group_id'     => 'ForeignKey',
      'pri'          => 'Number',
      'picture'      => 'Text',
      'type'         => 'Text',
      'slug'         => 'Text',
    );
  }
}
