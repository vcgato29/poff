<?php

/**
 * Product filter form.
 *
 * @package    jobeet
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class ProductFormFilter extends BaseProductFormFilter
{
  public function configure()
  {

  	$this->widgetSchema['margin'] = new sfWidgetFormInput();
  	$this->validatorSchema['margin'] = new sfValidatorPass(array('required' => false));

  	$this->validatorSchema['price'] = new sfValidatorPass(array('required' => false));

  	$this->widgetSchema['name'] = new sfWidgetFormInput();
  	$this->validatorSchema['name'] = new sfValidatorPass(array('required' => false));

	$this->widgetSchema['barcode'] = new sfWidgetFormInput();
  	$this->validatorSchema['barcode'] = new sfValidatorPass(array('required' => false));
  	
	$this->widgetSchema['product_group'] = new sfWidgetFormSelectMany(array('choices' => 
		$this->getProductGroupChoices() ), array( 'size' => 3, 'style' => 'width:100px' ) );
	$this->validatorSchema['product_group'] = new sfValidatorPass(array('required' => false));
  	
  	  	
  }
  
  public function getProductGroupChoices(){
  	 
  	$result = array();

  	
  	foreach( Doctrine::getTable('ProductGroup')->findAll()  as $pg ){
  		if( $pg['title'] != 'root' )
  		$result[$pg['id']] = $pg['title'];
  	}
  	
  	return $result;
  				
	
  }

    protected function addMarginColumnQuery(Doctrine_Query $query, $field, $value) {
			if(!$value) return;
			$expression = $this->parseFilterExpression($value);
			$query->andWhere("(r.price - r.supplier_price)  ${expression['operator']} ?", $expression['value']);

    }

    protected function addPriceColumnQuery(Doctrine_Query $query, $field, $value) {
		if(isset($value['is_empty'])){
			$query->andWhere("r.price = ?", '');
		}else if($value['text']){
			$expression = $this->parseFilterExpression($value['text']);
			$query->andWhere("r.price ${expression['operator']} ?", $expression['value']);
		}
    }


	protected function parseFilterExpression($text){
		preg_match('/([><])? *(\d+)/i',$text, $results);
		$operator = isset($results[1]) && in_array($results[1], array('>','<')) ? $results[1] : '=';

		return array('operator' => $operator, 'value' => $results[2]);
	}
  
    protected function addNameColumnQuery(Doctrine_Query $query, $field, $values) {
    	if($values){
			$query->andWhere( 'r.Translation.name LIKE ?', "%${values}%");
		}

    }

	protected function addBarcodeColumnQuery(Doctrine_Query $query, $field, $value){
		if($value){
			$query->andWhere('r.barcode = ?', $value);
		}

	}
    
    protected function addProductGroupColumnQuery(Doctrine_Query $query, $field, $values) {
		if( $values )
			$query->innerJoin('r.ProductGroups pgs')
				->andWhereIn( 'pgs.group_id', $values );
			
    }
}
