<?php

/**
 * TransUnit filter form base class.
 *
 * @package    jobeet
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseTransUnitFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'cat_id'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Catalogue'), 'add_empty' => true)),
      'id'            => new sfWidgetFormFilterInput(),
      'source'        => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'target'        => new sfWidgetFormFilterInput(),
      'comments'      => new sfWidgetFormFilterInput(),
      'type'          => new sfWidgetFormFilterInput(),
      'date_created'  => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'date_modified' => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'author'        => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'translated'    => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'variable_id'   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('TransUnitVariable'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'cat_id'        => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Catalogue'), 'column' => 'cat_id')),
      'id'            => new sfValidatorPass(array('required' => false)),
      'source'        => new sfValidatorPass(array('required' => false)),
      'target'        => new sfValidatorPass(array('required' => false)),
      'comments'      => new sfValidatorPass(array('required' => false)),
      'type'          => new sfValidatorPass(array('required' => false)),
      'date_created'  => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'date_modified' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'author'        => new sfValidatorPass(array('required' => false)),
      'translated'    => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'variable_id'   => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('TransUnitVariable'), 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('trans_unit_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'TransUnit';
  }

  public function getFields()
  {
    return array(
      'msg_id'        => 'Number',
      'cat_id'        => 'ForeignKey',
      'id'            => 'Text',
      'source'        => 'Text',
      'target'        => 'Text',
      'comments'      => 'Text',
      'type'          => 'Text',
      'date_created'  => 'Number',
      'date_modified' => 'Number',
      'author'        => 'Text',
      'translated'    => 'Number',
      'variable_id'   => 'ForeignKey',
    );
  }
}
