<?php

/**
 * Banner filter form base class.
 *
 * @package    jobeet
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseBannerFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'name'            => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'pri'             => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'type'            => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'link'            => new sfWidgetFormFilterInput(),
      'content'         => new sfWidgetFormFilterInput(),
      'flash_vars'      => new sfWidgetFormFilterInput(),
      'is_active'       => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'displayed'       => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'clicked'         => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'file'            => new sfWidgetFormFilterInput(),
      'width'           => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'height'          => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'banner_group_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('BannerGroup'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'name'            => new sfValidatorPass(array('required' => false)),
      'pri'             => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'type'            => new sfValidatorPass(array('required' => false)),
      'link'            => new sfValidatorPass(array('required' => false)),
      'content'         => new sfValidatorPass(array('required' => false)),
      'flash_vars'      => new sfValidatorPass(array('required' => false)),
      'is_active'       => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'displayed'       => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'clicked'         => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'file'            => new sfValidatorPass(array('required' => false)),
      'width'           => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'height'          => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'banner_group_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('BannerGroup'), 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('banner_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Banner';
  }

  public function getFields()
  {
    return array(
      'id'              => 'Number',
      'name'            => 'Text',
      'pri'             => 'Number',
      'type'            => 'Text',
      'link'            => 'Text',
      'content'         => 'Text',
      'flash_vars'      => 'Text',
      'is_active'       => 'Boolean',
      'displayed'       => 'Number',
      'clicked'         => 'Number',
      'file'            => 'Text',
      'width'           => 'Number',
      'height'          => 'Number',
      'banner_group_id' => 'ForeignKey',
    );
  }
}
