<?php

class ProductGroupVsParameterGroupTable extends Doctrine_Table
{
	public function findByProdgroupIds( array $productGroupPrimaryKeys )
	{
		$q = $this->createQuery('s')
			->select('pag.*')
			->from('ParameterGroup pag')
			->innerJoin('pag.ProductGroupParameterGroups pgvpg')
			->whereIn('pgvpg.prodgroup_id', $productGroupPrimaryKeys)
			->setHydrationMode(Doctrine::HYDRATE_RECORD);
			
			
		return $q->execute();
				
	}
	
	public function flatternCollection( array $collection, $children = '__children' )
	{
		
		
	}
	
	

}