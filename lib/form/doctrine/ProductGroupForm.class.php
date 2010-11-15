<?php

/**
 * ProductGroup form.
 *
 * @package    jobeet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class ProductGroupForm extends BaseProductGroupForm
{
	
	 public static $multiLangFields = array( 	'name' => array( 'title'=> 'Name', 'height' => 10 ),
												'description' => array('title' => 'Description', 'height' => 90),
	 											'meta_title' => array( 'title' => 'Meta title', 'height' => 10 ),
	 											'meta_description' => array('title' => 'Meta descrition', 'height' => 10),
	 											'meta_keywords' => array( 'title' => 'Meta keywords', 'height' => 10 ),
	 											'slug' => array( 'title' => 'URL', 'height' => 10 ),
	 											 );
  public function configure()
  {
    $this->useFields(array( 'id','title', 'picture' ));
    
    $this->widgetSchema['title'] = new sfWidgetFormInputText(  array(), array('size' => 25, 'class' => 'formInput') );
   	$this->widgetSchema['picture'] = new sfWidgetFormInputFileEditable( $this->getWidgetConfig( 'picture' ) );;
   	//$this->widgetSchema['picture_inactive'] = new sfWidgetFormInputFileEditable( $this->getWidgetConfig( 'picture_inactive' ) );;

   $this->widgetSchema['parameter'] =  new sfWidgetFormSelect(array(
  		'choices'  => array(
				'default' => 'Tavaline',
				'sales_top' => 'Müügi top',
				'index_page_group' => 'Avalehe tootegrupp'
			),

		),  array('size' => 1, 'class' => 'formInput') );


   // connections with structures
  	$this->widgetSchema['structure_connections'] =  new sfWidgetFormSelectMany(array(
  		'choices'  => Doctrine::getTable('NewsGroup')->findArrayOfApropriateStructureElements()
		),  array('name' => 'structure_connections[]', 'size' => 5, 'class' => 'formInput') );


	if( $this->getObject() ){

		$connections = array();
		foreach( $this->getObject()->getStructureProductGroup() as $rel ){
			$connections[] = $rel->structure_id;
		}
		$this->widgetSchema->setDefaults( array(
				'structure_connections' => $connections
		));

	}

    $this->setupMultilanguageFields();
    $this->setupConnectionsSelection();
    
    
  	$this->validatorSchema['picture_delete'] = new sfValidatorPass();
	$this->validatorSchema['parameter'] = new sfValidatorString();
    $this->validatorSchema['picture'] =  new sfValidatorFile( array( 
								    	'required' => false,
								    	'path' => sfConfig::get('sf_upload_dir').$this->getSubDir(),
								    	'mime_types' => 'web_images' ) );



    
//  	$this->validatorSchema['picture_inactive_delete'] = new sfValidatorPass();
//    $this->validatorSchema['picture_inactive'] =  new sfValidatorFile( array( 
//								    	'required' => false,
//								    	'path' => sfConfig::get('sf_upload_dir').$this->getSubDir(),
//								    	'mime_types' => 'web_images' ) );
  	 
  }
  
	public function getWidgetConfig( $pic ){
  		return array(
	  			'file_src' => $this->getFileSrc($pic),
	  			'is_image' => $this->isImage(),
				'edit_mode' => $this->getFileSrc($pic) ? true : false,
	  			'with_delete' => $this->withDelete(),
      			'template'  => $this->getTemplate(),
	  		
	  		);
	}
	
	
  public function getSubDir(){
  	return '/product_group/';
  }
  
  
  public function doSave($conn = null)
  {
  	
    if ( $this->getValue('picture')  && file_exists( sfConfig::get('sf_upload_dir') . $this->getObject()->getPicture() ) ){
      unlink( sfConfig::get('sf_upload_dir') . $this->getObject()->getPicture());
    }
  	parent::doSave($conn);
  }
  
  public function updateObject( $values = null ){
  	$obj = parent::updateObject( $values );
  	
  	if( $this->getValue('picture') )
    	$obj->setPicture($this->getSubDir() . $obj->getPicture());
    	
  	if( $this->getValue('picture_inactive') )
    	$obj->setPictureInactive($this->getSubDir() . $obj->getPictureInactive());
  	
  	return $obj;
  }
  
	public function getFileSrc( $pic ){
		
		$method = $pic == 'picture' ? 'getPicture' : 'getPictureInactive';
		
		if( !$this->isNew() && $this->getObject()->$method() ){
			return Picture::getInstance( '', $this->getObject()->$method(), '', 50, 50 )->getRawLink('resize');
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
		return true;
	}
	
	public function isImage(){
		return true;
	}
  
  
  
  public function setConnectionDefaults(){
  	if( $this->getObject() ){
		$selectedParamGroups = array();
		foreach( $this->getObject()->getProductGroupParameterGroups() as $rel ){
			$selectedParamGroups[] = $rel->paramgroup_id;	
		}
		$this->widgetSchema['connections']->setDefault( $selectedParamGroups );
			
	}
  }
  
  
  public function setupConnectionsSelection(){
   $this->widgetSchema['connections'] =  new sfWidgetFormSelectMany(array(
  		'choices'  => $this->getParameterGroupsSelection(),
		),  array('name' => 'connections[]', 'size' => 5, 'class' => 'formInput') );
		
	$this->setConnectionDefaults();
  }
  
  
  public function getParameterGroupsSelection(){
	$paramGroups = array();
	foreach( Doctrine::getTable('ParameterGroup')->findAll() as $pGroup ){
		if( $pGroup['title'] != 'root' )
			$paramGroups[$pGroup->getId()] = str_repeat('-> ', $pGroup->getLevel()-1) . $pGroup->title;
	}
	return $paramGroups;
  }
  
  
  public function setupMultilanguageFields(){
  	
  	$this->setI18Languages();
  	
  	foreach( $this->getLanguages() as $lang ){
  		foreach( self::$multiLangFields as $input => $info ){
			if($input == 'description')
				$this->widgetSchema[$lang][$input] = new sfWidgetFormTextarea(  array(), array('size' => 25, 'class' => 'formInput') );
			else
				$this->widgetSchema[$lang][$input] = new sfWidgetFormInputText(  array(), array('size' => 25, 'class' => 'formInput') );
		}
  	}


  	
  }
  
  
  public function setI18Languages(){
  	$this->embedI18n($this->getLanguages());
  }
  
  
  public function getLanguages(){
    	$languages = array();
  	foreach( Doctrine::getTable('Language')->findAll() as $lang ){
  		$languages[] = $lang->getAbr();
  	}
  	
  	return $languages;
  }
  
}
