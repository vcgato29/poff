<?php


class newsList2Components extends myComponents{

	public function executeRender(){
		$this->node = $this->getRoute()->getObject();

		$this->pager = $this->getPager();

	}



	public function getPager(){
		$pager = new sfDoctrinePager( 'NewItem', 5 );
  		$pager->setQuery( $this->getNewsQuery() );
  		$pager->setPage($this->getRequestParameter('page', 1));
  		$pager->init();

		return $pager;
	}

	public function getNewsQuery(){		 /*$q = Doctrine::getTable('NewItem')
			->createQuery('asdaksd;')
			->select('ni.*')
			->addSelect('ng.link_to_struct as link_to_struct')
			->from('NewItem ni')
			->innerJoin('ni.NewsGroup ng')
			->innerJoin('ng.StructureNewsGroup sng')
			->innerJoin('sng.Structure s WITH s.id = ?', $this->getRoute()->getObject()->getId())
			->where('s.lang = ?',
					$this->getRoute()->getObject()->getLang())
			->orderBy('ni.active_start desc, ni.id desc');  */



		$q = Doctrine::getTable('NewItem')
			->createQuery('asdaksd;')
			->select('ni.*')
			->addSelect('ng.link_to_struct as link_to_struct')
			->from('NewItem ni')
			->innerJoin('ni.NewsGroup ng')
			->where('ng.link_to_struct = ?', $this->getRoute()->getObject()->getId())
			->orderBy('ni.active_start desc, ni.id desc');




		return $q;
	}


}