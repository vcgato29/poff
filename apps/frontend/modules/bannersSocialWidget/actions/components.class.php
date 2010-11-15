<?php

class bannersSocialWidgetComponents extends myComponents{

	public function executeRender(){
		$q = Doctrine::getTable('Banner')->createQuery('b')
  		->select('b.*')
  		->from('Banner b')
  		->innerJoin('b.BannerGroup bg')
  		->innerJoin('bg.StructureBannerGroups sbg')
  		->innerJoin('sbg.Structure s WITH s.id = ?', $this->getRoute()->getObject()->getId())
  		->where('bg.type = ?', 'social')
  		->orderBy('b.pri asc')
  		->limit(5);

  		if(count($q->execute())<1 and $this->getRoute()->getObject()->getId()!="1") {
	  		$q = Doctrine::getTable('Banner')->createQuery('b')
	  		->select('b.*')
	  		->from('Banner b')
	  		->innerJoin('b.BannerGroup bg')
	  		->innerJoin('bg.StructureBannerGroups sbg')
	  		->innerJoin('sbg.Structure s WITH s.id = ?', $this->getRoute()->getObject()->getParentid())
	  		->where('bg.type = ?', 'social')
	  		->orderBy('b.pri asc')
	  		->limit(5);
  		}


        if(count($q->execute())<1 and $this->getRoute()->getObject()->getParentid()!="1") {


	  		$q = Doctrine::getTable('Banner')->createQuery('b')
	  		->select('b.*')
	  		->from('Banner b')
	  		->innerJoin('b.BannerGroup bg')
	  		->innerJoin('bg.StructureBannerGroups sbg')
	  		->innerJoin('sbg.Structure s WITH s.id = ?', Doctrine::getTable('Structure')->findOneByLang($this->getRoute()->getObject()->getLang())->getId())
	  		->where('bg.type = ?', 'social')
	  		->orderBy('b.pri asc')
	  		->limit(5);

  		}


        $this->banners = $q->execute();

	}

}
