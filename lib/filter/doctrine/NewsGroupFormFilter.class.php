<?php

/**
 * NewsGroup filter form.
 *
 * @package    jobeet
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class NewsGroupFormFilter extends BaseNewsGroupFormFilter
{
  public function configure()
  {
	$this->widgetSchema['name'] = new sfWidgetFormFilterInput(array('with_empty' => false));

	$ar = Doctrine::getTable('NewsGroup')->findArrayOfApropriateStructureElements();
	$ar[0] = '--all--';
	
	$this->widgetSchema['relatives'] = new sfWidgetFormSelect(array('choices' => 
		array_reverse($ar, true) ) );
	$this->validatorSchema['relatives'] = new sfValidatorPass(array('required' => false));
	
  } 

    protected function addRelativesColumnQuery(Doctrine_Query $query, $field, $values) {
    	if( $values[0] )
			$query->innerJoin( 'r.StructureNewsGroup sng WITH sng.structure_id = ? ', $values[0] );
    }
	public function getFields()
	{
		return array_merge( parent::getFields(), array('relatives' => 'Text', //using default search because it is on object1 and this class extends Object1Filter
				) );
	}
}
