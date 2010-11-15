<?php

/**
 * ProductFile filter form base class.
 *
 * @package    jobeet
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseProductFileFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'file'              => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'pri'               => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'original_filename' => new sfWidgetFormFilterInput(),
      'parameter'         => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'product_id'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Product'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'file'              => new sfValidatorPass(array('required' => false)),
      'pri'               => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'original_filename' => new sfValidatorPass(array('required' => false)),
      'parameter'         => new sfValidatorPass(array('required' => false)),
      'product_id'        => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Product'), 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('product_file_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'ProductFile';
  }

  public function getFields()
  {
    return array(
      'id'                => 'Number',
      'file'              => 'Text',
      'pri'               => 'Number',
      'original_filename' => 'Text',
      'parameter'         => 'Text',
      'product_id'        => 'ForeignKey',
    );
  }
}
