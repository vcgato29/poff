<?php

/**
 * BannerGroup form.
 *
 * @package    jobeet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class BannerGroupForm extends BaseBannerGroupForm
{
  public function configure()
  {
  	$model = $this->getModelName();
  	$this->widgetSchema['type'] = new sfWidgetFormSelect(array(
  		'choices'  => $model::getTypes(),
		));	
  	
    $this->widgetSchema['connections'] =  new sfWidgetFormSelectMany(array(
  		'choices'  => Doctrine::getTable('BannerGroup')->findArrayOfApropriateStructureElements() 
		),  array('name' => 'connections[]', 'size' => 5, 'class' => 'formInput') );
		
		
    $this->widgetSchema['product_group_connections'] =  new sfWidgetFormSelectMany(array(
  		'choices'  => Doctrine::getTable('BannerGroup')->findArrayOfApropriateProductGroupElements() 
		),  array('name' => 'product_group_connections[]', 'size' => 5, 'class' => 'formInput') );
		
	
	if( $this->getObject() ){
		
		$connections = array();
		foreach( $this->getObject()->getStructureBannerGroups() as $rel ){
			$connections[] = $rel->structure_id;
		}
		
		$product_group_connections = array();
		foreach( $this->getObject()->getBannerGroups() as $rel ){
			$product_group_connections[] = $rel->product_group_id;
		}
		
		$this->widgetSchema->setDefaults( array(
				'connections' => $connections
			));
			
		$this->widgetSchema->setDefaults( array(
				'product_group_connections' => $product_group_connections
			));
	}

  }
}
