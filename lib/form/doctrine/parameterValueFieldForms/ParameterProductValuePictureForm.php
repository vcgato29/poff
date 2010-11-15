<?php

class ParameterProductValuePictureForm extends ParameterProductValueFileForm{
	
	public function configure(){
	    parent::configure();
	}

	public function isRequired(){
		return false;
	}
	
	
	public function getMimeTypes(){
		return 'web_images';
	}
	
	
	public function getUploadDir(){
		return sfConfig::get('sf_upload_dir') . $this->getUploadSubDir();
	}
	
	public function getUploadSubDir(){
		return '/productparameter/';
	}

	
	public function withDelete(){
		return true;
	}
	
	public function isImage(){
		return true;
	}
	
	
	public function getFileSrc(){
		return $this->getObject()->getCommonValue() 
						? Picture::getInstance( '', $this->getObject()->getCommonValue(), '', 50, 50 )
								->getRawLink('resize')
						: '';
	}
	
	public function getFileSrcForLang( $lang ){
		return $this->getObject()->Translation[$lang]->value 
						? Picture::getInstance( '', $this->getObject()->Translation[$lang]->value, '', 50, 50 )
								->getRawLink('resize')
						: '';
	}
	
}