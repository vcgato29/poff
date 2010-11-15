<?php

/**
 * BannerGroupVsProduct form base class.
 *
 * @method BannerGroupVsProduct getObject() Returns the current form's model object
 *
 * @package    jobeet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseBannerGroupVsProductForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'banner_group_id' => new sfWidgetFormInputHidden(),
      'product_id'      => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'banner_group_id' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('banner_group_id')), 'empty_value' => $this->getObject()->get('banner_group_id'), 'required' => false)),
      'product_id'      => new sfValidatorChoice(array('choices' => array($this->getObject()->get('product_id')), 'empty_value' => $this->getObject()->get('product_id'), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('banner_group_vs_product[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'BannerGroupVsProduct';
  }

}
