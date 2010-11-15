<?php

/**
 * BannerGroup filter form.
 *
 * @package    jobeet
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class BannerGroupFormFilter extends BaseBannerGroupFormFilter
{
  public function configure()
  {
  	
	$ar = array(0 => '--all--') + Doctrine::getTable('BannerGroup')->findArrayOfApropriateStructureElements();
	
	$this->widgetSchema['relatives'] = new sfWidgetFormSelect(array('choices' => 
		$ar ) );
	$this->validatorSchema['relatives'] = new sfValidatorPass(array('required' => false));
  }
  
    protected function addRelativesColumnQuery(Doctrine_Query $query, $field, $values) {
    	
    	if( $values )
			$query->innerJoin( 'r.StructureBannerGroups sbg WITH sbg.structure_id = ? ', $values );
			
		
    }
	public function getFields()
	{
		return array_merge( parent::getFields(), array('relatives' => 'Text', //using default search because it is on object1 and this class extends Object1Filter
				) );
	}
}
