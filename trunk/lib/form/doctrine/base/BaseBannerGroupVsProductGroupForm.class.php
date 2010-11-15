<?php

/**
 * BannerGroupVsProductGroup form base class.
 *
 * @method BannerGroupVsProductGroup getObject() Returns the current form's model object
 *
 * @package    jobeet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseBannerGroupVsProductGroupForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'banner_group_id'  => new sfWidgetFormInputHidden(),
      'product_group_id' => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'banner_group_id'  => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'banner_group_id', 'required' => false)),
      'product_group_id' => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'product_group_id', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('banner_group_vs_product_group[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'BannerGroupVsProductGroup';
  }

}
