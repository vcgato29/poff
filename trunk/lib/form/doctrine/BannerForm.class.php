<?php 

/**
 * Banner form. 
 *
 * @package    jobeet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class BannerForm extends BaseBannerForm
{
	

  public function configure()
  {
  	
	unset( $this['pri'] );
  	
  	$this->widgetSchema['file'] = new sfWidgetFormInputFileEditable( $this->getWidgetConfig() );
  	$this->widgetSchema['link'] = new sfWidgetFormInput( array(), array('size' => 55) );
  	$model = $this->getModelName();
  	$this->widgetSchema['type'] = new sfWidgetFormSelect(array(
  		'choices'  => $model::getTypes(),
		));	
  	
  	
  	$this->validatorSchema['file_delete'] = new sfValidatorPass();
    $this->validatorSchema['file'] =  new sfValidatorFile( array( 
								    	'required' => false,
								    	'path' => sfConfig::get('sf_upload_dir').$this->getSubDir(),
								    	'mime_types' => 'web_images' ) );
    
	 if( !$this->isNew() )
  		unset($this['type']);    
    
    
  }
  
  public function getSubDir(){
  	return '/banner/';
  }
  
  
  
  
	public function getWidgetConfig(){
  		return array(
	  			'file_src' => $this->getFileSrc(),
	  			'is_image' => $this->isImage(),
				'edit_mode' => !$this->isNew(),
	  			'with_delete' => $this->withDelete(),
      			'template'  => $this->getTemplate(),
	  		
	  		);
	}
	
	
	public function getFileSrc(){
		
		if( !$this->isNew() ){
			return Picture::getInstance( '', $this->getObject()->getPicture(), '', 50, 50 )->getRawLink('resize');
		}else{
			return '';
		}
			
	}
	 
	
	public function getTemplate(){
		return '<div> <br />
      				<div>%file%</div>
      				<br />%input%<br />
      				<div class="formLabel">%delete% %delete_label%</div>
      			</div>';
	}
	
	public function withDelete(){
		return false;
	}
	
	public function isImage(){
		return true;
	}

  
  
  public function doSave($conn = null)
  {
  	
    if ( $this->getValue('picture')  && file_exists( sfConfig::get('sf_upload_dir') . $this->getObject()->getPicture() ) ){
      unlink( sfConfig::get('sf_upload_dir') . $this->getObject()->getPicture());
    }
  	parent::doSave($conn);
  }
  
  public function updateObject($values = null)
  {

    $object = parent::updateObject( $values );
    if( $this->getValue('file') )
    	$object->setFile($this->getSubDir() . $object->getFile());
    return $object;
  }
  
  public function getRenderTemplate()
  {
  	return 'form';
  }

  
  
}
