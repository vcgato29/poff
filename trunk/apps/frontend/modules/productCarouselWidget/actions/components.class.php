<?php
class productCarouselWidgetComponents extends myComponents
{
	
	protected $banners = false;
	
  public function executeRender(){
  	
  	$this->bannersInfo = $this->getBanners();
  	
	$this->firstBanner = $this->getFirstActiveBanner();
  	$this->firstBannerPosition = $this->getFirstActiveBannerPosition();
  	
  
  }
  
  
  private function getFirstActiveBanner(){
  	if( $this->getBanners() )
  		return $this->getBanners()->get( $this->getFirstActiveBannerPosition() );
  	else
  		return false;
  }
  
  private function getFirstActiveBannerPosition(){
  	if( !$this->getBanners() ) return false; 
  	
    $count = $this->getBanners()->count();
  	
  	if( $count >= 5 ){
  		$pos = 3 - 1;
  	}else{
  		$pos = ceil( $count / 2 ) - 1;
  	}

  	return $pos;
  }
  
  
  
  private function getBanners(){
  	
  	
  	if( !$this->banners ){
		$catBan = $this->getCategoryBanners();
		
		
		if( $catBan )
			$this->banners = $catBan;
		else{
			$this->banners = $this->getStructureBanners();
		}
		
		if( $this->banners->count() == 0 )
			$this->banners = false;
  	}
  	
  	
  	
  	return $this->banners;
  	
  }
  
  
  private function getStructureBanners(){
  	
  	$banners = false;
  	
  	
  	
  	$bg = $this->getNode()->getStructureBannerGroups();
  	if( $bg )
  		$banners = Doctrine::getTable('Banner')->getAssociatedToCategoryBannersQuery($bg[0]['banner_group_id'])->execute();
  		
  	return $banners;
  }
  
  
  private function getCategoryBanners(){
  	if( !$this->getCategory() ) return false;
  	
  	$bg = $this->getCategory()->getBannerGroups();
  	
  	if( $bg )
  		$banners = Doctrine::getTable('Banner')->getAssociatedToCategoryBannersQuery($bg[0]['banner_group_id'])->execute();
  		
  	
  	return $banners;
  	//print_r( $banners->toArray() );
  	
  	
  }
  
  private function getCategory(){
  	try{
  		return $this->getRoute()->getCategoryObject();
  	} catch(Exception $e){
  		return false;
  	} 
  }
  
  private function getNode(){
  	return $this->getRoute()->getObject();
  }
  
  
  
  
}