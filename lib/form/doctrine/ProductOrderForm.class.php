<?php

/**
 * ProductOrder form.
 *
 * @package    jobeet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class ProductOrderForm extends BaseProductOrderForm
{
  public function configure()
  {
  	$this->useFields(array('id', 'status', 'notes'));
  	$this->widgetSchema['notes'] = new sfWidgetFormTextarea( array(), array('rows' => 1, 'cols' => 50) );

  }
  
  static function getBankOrderForm( $bank, $info = array() ){
  	
	switch( $bank ){
		
		case 'seb':
			
			$prod = new ProductOrderSeb();
			$prod->fromArray( $info );
			
			return new ProductOrderSebForm( $prod );
			break;
		case 'nordea':

			$prod = new ProductOrderNordea();
			$prod->fromArray( $info );
			
			return new ProductOrderNordeaForm( $prod );
			break;
		case 'sampo':
			$prod = new ProductOrderSampo();
			$prod->fromArray($info);

			return new ProductOrderSampoForm($prod);
		default :
			throw new Exception('unknown bank');
			break;
	}

  	
  }
}
