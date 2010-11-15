<?php

/**
 * Product filter form base class.
 *
 * @package    jobeet
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseProductFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'code'                    => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'original_title'          => new sfWidgetFormFilterInput(),
      'producer'                => new sfWidgetFormFilterInput(),
      'trailer_link'            => new sfWidgetFormFilterInput(),
      'type'                    => new sfWidgetFormFilterInput(),
      'parameter'               => new sfWidgetFormFilterInput(),
      'year'                    => new sfWidgetFormFilterInput(),
      'pri'                     => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'rating_sum'              => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'rating_votes'            => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'price'                   => new sfWidgetFormFilterInput(),
      'is_active'               => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'created_at'              => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'              => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'created_by'              => new sfWidgetFormFilterInput(),
      'updated_by'              => new sfWidgetFormFilterInput(),
      'connected_products_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Product')),
      'parameter_options_list'  => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'ParameterOption')),
      'product_order_list'      => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'ProductOrder')),
    ));

    $this->setValidators(array(
      'code'                    => new sfValidatorPass(array('required' => false)),
      'original_title'          => new sfValidatorPass(array('required' => false)),
      'producer'                => new sfValidatorPass(array('required' => false)),
      'trailer_link'            => new sfValidatorPass(array('required' => false)),
      'type'                    => new sfValidatorPass(array('required' => false)),
      'parameter'               => new sfValidatorPass(array('required' => false)),
      'year'                    => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'pri'                     => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'rating_sum'              => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'rating_votes'            => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'price'                   => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'is_active'               => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'created_at'              => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'              => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'created_by'              => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'updated_by'              => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'connected_products_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Product', 'required' => false)),
      'parameter_options_list'  => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'ParameterOption', 'required' => false)),
      'product_order_list'      => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'ProductOrder', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('product_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function addConnectedProductsListColumnQuery(Doctrine_Query $query, $field, $values)
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
      ->leftJoin($query->getRootAlias().'.ProductVsProduct ProductVsProduct')
      ->andWhereIn('ProductVsProduct.product2', $values)
    ;
  }

  public function addParameterOptionsListColumnQuery(Doctrine_Query $query, $field, $values)
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
      ->leftJoin($query->getRootAlias().'.ParameterProductOption ParameterProductOption')
      ->andWhereIn('ParameterProductOption.option_id', $values)
    ;
  }

  public function addProductOrderListColumnQuery(Doctrine_Query $query, $field, $values)
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
      ->andWhereIn('ProductOrderVsProduct.order_id', $values)
    ;
  }

  public function getModelName()
  {
    return 'Product';
  }

  public function getFields()
  {
    return array(
      'id'                      => 'Number',
      'code'                    => 'Text',
      'original_title'          => 'Text',
      'producer'                => 'Text',
      'trailer_link'            => 'Text',
      'type'                    => 'Text',
      'parameter'               => 'Text',
      'year'                    => 'Number',
      'pri'                     => 'Number',
      'rating_sum'              => 'Number',
      'rating_votes'            => 'Number',
      'price'                   => 'Number',
      'is_active'               => 'Boolean',
      'created_at'              => 'Date',
      'updated_at'              => 'Date',
      'created_by'              => 'Number',
      'updated_by'              => 'Number',
      'connected_products_list' => 'ManyKey',
      'parameter_options_list'  => 'ManyKey',
      'product_order_list'      => 'ManyKey',
    );
  }
}
