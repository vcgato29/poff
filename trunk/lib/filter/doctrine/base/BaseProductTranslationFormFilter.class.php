<?php

/**
 * ProductTranslation filter form base class.
 *
 * @package    jobeet
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseProductTranslationFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'slug'                 => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'country'              => new sfWidgetFormFilterInput(),
      'synopsis'             => new sfWidgetFormFilterInput(),
      'producer_description' => new sfWidgetFormFilterInput(),
      'critics'              => new sfWidgetFormFilterInput(),
      'language'             => new sfWidgetFormFilterInput(),
      'name'                 => new sfWidgetFormFilterInput(),
      'description'          => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'slug'                 => new sfValidatorPass(array('required' => false)),
      'country'              => new sfValidatorPass(array('required' => false)),
      'synopsis'             => new sfValidatorPass(array('required' => false)),
      'producer_description' => new sfValidatorPass(array('required' => false)),
      'critics'              => new sfValidatorPass(array('required' => false)),
      'language'             => new sfValidatorPass(array('required' => false)),
      'name'                 => new sfValidatorPass(array('required' => false)),
      'description'          => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('product_translation_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'ProductTranslation';
  }

  public function getFields()
  {
    return array(
      'id'                   => 'Number',
      'slug'                 => 'Text',
      'country'              => 'Text',
      'synopsis'             => 'Text',
      'producer_description' => 'Text',
      'critics'              => 'Text',
      'language'             => 'Text',
      'name'                 => 'Text',
      'description'          => 'Text',
      'lang'                 => 'Text',
    );
  }
}
