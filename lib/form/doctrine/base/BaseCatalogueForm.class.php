<?php

/**
 * Catalogue form base class.
 *
 * @method Catalogue getObject() Returns the current form's model object
 *
 * @package    jobeet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseCatalogueForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'cat_id'        => new sfWidgetFormInputHidden(),
      'name'          => new sfWidgetFormInputText(),
      'source_lang'   => new sfWidgetFormInputText(),
      'target_lang'   => new sfWidgetFormInputText(),
      'date_created'  => new sfWidgetFormInputText(),
      'date_modified' => new sfWidgetFormInputText(),
      'author'        => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'cat_id'        => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'cat_id', 'required' => false)),
      'name'          => new sfValidatorString(array('max_length' => 63, 'required' => false)),
      'source_lang'   => new sfValidatorString(array('max_length' => 63, 'required' => false)),
      'target_lang'   => new sfValidatorString(array('max_length' => 63, 'required' => false)),
      'date_created'  => new sfValidatorInteger(array('required' => false)),
      'date_modified' => new sfValidatorInteger(array('required' => false)),
      'author'        => new sfValidatorString(array('max_length' => 63, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('catalogue[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Catalogue';
  }

}
