<?php

/**
 * ProductFile form base class.
 *
 * @method ProductFile getObject() Returns the current form's model object
 *
 * @package    jobeet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseProductFileForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                => new sfWidgetFormInputHidden(),
      'file'              => new sfWidgetFormInputText(),
      'pri'               => new sfWidgetFormInputText(),
      'original_filename' => new sfWidgetFormInputText(),
      'parameter'         => new sfWidgetFormInputText(),
      'product_id'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Product'), 'add_empty' => false)),
    ));

    $this->setValidators(array(
      'id'                => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'file'              => new sfValidatorString(array('max_length' => 255)),
      'pri'               => new sfValidatorInteger(array('required' => false)),
      'original_filename' => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'parameter'         => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'product_id'        => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Product'))),
    ));

    $this->widgetSchema->setNameFormat('product_file[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'ProductFile';
  }

}
