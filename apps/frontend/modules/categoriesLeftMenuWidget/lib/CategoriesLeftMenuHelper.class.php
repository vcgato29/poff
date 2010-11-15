<?php

class CategoriesLeftMenuHelper{
	
	public function hiddenNode($node){
		if(!is_object($node))
			$obj = $node['object'];
		else
			$obj = $node;

                
		return  !$obj['name'];
	}

        public function isActive($node, $activeNodes){
            if(($prod = sfContext::getInstance()->getActionStack()->getFirstEntry()
                        ->getActionInstance()->getRoute()->getProductObject())
                    && isset($node['item_type']) && $node['item_type'] == 'product'){

                return $prod['id'] == $node['id'];
            }else if(in_array($node['id'], $activeNodes) && @$node['item_type'] != 'product')
                    return true;


            return false;
        }
	
}