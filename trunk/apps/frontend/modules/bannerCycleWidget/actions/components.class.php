<?php
class bannerCycleWidgetComponents extends myComponents
{
  public function executeRender()
  {
        // jcarousel widget
  	$q = Doctrine::getTable('Banner')->createQuery('b')
  		->select('b.*')
  		->from('Banner b')
  		->innerJoin('b.BannerGroup bg')
  		->innerJoin('bg.StructureBannerGroups sbg')
  		->innerJoin('sbg.Structure s WITH s.id = ?', $this->getRoute()->getObject()->getId())
  		->where('bg.type = ?', 'default')
  		->orderBy('b.pri asc')
  		->limit(9);

	$this->banners = $q->execute();

        // just banners
  	$q = Doctrine::getTable('Banner')->createQuery('b')
  		->select('b.*')
  		->from('Banner b')
  		->innerJoin('b.BannerGroup bg')
  		->innerJoin('bg.StructureBannerGroups sbg')
  		->innerJoin('sbg.Structure s WITH s.id = ?', $this->getRoute()->getObject()->getId())
  		->where('bg.type = ?', 'special')
  		->orderBy('b.pri asc')
  		->limit(4);


        $this->logos = $q->execute();
  }
  
}