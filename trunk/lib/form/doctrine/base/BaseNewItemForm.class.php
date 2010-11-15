<?php

/**
 * NewItem form base class.
 *
 * @method NewItem getObject() Returns the current form's model object
 *
 * @package    jobeet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseNewItemForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'           => new sfWidgetFormInputHidden(),
      'name'         => new sfWidgetFormInputText(),
      'description'  => new sfWidgetFormTextarea(),
      'content'      => new sfWidgetFormTextarea(),
      'active_start' => new sfWidgetFormDateTime(),
      'active_end'   => new sfWidgetFormDateTime(),
      'source'       => new sfWidgetFormInputText(),
      'tags'         => new sfWidgetFormTextarea(),
      'group_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('NewsGroup'), 'add_empty' => false)),
      'pri'          => new sfWidgetFormInputText(),
      'picture'      => new sfWidgetFormInputText(),
      'type'         => new sfWidgetFormInputText(),
      'slug'         => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'           => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false)),
      'name'         => new sfValidatorString(array('max_length' => 255)),
      'description'  => new sfValidatorString(array('max_length' => 1000, 'required' => false)),
      'content'      => new sfValidatorString(array('max_length' => 9999, 'required' => false)),
      'active_start' => new sfValidatorDateTime(array('required' => false)),
      'active_end'   => new sfValidatorDateTime(array('required' => false)),
      'source'       => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'tags'         => new sfValidatorString(array('max_length' => 1000, 'required' => false)),
      'group_id'     => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('NewsGroup'))),
      'pri'          => new sfValidatorInteger(array('required' => false)),
      'picture'      => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'type'         => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'slug'         => new sfValidatorString(array('max_length' => 255, 'required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorDoctrineUnique(array('model' => 'NewItem', 'column' => array('slug')))
    );

    $this->widgetSchema->setNameFormat('new_item[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'NewItem';
  }

}
