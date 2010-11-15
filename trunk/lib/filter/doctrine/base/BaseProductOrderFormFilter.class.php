<?php

/**
 * ProductOrder filter form base class.
 *
 * @package    jobeet
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseProductOrderFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'public_user_id'  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('PublicUser'), 'add_empty' => true)),
      'order_number'    => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'price_currency'  => new sfWidgetFormFilterInput(),
      'pay_in_currency' => new sfWidgetFormFilterInput(),
      'user_culture'    => new sfWidgetFormFilterInput(),
      'is_archived'     => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'is_hidden'       => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'invoice_mailed'  => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'ticket'          => new sfWidgetFormFilterInput(),
      'ip'              => new sfWidgetFormFilterInput(),
      'buyer_email'     => new sfWidgetFormFilterInput(),
      'title'           => new sfWidgetFormFilterInput(),
      'notes'           => new sfWidgetFormFilterInput(),
      'status'          => new sfWidgetFormChoice(array('choices' => array('' => '', 'new' => 'new', 'paid' => 'paid', 'canceled' => 'canceled'))),
      'raw_response'    => new sfWidgetFormFilterInput(),
      'type'            => new sfWidgetFormChoice(array('choices' => array('' => '', 'seb' => 'seb', 'swed' => 'swed', 'sampo' => 'sampo', 'nordea' => 'nordea'))),
      'created_at'      => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'      => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'products_list'   => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Product')),
    ));

    $this->setValidators(array(
      'public_user_id'  => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('PublicUser'), 'column' => 'id')),
      'order_number'    => new sfValidatorPass(array('required' => false)),
      'price_currency'  => new sfValidatorPass(array('required' => false)),
      'pay_in_currency' => new sfValidatorPass(array('required' => false)),
      'user_culture'    => new sfValidatorPass(array('required' => false)),
      'is_archived'     => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'is_hidden'       => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'invoice_mailed'  => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'ticket'          => new sfValidatorPass(array('required' => false)),
      'ip'              => new sfValidatorPass(array('required' => false)),
      'buyer_email'     => new sfValidatorPass(array('required' => false)),
      'title'           => new sfValidatorPass(array('required' => false)),
      'notes'           => new sfValidatorPass(array('required' => false)),
      'status'          => new sfValidatorChoice(array('required' => false, 'choices' => array('new' => 'new', 'paid' => 'paid', 'canceled' => 'canceled'))),
      'raw_response'    => new sfValidatorPass(array('required' => false)),
      'type'            => new sfValidatorChoice(array('required' => false, 'choices' => array('seb' => 'seb', 'swed' => 'swed', 'sampo' => 'sampo', 'nordea' => 'nordea'))),
      'created_at'      => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'      => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'products_list'   => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Product', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('product_order_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function addProductsListColumnQuery(Doctrine_Query $query, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $query
      ->leftJoin($query->getRootAlias().'.ProductOrderVsProduct ProductOrderVsProduct')
      ->andWhereIn('ProductOrderVsProduct.product_id', $values)
    ;
  }

  public function getModelName()
  {
    return 'ProductOrder';
  }

  public function getFields()
  {
    return array(
      'id'              => 'Number',
      'public_user_id'  => 'ForeignKey',
      'order_number'    => 'Text',
      'price_currency'  => 'Text',
      'pay_in_currency' => 'Text',
      'user_culture'    => 'Text',
      'is_archived'     => 'Boolean',
      'is_hidden'       => 'Boolean',
      'invoice_mailed'  => 'Boolean',
      'ticket'          => 'Text',
      'ip'              => 'Text',
      'buyer_email'     => 'Text',
      'title'           => 'Text',
      'notes'           => 'Text',
      'status'          => 'Enum',
      'raw_response'    => 'Text',
      'type'            => 'Enum',
      'created_at'      => 'Date',
      'updated_at'      => 'Date',
      'products_list'   => 'ManyKey',
    );
  }
}
