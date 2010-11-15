<?php

class ProductCommentTable extends Doctrine_Table
{
	public function getCommentsQuery( $prodID ){
		return $this->createQuery('product_comments')
				->from('ProductComment pc ')
				->where('pc.product_id = ?', $prodID);
	}

}