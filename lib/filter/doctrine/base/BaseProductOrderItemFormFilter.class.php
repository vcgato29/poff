<?php

/**
 * ProductOrderItem filter form base class.
 *
 * @package    jobeet
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseProductOrderItemFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'order_id'          => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('ProductOrder'), 'add_empty' => true)),
      'price_currency'    => new sfWidgetFormFilterInput(),
      'product_id'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Product'), 'add_empty' => true)),
      'mass'              => new sfWidgetFormFilterInput(),
      'vatrate'           => new sfWidgetFormFilterInput(),
      'code'              => new sfWidgetFormFilterInput(),
      'order_shipping_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('ProductOrderShipping'), 'add_empty' => true)),
      'name'              => new sfWidgetFormFilterInput(),
      'quanity'           => new sfWidgetFormFilterInput(),
      'price'             => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'order_id'          => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('ProductOrder'), 'column' => 'id')),
      'price_currency'    => new sfValidatorPass(array('required' => false)),
      'product_id'        => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Product'), 'column' => 'id')),
      'mass'              => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'vatrate'           => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'code'              => new sfValidatorPass(array('required' => false)),
      'order_shipping_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('ProductOrderShipping'), 'column' => 'id')),
      'name'              => new sfValidatorPass(array('required' => false)),
      'quanity'           => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'price'             => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('product_order_item_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'ProductOrderItem';
  }

  public function getFields()
  {
    return array(
      'id'                => 'Number',
      'order_id'          => 'ForeignKey',
      'price_currency'    => 'Text',
      'product_id'        => 'ForeignKey',
      'mass'              => 'Number',
      'vatrate'           => 'Number',
      'code'              => 'Text',
      'order_shipping_id' => 'ForeignKey',
      'name'              => 'Text',
      'quanity'           => 'Number',
      'price'             => 'Number',
    );
  }
}
