<?php

/**
 * NewItem filter form.
 *
 * @package    jobeet
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class NewItemFormFilter extends BaseNewItemFormFilter
{
  public function configure()
  {
	$ar = Doctrine::getTable('NewsGroup')->findArrayOfApropriateStructureElements();
	$ar[0] = '--all--';
	
	
	$this->widgetSchema['slug'] = new sfWidgetFormFilterInput(array('with_empty' => false));
	$this->widgetSchema['slug']->setLabel('URL');
	
	$this->widgetSchema['relatives'] = new sfWidgetFormSelect(array('choices' => 
		array_reverse($ar, true) ) );
		
		
	$this->validatorSchema['relatives'] = new sfValidatorPass(array('required' => false));
	
	
	
  }
  
    protected function addRelativesColumnQuery(Doctrine_Query $query, $field, $values) {
    	if( $values[0] ){
			$query->innerJoin('r.NewsGroup ng ')
					->innerJoin( 'ng.StructureNewsGroup sng WITH sng.structure_id = ?', $values[0] );
			
    	}
    }
    
	public function getFields()
	{
		return array_merge( parent::getFields(), array('relatives' => 'Text', //using default search because it is on object1 and this class extends Object1Filter
				) );
	}
}
