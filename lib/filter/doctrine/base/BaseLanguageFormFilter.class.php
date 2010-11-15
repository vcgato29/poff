<?php

/**
 * Language filter form base class.
 *
 * @package    jobeet
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseLanguageFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'url'       => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'abr'       => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'title_est' => new sfWidgetFormFilterInput(array('with_empty' => false)),
    ));

    $this->setValidators(array(
      'url'       => new sfValidatorPass(array('required' => false)),
      'abr'       => new sfValidatorPass(array('required' => false)),
      'title_est' => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('language_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Language';
  }

  public function getFields()
  {
    return array(
      'id'        => 'Number',
      'url'       => 'Text',
      'abr'       => 'Text',
      'title_est' => 'Text',
    );
  }
}
