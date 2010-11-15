<?php

/**
 * Structure form.
 *
 * @package    jobeet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class StructureForm extends BaseStructureForm
{
  public function configure()
  {
  	
  	parent::configure();
  	

  	
	 $this->useFields( $this->getUsedFields() );
	 $this->setWidgets( $this->getPreparedWidgets() );	
    
     $this->widgetSchema['picture'] = new sfWidgetFormInputFileEditable(
  		 array(
	  			'file_src' => $this->getFileSrc(),
	  			'is_image' => true,
				'edit_mode' => !$this->isNew(),
	  			'with_delete' => true,
	  		
	  		));
	  		

	
	 //$this->widgetSchema['isHidden']->setDefault(0);
	 
    $this->validatorSchema['picture'] = new sfValidatorFile( array( 'required' => false ) );
    $this->validatorSchema['picture_delete'] = new sfValidatorPass();
    
    $this->widgetSchema['isHidden'] = new sfWidgetFormInputCheckbox();

  }
  
  public function getUsedFields(){
  	return array('title', 'slug', 'description', 'pageTitle', 
	 	'isHidden', 'metaDescription', 'metaKeywords','id', 'parentID', 'lang', 'inherits_layout', 'content', 'layout', 'type', 'picture', 'parameter' );
  }
  
  public function getPreparedWidgets(){
  	return array(
      	'title'   => new sfWidgetFormInputText( array(), array('size' => 25, 'class' => 'formInput')),
	 	'slug'   => new sfWidgetFormInputText(  array(), array(  'size' => 25, 'class' => 'formInput') ),
     	'description' => new sfWidgetFormInputText(  array(), array('size' => 25, 'class' => 'formInput') ),
	 	'content' => new sfWidgetFormTextarea(  array(), array('size' => 25, 'class' => 'formInput') ),
	 	'pageTitle'   => new sfWidgetFormInputText(  array(), array('size' => 25, 'class' => 'formInput') ),
	 	'metaDescription'   => new sfWidgetFormInputText(  array(), array('size' => 25, 'class' => 'formInput') ),
	 	'metaKeywords' => new sfWidgetFormInputText(  array(), array('size' => 25, 'class' => 'formInput') ),
	 	
	 	'inherits_layout'   => new sfWidgetFormInputCheckbox(),
	 	'id' => new sfWidgetFormInputHidden(),
	 	'lang' => new sfWidgetFormInputHidden(),
	 	'parentID' => new sfWidgetFormInputHidden(),
	 	'type' => new sfWidgetFormSelect(array( 'choices'  => $this->getTypes() ), array( 'class' => 'formInput' ) ),
  		'parameter' => new sfWidgetFormSelect(array( 'choices'  => $this->getParameters() ), array( 'class' => 'formInput' ) ), 
		'layout' => new sfWidgetFormSelect(array( 'choices'  => $this->getLayouts() ), array( 'class' => 'formInput' )  )  
	 );
	 
	     
  }
  
  
  public function getTypes(){
  	return Structure::getFormAvailableTypes();
  }
  
  public function getParameters(){
  	return Structure::getFormAvailableParameters();
  }
  
  
  public function getLayouts(){
  	return array(
  			'layout' => 'Standard',
			'layout_article' => 'Artikli lehe layout'
  		); 
  }
  
  
	public function processForm(sfWebRequest $request, $controller )
	{
		
		$bindArray = $this->getArrayToBind( $request );


	       
	       if( $request->getParameter('parentID') > 0 ){
	       		$bindArray['parentID'] = $request->getParameter('parentID');
	       }else{
	       		$bindArray['parentID'] = Doctrine::getTable('Structure')->getLangNode( $request->getParameter('lang') )->id;
	       }

	       	$controller->forwardSecureUnless( 
					Doctrine::getTable('Structure')
				->find( $bindArray['id'] ? $bindArray['id'] : $bindArray['parentID'] )->isPermittedForUser( $controller->getUser(), myUser::PERM_RW ) );

	       
		
	  $this->bind( $bindArray, $request->getFiles() );
	 
	  
	  if ($this->isValid())
	  {
	  	$job = $this->save();
	  	$struct1 = $job->getParent();
	  	$job->setLang($struct1->getLang());
	  	$job->getNode()->insertAsLastChildOf( $struct1 );
	    return $job;
	  }else
		return false;

	}
	
	public function getArrayToBind( $request ){
		return array(	
					'id' => $request->getParameter('id'),
	       			'title' => $request->getParameter('title'),
                	'slug' => $request->getParameter('slug') ,
					'type' =>  $request->getParameter('type'),
					'picture_delete' => $request->getParameter('picture_delete') , 
	       			'pageTitle' => $request->getParameter('pageTitle') ,
	       			'description' => $request->getParameter('description'),
					'content' => $request->getParameter('content'),
	       			'isHidden' => $request->getParameter('isHidden'),
	       			'_csrf_token' => $request->getParameter('_csrf_token'),
	       			'metaDescription'  => $request->getParameter('metaDescription'),
	       			'metaKeywords' => $request->getParameter('metaKeywords'),
					'inherits_layout' => $request->getParameter('inherits_layout'),
					'layout' => $request->getParameter('layout'),
					'parameter' => $request->getParameter('parameter'),
					'lang'			=> $_POST['lang']
	       );
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
	    $file->save(sfConfig::get('sf_upload_dir').'/struct/'.$filename);
    }
 
    return parent::doSave($con);
  }
  
  public function updateObject($values = null)
  {
    $object = parent::updateObject($values);
    $object->setPicture(str_replace(sfConfig::get('sf_upload_dir'), '', $object->getPicture()));
    return $object;
  }
  
  public function getFileSrc(){
  	if( $this->isNew() ){
  		return false;
  	}else if( $this->getObject()->getPicture() ) {
  		return Picture::getInstance( '', $this->getObject()->getPicture(), '', 50, 50 )->getRawLink('resize'); 
  	}
  }
  
  
	
}
