<?php

/**
 * BannerGif form.
 *
 * @package    jobeet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class BannerGifForm extends BaseBannerGifForm
{
  /**
   * @see BannerForm
   */
  public function configure()
  {
    parent::configure();
  }
  
	public function getFileSrc(){
		
		return  '/' . basename( sfConfig::get('sf_upload_dir') )  .$this->getObject()->getPicture();
	}
}
