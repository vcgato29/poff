<?php

/**
 * ProductExemplarVsPublicUser form base class.
 *
 * @method ProductExemplarVsPublicUser getObject() Returns the current form's model object
 *
 * @package    jobeet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseProductExemplarVsPublicUserForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'exemplar_id' => new sfWidgetFormInputHidden(),
      'user_id'     => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'exemplar_id' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('exemplar_id')), 'empty_value' => $this->getObject()->get('exemplar_id'), 'required' => false)),
      'user_id'     => new sfValidatorChoice(array('choices' => array($this->getObject()->get('user_id')), 'empty_value' => $this->getObject()->get('user_id'), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('product_exemplar_vs_public_user[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'ProductExemplarVsPublicUser';
  }

}
