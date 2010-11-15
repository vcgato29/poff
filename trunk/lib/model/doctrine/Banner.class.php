<?php

/**
 * Banner
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    jobeet
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 6820 2009-11-30 17:27:49Z jwage $
 */
class Banner extends BaseBanner
{
	
	static function getTypes(){
		return array( 	'default' => 'Pilt', 
						'gif' => 'GIF pilt', 
						'flash' => 'Flash banner', 
						'html' => 'HTML code'
					);
	}
	
	public function getEditForm(){
		return new BannerForm( $this );
	}

	public function getPicture(){
		return $this->getFile();
	}

	public function getPictureImg(){
		$picturePath = Picture::getInstance( '', $this->getPicture(), '', 50, 50 )->getRawLink('resize');
		$file =<<<EOD
		<img src="${picturePath}" />			
EOD;
		return $file;
	}
	
	public function getBannerGroupName(){
		return $this->BannerGroup->name;
	}
	
	
	public function render(){

		$picturePath = Picture::getInstance( '', $this->getPicture(), '', $this->getRenderWidth(), $this->getRenderHeight() )->getRawLink('resize');
		$content =<<<EOF
		<a href="{$this->getLink()}"><img src="${picturePath}" /></a>		
EOF;
		return $content;
	}
	
	public function getMediaWithSize( $width, $height ){
		return Picture::getInstance( '', $this->getPicture(), '', $width, $height )->getRawLink('resize');
	}
	
	
	public function getRenderWidth(){
		if( !$this->width ){
			return $this->BannerGroup->width;
		}else{
			return $this->width;
		}
	}
	
	public function getRenderHeight(){
		if( !$this->width ){
			return $this->BannerGroup->height;
		}else{
			return $this->height;
		}
	}
	
	
	
	
	
	
	public function getPriForm(){
		$form =<<<EOD
		<input type="text" size=2 style="background-color:#EFEFEF;border:1px solid #777777;text-align: center; " name="product_pri[{$this->id}]" value="{$this->pri}" />	
EOD;
	return $form;
	}
}