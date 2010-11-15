<?php

class ParameterProductValueTable extends Doctrine_Table
{
	public function getObjectForProductAndParameter( Product $product, $param ){
		

	  	$q = $this->createQuery( 'c' )
  		->from( 'ParameterProductValue ppv' )
  		->where('ppv.Parameter.id = ? ', $param->getId() )
  		->addWhere('ppv.Product.id = ?', $product->getId() );
  	
	  	$ppv = $q->fetchOne();
	  	
	  	if( !$ppv ){
			$ppv = new ParameterProductValue();
			$ppv->setProduct( $product );
			$ppv->setParameter( $param );
			$ppv->setCommonValue('empty');
			$ppv->save();
	  	}

	  	return $ppv;
	}


}