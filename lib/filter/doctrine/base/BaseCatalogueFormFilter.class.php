<?php

/**
 * Catalogue filter form base class.
 *
 * @package    jobeet
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseCatalogueFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'name'          => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'source_lang'   => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'target_lang'   => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'date_created'  => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'date_modified' => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'author'        => new sfWidgetFormFilterInput(array('with_empty' => false)),
    ));

    $this->setValidators(array(
      'name'          => new sfValidatorPass(array('required' => false)),
      'source_lang'   => new sfValidatorPass(array('required' => false)),
      'target_lang'   => new sfValidatorPass(array('required' => false)),
      'date_created'  => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'date_modified' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'author'        => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('catalogue_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Catalogue';
  }

  public function getFields()
  {
    return array(
      'cat_id'        => 'Number',
      'name'          => 'Text',
      'source_lang'   => 'Text',
      'target_lang'   => 'Text',
      'date_created'  => 'Number',
      'date_modified' => 'Number',
      'author'        => 'Text',
    );
  }
}
