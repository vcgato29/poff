<?php

/**
 * TransUnit form base class.
 *
 * @method TransUnit getObject() Returns the current form's model object
 *
 * @package    jobeet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseTransUnitForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'msg_id'        => new sfWidgetFormInputHidden(),
      'cat_id'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Catalogue'), 'add_empty' => false)),
      'id'            => new sfWidgetFormInputText(),
      'source'        => new sfWidgetFormTextarea(),
      'target'        => new sfWidgetFormTextarea(),
      'comments'      => new sfWidgetFormInputText(),
      'type'          => new sfWidgetFormInputText(),
      'date_created'  => new sfWidgetFormInputText(),
      'date_modified' => new sfWidgetFormInputText(),
      'author'        => new sfWidgetFormInputText(),
      'translated'    => new sfWidgetFormInputText(),
      'variable_id'   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('TransUnitVariable'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'msg_id'        => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'msg_id', 'required' => false)),
      'cat_id'        => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Catalogue'), 'required' => false)),
      'id'            => new sfValidatorString(array('max_length' => 63, 'required' => false)),
      'source'        => new sfValidatorString(array('max_length' => 65532)),
      'target'        => new sfValidatorString(array('max_length' => 65532, 'required' => false)),
      'comments'      => new sfValidatorString(array('max_length' => 63, 'required' => false)),
      'type'          => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'date_created'  => new sfValidatorInteger(array('required' => false)),
      'date_modified' => new sfValidatorInteger(array('required' => false)),
      'author'        => new sfValidatorString(array('max_length' => 63, 'required' => false)),
      'translated'    => new sfValidatorInteger(array('required' => false)),
      'variable_id'   => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('TransUnitVariable'), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('trans_unit[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'TransUnit';
  }

}
