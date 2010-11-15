<?php

/**
 * ProductExemplar form base class.
 *
 * @method ProductExemplar getObject() Returns the current form's model object
 *
 * @package    jobeet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseProductExemplarForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'             => new sfWidgetFormInputHidden(),
      'code'           => new sfWidgetFormInputText(),
      'location'       => new sfWidgetFormInputText(),
      'scheduled_time' => new sfWidgetFormDateTime(),
      'product_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Product'), 'add_empty' => false)),
      'buy_link'       => new sfWidgetFormInputText(),
      'cinema'         => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'             => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'code'           => new sfValidatorString(array('max_length' => 255)),
      'location'       => new sfValidatorString(array('max_length' => 255)),
      'scheduled_time' => new sfValidatorDateTime(array('required' => false)),
      'product_id'     => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Product'))),
      'buy_link'       => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'cinema'         => new sfValidatorString(array('max_length' => 255)),
    ));

    $this->widgetSchema->setNameFormat('product_exemplar[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'ProductExemplar';
  }

}
