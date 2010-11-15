<?php

/**
 * BannerFlash form.
 *
 * @package    jobeet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class BannerFlashForm extends BaseBannerFlashForm
{
  /**
   * @see BannerForm
   */
  public function configure()
  {
    parent::configure();
    $this->validatorSchema['file'] =  new sfValidatorFile( array( 
								    	'required' => false,
								    	'path' => sfConfig::get('sf_upload_dir').$this->getSubDir(),
								    	'mime_types' => array( 'application/x-shockwave-flash' ) ) );
  }
  
  public function getRenderTemplate(){
  	return 'flash_form';
  }
  
  public function isImage(){
  	return false;
  }
  
	public function getFileSrc(){
		return '';	
	}
}
