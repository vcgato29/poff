<?php

/**
 * Currency form base class.
 *
 * @method Currency getObject() Returns the current form's model object
 *
 * @package    jobeet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseCurrencyForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'          => new sfWidgetFormInputHidden(),
      'name'        => new sfWidgetFormInputText(),
      'factor'      => new sfWidgetFormInputText(),
      'symbol'      => new sfWidgetFormInputText(),
      'abbr'        => new sfWidgetFormInputText(),
      'prefix'      => new sfWidgetFormInputCheckbox(),
      'language_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Language'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'id'          => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false)),
      'name'        => new sfValidatorString(array('max_length' => 255)),
      'factor'      => new sfValidatorNumber(array('required' => false)),
      'symbol'      => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'abbr'        => new sfValidatorString(array('max_length' => 255)),
      'prefix'      => new sfValidatorBoolean(array('required' => false)),
      'language_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Language'), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('currency[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Currency';
  }

}
