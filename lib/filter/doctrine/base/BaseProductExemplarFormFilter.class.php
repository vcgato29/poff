<?php

/**
 * ProductExemplar filter form base class.
 *
 * @package    jobeet
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseProductExemplarFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'code'           => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'location'       => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'scheduled_time' => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'product_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Product'), 'add_empty' => true)),
      'buy_link'       => new sfWidgetFormFilterInput(),
      'cinema'         => new sfWidgetFormFilterInput(array('with_empty' => false)),
    ));

    $this->setValidators(array(
      'code'           => new sfValidatorPass(array('required' => false)),
      'location'       => new sfValidatorPass(array('required' => false)),
      'scheduled_time' => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'product_id'     => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Product'), 'column' => 'id')),
      'buy_link'       => new sfValidatorPass(array('required' => false)),
      'cinema'         => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('product_exemplar_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'ProductExemplar';
  }

  public function getFields()
  {
    return array(
      'id'             => 'Number',
      'code'           => 'Text',
      'location'       => 'Text',
      'scheduled_time' => 'Date',
      'product_id'     => 'ForeignKey',
      'buy_link'       => 'Text',
      'cinema'         => 'Text',
    );
  }
}
