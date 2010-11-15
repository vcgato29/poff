<?php
class bannerPreviewWidgetComponents extends myComponents
{
  public function executeRender(){
  	
  	$q = Doctrine::getTable('Banner')->createQuery('b')
  		->select('b.*')
  		->from('Banner b')
  		->innerJoin('b.BannerGroup bg')
  		->innerJoin('bg.StructureBannerGroups sbg')
  		->innerJoin('sbg.Structure s WITH s.id = ?', $this->getRoute()->getObject()->getId())
  		->where('bg.type = ?', 'logos')
  		->orderBy('b.pri asc')
  		->limit(5);
  		
	$this->banners = $q->execute();
  }
  
  
}