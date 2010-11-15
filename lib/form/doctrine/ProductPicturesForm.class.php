<?php

/**
 * ProductPictures form.
 *
 * @package    jobeet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class ProductPicturesForm extends BaseProductPicturesForm
{
  public static $parameters = array( 'default' => 'default','poster' => 'poster','director' => 'director' );

  public function configure()
  {
  	    unset( $this['original_filename'], $this['pri'] );



  		$this->widgetSchema['product_id'] = new sfWidgetFormInputHidden();
  		$this->widgetSchema['parameter'] = new sfWidgetFormSelect(array(
  		'choices'  => self::$parameters,
		));

      	$this->widgetSchema['file'] = new sfWidgetFormInputFile();
    	$this->validatorSchema['file'] = new sfValidatorFile(
    		array( 	'required' => false,
    				'mime_types' => 'web_images',
    				'max_size'=>'3145728', ) ); // 3mb

      	$this->languages = array();


	  	foreach( Doctrine::getTable('Language')->findAll() as $lang ){
	  		$this->languages[] = $lang->getAbr();
	  	}

    	$this->embedI18n( $this->languages );
  }

  public function processForm( $controller, $request )
  {
  	$bindArray = array( 'product_id' => $request->getParameter('product_id'), 'parameter' => 'default' );
  	$files = $request->getFiles();

  	$this->bind( $bindArray, array( 'file' => $files['Filedata'] ) );
  	$this->save();
  }


  protected function doSave($con = null)
  {

    $file = $this->getValue('file');
    if( $file ){

	    $filename = sha1($file->getOriginalName() ). $file->getExtension($file->getOriginalExtension());
	    $file->save(sfConfig::get('sf_upload_dir').'/product/'.$filename);
    }

    return parent::doSave($con);
  }


  public function updateObject($values = null)
  {
    $object = parent::updateObject($values);
    if( $object->getFile() ){
    	$object->setFile(str_replace(sfConfig::get('sf_upload_dir'), '', $object->getFile()));
    }


    if( !$object->original_filename && $this->getValue('file') ){
    	$object->original_filename = $this->getValue('file')->getOriginalName();
    }


    return $object;
  }

}
