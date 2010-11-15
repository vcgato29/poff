<?php

/**
 * NewItem form.
 *
 * @package    jobeet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class NewItemForm extends BaseNewItemForm
{
  public function configure()
  {
  	
  	unset( $this['pri'] );
  	
  	$this->widgetSchema['content'] = new sfWidgetFormTextarea(  array(), array('size' => 25, 'class' => 'ckeditor', 'id'=> 'content') );
  	$this->widgetSchema['active_start'] = new sfWidgetFormInput(  array(), array('size' => 25, 'id'=> 'active_start') );
  	$this->widgetSchema['active_end'] = new sfWidgetFormInput(  array(), array('size' => 25, 'id'=> 'active_end') );
  	$this->widgetSchema['picture'] = new sfWidgetFormInputFileEditable(
  		 array(
	  			'file_src' => $this->getFileSrc(),
	  			'is_image' => true,
				'edit_mode' => !$this->isNew(),
	  			'with_delete' => true,
	  		
	  		)
  	);
  	
  	
	$model = $this->getModelName();
	$types = $model::getTypes();
  	 $this->widgetSchema['type'] =  new sfWidgetFormSelect(array(
  		'choices'  => $types
		) ); 
  	
	
    $this->validatorSchema['picture'] = new sfValidatorFile( array( 'required' => false ) );
    $this->validatorSchema['picture_delete'] = new sfValidatorPass();
  }
  
  public function getFileSrc(){
  	if( $this->isNew() ){
  		return false;
  	}else if( $this->getObject()->getPicture() ) {
  		return Picture::getInstance( '', $this->getObject()->getPicture(), '', 50, 50 )->getRawLink('resize'); 
  	}
  }
  
  protected function doSave($con = null)
  {

  	
    if ( ( file_exists( sfConfig::get('sf_upload_dir') . $this->getObject()->getPicture() ) && $this->getValue('picture_delete') ) ||
    		( $this->getValue('picture') && file_exists( sfConfig::get('sf_upload_dir') . $this->getObject()->getPicture() ) ) ){
      unlink( sfConfig::get('sf_upload_dir') . $this->getObject()->getPicture());
    }
 
    $file = $this->getValue('picture');
    if( $file ){
	    $filename = sha1($file->getOriginalName()).$file->getExtension($file->getOriginalExtension());
	    $file->save(sfConfig::get('sf_upload_dir').'/news/'.$filename);
    }
 
    return parent::doSave($con);
  }
  
  public function updateObject($values = null)
  {
    $object = parent::updateObject($values);
    $object->setPicture(str_replace(sfConfig::get('sf_upload_dir'), '', $object->getPicture()));
    return $object;
  }
  
}
