<?php

/**
 * BannerHtml
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    jobeet
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 6820 2009-11-30 17:27:49Z jwage $
 */
class BannerHtml extends BaseBannerHtml
{

	public function getEditForm(){
		return new BannerHtmlForm( $this );
	}
	
	public function renderForEditForm(){
		return $this->content;
	}
	
	public function getPictureImg(){
		return '-';
	}
	
}