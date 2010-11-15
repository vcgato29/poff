<?php

/**
 * BannerHtml form.
 *
 * @package    jobeet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class BannerHtmlForm extends BaseBannerHtmlForm
{
  /**
   * @see BannerForm
   */
  public function configure()
  {
    parent::configure();
  }
  
  
  public function getFileSrc(){
  	
  }
  
  public function getRenderTemplate()
  {
  	return 'html_form';
  }
}
