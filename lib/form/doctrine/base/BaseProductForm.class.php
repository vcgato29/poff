<?php

/**
 * Product form base class.
 *
 * @method Product getObject() Returns the current form's model object
 *
 * @package    jobeet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseProductForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                      => new sfWidgetFormInputHidden(),
      'code'                    => new sfWidgetFormInputText(),
      'original_title'          => new sfWidgetFormTextarea(),
      'producer'                => new sfWidgetFormInputText(),
      'trailer_link'            => new sfWidgetFormTextarea(),
      'type'                    => new sfWidgetFormInputText(),
      'parameter'               => new sfWidgetFormInputText(),
      'year'                    => new sfWidgetFormInputText(),
      'pri'                     => new sfWidgetFormInputText(),
      'rating_sum'              => new sfWidgetFormInputText(),
      'rating_votes'            => new sfWidgetFormInputText(),
      'price'                   => new sfWidgetFormInputText(),
      'is_active'               => new sfWidgetFormInputCheckbox(),
      'created_at'              => new sfWidgetFormDateTime(),
      'updated_at'              => new sfWidgetFormDateTime(),
      'created_by'              => new sfWidgetFormInputText(),
      'updated_by'              => new sfWidgetFormInputText(),
      'connected_products_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Product')),
      'parameter_options_list'  => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'ParameterOption')),
      'product_order_list'      => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'ProductOrder')),
    ));

    $this->setValidators(array(
      'id'                      => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'code'                    => new sfValidatorString(array('max_length' => 255)),
      'original_title'          => new sfValidatorString(array('max_length' => 400, 'required' => false)),
      'producer'                => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'trailer_link'            => new sfValidatorString(array('max_length' => 400, 'required' => false)),
      'type'                    => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'parameter'               => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'year'                    => new sfValidatorInteger(array('required' => false)),
      'pri'                     => new sfValidatorInteger(array('required' => false)),
      'rating_sum'              => new sfValidatorInteger(array('required' => false)),
      'rating_votes'            => new sfValidatorInteger(array('required' => false)),
      'price'                   => new sfValidatorNumber(array('required' => false)),
      'is_active'               => new sfValidatorBoolean(array('required' => false)),
      'created_at'              => new sfValidatorDateTime(),
      'updated_at'              => new sfValidatorDateTime(),
      'created_by'              => new sfValidatorInteger(array('required' => false)),
      'updated_by'              => new sfValidatorInteger(array('required' => false)),
      'connected_products_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Product', 'required' => false)),
      'parameter_options_list'  => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'ParameterOption', 'required' => false)),
      'product_order_list'      => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'ProductOrder', 'required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorDoctrineUnique(array('model' => 'Product', 'column' => array('code')))
    );

    $this->widgetSchema->setNameFormat('product[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Product';
  }

  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['connected_products_list']))
    {
      $this->setDefault('connected_products_list', $this->object->ConnectedProducts->getPrimaryKeys());
    }

    if (isset($this->widgetSchema['parameter_options_list']))
    {
      $this->setDefault('parameter_options_list', $this->object->ParameterOptions->getPrimaryKeys());
    }

    if (isset($this->widgetSchema['product_order_list']))
    {
      $this->setDefault('product_order_list', $this->object->ProductOrder->getPrimaryKeys());
    }

  }

  protected function doSave($con = null)
  {
    $this->saveConnectedProductsList($con);
    $this->saveParameterOptionsList($con);
    $this->saveProductOrderList($con);

    parent::doSave($con);
  }

  public function saveConnectedProductsList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['connected_products_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->ConnectedProducts->getPrimaryKeys();
    $values = $this->getValue('connected_products_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('ConnectedProducts', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('ConnectedProducts', array_values($link));
    }
  }

  public function saveParameterOptionsList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['parameter_options_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->ParameterOptions->getPrimaryKeys();
    $values = $this->getValue('parameter_options_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('ParameterOptions', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('ParameterOptions', array_values($link));
    }
  }

  public function saveProductOrderList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['product_order_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->ProductOrder->getPrimaryKeys();
    $values = $this->getValue('product_order_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('ProductOrder', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('ProductOrder', array_values($link));
    }
  }

}
