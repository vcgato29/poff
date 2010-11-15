<?php

/**
 * Product form.
 *
 * @package    jobeet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class ProductForm extends BaseProductForm
{
	public $languages = array();
	
	public static $multiLangFields = array( 	'name' => array( 'title'=> 'Name', 'class' => 'formInput' ),
												'language' => array( 'title'=> 'Language', 'class' => 'formInput' ),
												'synopsis' => array( 'title'=> 'Synopsis', 'class' => 'formInput multilang' ),
												'producer_description' => array( 'title'=> 'Producer description', 'class' => 'formInput multilang' ),
												'critics' => array( 'title'=> 'Critics', 'class' => 'formInput multilang' ),
												'country'=> array( 'title'=> 'Country', 'class' => 'formInput' ),
												 
	 );
  public function configure()
  {
  	unset($this['created_at']); 
  	unset($this['updated_at']);
	unset($this['updated_by']);
	unset($this['created_by']);
  	unset($this['pri']);
	unset($this['vatrate']);
  	unset($this['connected_products_list']);
	unset($this['parameter_options_list']);
	unset($this['product_order_list']);
	unset($this['parameter']);


	$this->widgetSchema['trailer_link'] = new sfWidgetFormInputText();
	$this->widgetSchema['original_title'] = new sfWidgetFormInputText();
	
  	$this->configureLanguages();
  	
  	
  	# product groups
  	$prodGroups = $this->getProductGroupsLedder();

	
   $this->widgetSchema['connections'] =  new sfWidgetFormSelectMany(array(
  		'choices'  => $prodGroups,
		),  array('name' => 'connections[]', 'size' => 10, 'class' => 'formInput') );



	
	if( $this->getObject() ){
		$selectedprodGroups = array();
		foreach( $this->getObject()->getProductGroups() as $rel ){
			$selectedprodGroups[] = $rel->group_id;	
		}
		$this->widgetSchema['connections']->setDefault( $selectedprodGroups );
			
	}
	 
	# connected products
	$this->widgetSchema['connected_products'] = new sfWidgetFormTextarea(array(),array('name' => 'connected_products', 'rows'=> 2, 'cols' => '30', 'class' => 'formInput'));

	
	
  }

  
  public function configureLanguages(){
  	
  	$this->embedI18n( $this->getLanguagesAbr() );  
  	$this->languages = $this->getLanguages();

	
  	foreach($this->getLanguagesAbr() as $abr){
  		$this->widgetSchema[$abr]['description'] = new sfWidgetFormTextarea();
		$this->widgetSchema[$abr]['language'] = new sfWidgetFormInputText();
  	}

	foreach(self::$multiLangFields as $title => $field)
		foreach($this->getLanguagesAbr() as $abr)
			$this->widgetSchema[$abr][$title]->setAttribute ('class', $field['class']);
	
  }
  
  
  public function getLanguagesAbr(){
  	    $languages = array();
  	foreach( $this->getLanguages() as $lang ){
  		$languages[] = $lang['abr'];
  	}
  	
  	return $languages;
  }
  
  public function getLanguages()
  {
  	return Doctrine::getTable('Language')->findAll();
  }
  
  
  public function getProductGroupsLedder(){
  	
  	$prodGroups = array();
  	
	foreach( Doctrine::getTable('ProductGroup')->findAll() as $pGroup ){
		if( $pGroup->title != 'root' )
			$prodGroups[$pGroup->getId()] = str_repeat('-> ', $pGroup->getLevel()-1) . $pGroup->title;
	}

	return $prodGroups;
  	
  }

	protected function getWidgetConfig(){
  		return array(
	  			'file_src' => $this->getFileSrc(),
	  			'is_image' => $this->isImage(),
				'edit_mode' => $this->getFileSrc(),
	  			'with_delete' => $this->withDelete(),
      			'template'  => $this->getTemplate(),
	  		);
	}


	protected function getFileSrc(){

		if( !$this->isNew() && $this->getObject()->getBrandPicture() ){
			return @myPicture::getInstance($this->getObject()->getBrandPicture())
					->resize(50,0,true,true)->url();
		}

		return false;


	}


	protected function getTemplate(){
		return '<div>
      				%input%
					<div style="clear:both"></div>
					<div style="float:left">
					%file%
					</div>
					<div class="formLabel">%delete% delete</div>
					<br />
					<br />
      			</div>';
	}

	protected function withDelete(){
		return true;
	}

	protected function isImage(){
		return true;
	}


  public function doSave($conn = null)
  {

    if ( $this->getValue('brand_picture')  && file_exists( sfConfig::get('sf_upload_dir') . $this->getObject()->getBrandPicture() ) ){
      unlink( sfConfig::get('sf_upload_dir') . $this->getObject()->getBrandPicture());
    }
  	parent::doSave($conn);
  }

  public function updateObject($values = null)
  {

    $object = parent::updateObject( $values );
    if( $this->getValue('brand_picture') )
    	$object->setBrandPicture('/product/' . $object->getBrandPicture());
    return $object;
  }
  
  
}
