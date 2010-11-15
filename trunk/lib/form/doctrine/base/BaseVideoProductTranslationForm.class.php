<?php

/**
 * VideoProductTranslation form base class.
 *
 * @method VideoProductTranslation getObject() Returns the current form's model object
 *
 * @package    jobeet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseVideoProductTranslationForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'              => new sfWidgetFormInputHidden(),
      'name'            => new sfWidgetFormTextarea(),
      'description'     => new sfWidgetFormTextarea(),
      'longdescription' => new sfWidgetFormTextarea(),
      'lang'            => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'id'              => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false)),
      'name'            => new sfValidatorString(array('max_length' => 1000, 'required' => false)),
      'description'     => new sfValidatorString(array('max_length' => 1000, 'required' => false)),
      'longdescription' => new sfValidatorString(array('max_length' => 9999, 'required' => false)),
      'lang'            => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'lang', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('video_product_translation[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'VideoProductTranslation';
  }

}
