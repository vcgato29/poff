<?php

/**
 * BannerFlash form base class.
 *
 * @method BannerFlash getObject() Returns the current form's model object
 *
 * @package    jobeet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedInheritanceTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseBannerFlashForm extends BannerForm
{
  protected function setupInheritance()
  {
    parent::setupInheritance();

    $this->widgetSchema->setNameFormat('banner_flash[%s]');
  }

  public function getModelName()
  {
    return 'BannerFlash';
  }

}
