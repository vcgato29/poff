<?php

/**
 * Parameter form.
 *
 * @package    jobeet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class ParameterForm extends BaseParameterForm
{
	public $languages = array();
	public $multiLangFields = array( 'name' );
	public $types = array( 	'SINGLE_OPTIONS' => 'Single selection', 
							'MANY_OPTIONS' => 'Multiple selection', 
							'TEXTFIELD' => 'text field', 
							'TEXTBOX' => 'text box', 
							'PICTURE' => 'Picture', 
							'FILE' => 'File', 
							'HTML' => 'HTML',
                                                        'ARTICLE' => 'ARTICLE'); 
  public function configure()
  {
  	
  	unset( $this['created_at'] );
  	unset( $this['updated_at'] );
  	
  	# parameter types
  	$this->widgetSchema['type'] = new sfWidgetFormSelect(array(
  		'choices'  => $this->getTypes()
		),  array( 'size' => 5, 'class' => 'formInput') );
  	

	# group choices
	$groupChoices = array();
	foreach( $this->widgetSchema['group_id']->getChoices() as $index => $choice ){
		if( $choice == 'root' || !$choice )continue;
		$groupChoices[$index] = 
			str_repeat('-> ', Doctrine::getTable('ParameterGroup')->find($index)->getLevel() - 1 ) .
		
			Doctrine::getTable('ParameterGroup')->find($index)->getTitle();
	}
	
	
	//array_shift($groupChoices);
	$this->widgetSchema['group_id']= new sfWidgetFormSelect( array (
  		'choices'  => $groupChoices
		),  array( 'size' => 5, 'class' => 'formInput') );
	
		
	# languages
    $languages = array();
  	foreach( Doctrine::getTable('Language')->findAll() as $lang ){
  		$languages[] = $lang->getAbr();
  	}
  	$this->embedI18n( $languages );
  	$this->languages = $this->getLanguages();

  	
 
  }
  
  public function getLanguages(){
  	return Doctrine::getTable('Language')->findAll();
  }
  
  public function getTypes(){
  	return $this->types;
  }
  
  

  
  
  public function getSubTemplate()
  {
  	return false;
  }
}
