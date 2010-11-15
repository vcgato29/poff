<?php

class BannerTable extends Doctrine_Table
{
	
	public function findStructureBanners( $structID )
	{
				
		$query = Doctrine_Query::create()
   			 ->select('b.name, b.id, b.file, b.link, bg.id as group')
   			 ->from('Banner b')
   			 ->innerJoin('b.BannerGroup bg')
   			 ->innerJoin("bg.BannerGroupVsStructure bgvs WITH bgvs.id = '$structID'")
   			 ->groupBy('bg.id, b.id');
   		
   		$queryResult = $query->execute();
   		
		$result = array();
		
   		foreach( $queryResult as $banner ){
   			$result[$banner->group][] = $banner; 	
   		}
   		
    	return $result;
    	
	}
	
	public function getAssociatedToCategoryBannersQuery( $catID ){
		
		return $this->createQuery('category_banners')
			->from('Banner b')
			->innerJoin('b.BannerGroup bg WITH bg.id = ?', $catID );
	}

}