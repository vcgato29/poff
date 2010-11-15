<?php

/**
 * BannerHtml form base class.
 *
 * @method BannerHtml getObject() Returns the current form's model object
 *
 * @package    jobeet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedInheritanceTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseBannerHtmlForm extends BannerForm
{
  protected function setupInheritance()
  {
    parent::setupInheritance();

    $this->widgetSchema->setNameFormat('banner_html[%s]');
  }

  public function getModelName()
  {
    return 'BannerHtml';
  }

}
