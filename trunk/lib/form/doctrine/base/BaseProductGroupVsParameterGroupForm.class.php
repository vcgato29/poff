<?php

/**
 * ProductGroupVsParameterGroup form base class.
 *
 * @method ProductGroupVsParameterGroup getObject() Returns the current form's model object
 *
 * @package    jobeet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseProductGroupVsParameterGroupForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'prodgroup_id'  => new sfWidgetFormInputHidden(),
      'paramgroup_id' => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'prodgroup_id'  => new sfValidatorChoice(array('choices' => array($this->getObject()->get('prodgroup_id')), 'empty_value' => $this->getObject()->get('prodgroup_id'), 'required' => false)),
      'paramgroup_id' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('paramgroup_id')), 'empty_value' => $this->getObject()->get('paramgroup_id'), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('product_group_vs_parameter_group[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'ProductGroupVsParameterGroup';
  }

}
