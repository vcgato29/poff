<?php

/**
 * BannerGif
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    jobeet
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 6820 2009-11-30 17:27:49Z jwage $
 */
class BannerGif extends BaseBannerGif
{
	public function getEditForm(){
		return new BannerGifForm( $this );
	}
	
	public function getPictureImg(){
		return '-';
	}
}