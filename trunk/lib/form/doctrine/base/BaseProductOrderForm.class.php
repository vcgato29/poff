<?php

/**
 * ProductOrder form base class.
 *
 * @method ProductOrder getObject() Returns the current form's model object
 *
 * @package    jobeet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseProductOrderForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'              => new sfWidgetFormInputHidden(),
      'public_user_id'  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('PublicUser'), 'add_empty' => false)),
      'order_number'    => new sfWidgetFormInputText(),
      'price_currency'  => new sfWidgetFormInputText(),
      'pay_in_currency' => new sfWidgetFormInputText(),
      'user_culture'    => new sfWidgetFormInputText(),
      'is_archived'     => new sfWidgetFormInputCheckbox(),
      'is_hidden'       => new sfWidgetFormInputCheckbox(),
      'invoice_mailed'  => new sfWidgetFormInputCheckbox(),
      'ticket'          => new sfWidgetFormInputText(),
      'ip'              => new sfWidgetFormInputText(),
      'buyer_email'     => new sfWidgetFormInputText(),
      'title'           => new sfWidgetFormInputText(),
      'notes'           => new sfWidgetFormInputText(),
      'status'          => new sfWidgetFormChoice(array('choices' => array('new' => 'new', 'paid' => 'paid', 'canceled' => 'canceled'))),
      'raw_response'    => new sfWidgetFormTextarea(),
      'type'            => new sfWidgetFormChoice(array('choices' => array('seb' => 'seb', 'swed' => 'swed', 'sampo' => 'sampo', 'nordea' => 'nordea'))),
      'created_at'      => new sfWidgetFormDateTime(),
      'updated_at'      => new sfWidgetFormDateTime(),
      'products_list'   => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Product')),
    ));

    $this->setValidators(array(
      'id'              => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'public_user_id'  => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('PublicUser'))),
      'order_number'    => new sfValidatorString(array('max_length' => 255)),
      'price_currency'  => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'pay_in_currency' => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'user_culture'    => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'is_archived'     => new sfValidatorBoolean(array('required' => false)),
      'is_hidden'       => new sfValidatorBoolean(array('required' => false)),
      'invoice_mailed'  => new sfValidatorBoolean(array('required' => false)),
      'ticket'          => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'ip'              => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'buyer_email'     => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'title'           => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'notes'           => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'status'          => new sfValidatorChoice(array('choices' => array(0 => 'new', 1 => 'paid', 2 => 'canceled'), 'required' => false)),
      'raw_response'    => new sfValidatorString(array('required' => false)),
      'type'            => new sfValidatorChoice(array('choices' => array(0 => 'seb', 1 => 'swed', 2 => 'sampo', 3 => 'nordea'), 'required' => false)),
      'created_at'      => new sfValidatorDateTime(),
      'updated_at'      => new sfValidatorDateTime(),
      'products_list'   => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Product', 'required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorDoctrineUnique(array('model' => 'ProductOrder', 'column' => array('order_number')))
    );

    $this->widgetSchema->setNameFormat('product_order[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'ProductOrder';
  }

  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['products_list']))
    {
      $this->setDefault('products_list', $this->object->Products->getPrimaryKeys());
    }

  }

  protected function doSave($con = null)
  {
    $this->saveProductsList($con);

    parent::doSave($con);
  }

  public function saveProductsList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['products_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->Products->getPrimaryKeys();
    $values = $this->getValue('products_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('Products', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('Products', array_values($link));
    }
  }

}
