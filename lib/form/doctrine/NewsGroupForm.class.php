<?php

/**
 * NewsGroup form.
 *
 * @package    jobeet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class NewsGroupForm extends BaseNewsGroupForm
{
  public function configure()
  {
  	unset( $this['pri'] );
  	
  	 $this->widgetSchema['link_to_struct'] =  new sfWidgetFormSelect(array(
  		'choices'  => Doctrine::getTable('NewsGroup')->findArrayOfApropriateStructureElements()
		),  array( 'size' => 5, 'class' => 'formInput') );
		
		
		$model = $this->getModelName();
		$types = $model::getTypes();
  	 $this->widgetSchema['type'] =  new sfWidgetFormSelect(array(
  		'choices'  => $types
		),  array( 'size' => 1, 'class' => 'formInput') );
		
  	$this->widgetSchema['connections'] =  new sfWidgetFormSelectMany(array(
  		'choices'  => Doctrine::getTable('NewsGroup')->findArrayOfApropriateStructureElements()
		),  array('name' => 'connections[]', 'size' => 5, 'class' => 'formInput') );
		
		
	if( $this->getObject() ){
		
		$connections = array();
		foreach( $this->getObject()->getStructureNewsGroup() as $rel ){
			$connections[] = $rel->structure_id;
		}
		$this->widgetSchema->setDefaults( array(
				'connections' => $connections
			));
		
	}
  }
}
