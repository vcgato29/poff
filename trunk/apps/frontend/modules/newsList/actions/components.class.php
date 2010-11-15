<?php


class newsListComponents extends myComponents{

	public function executeRender(){
		$this->node = $this->getRoute()->getObject();

		$this->pager = $this->getPager();


	}



	public function getPager(){
		$pager = new sfDoctrinePager( 'NewItem', 999);
  		$pager->setQuery( $this->getNewsQuery() );
  		$pager->setPage($this->getRequestParameter('page', 0));
  		$pager->init();
        //foreach($pager->getResults() as $newItem):
        //echo $newItem['link_to_struct'];
		//exit;
		//endforeach;
		return $pager;
	}

	public function getNewsQuery(){
		$q = Doctrine::getTable('NewItem')
			->createQuery('asdaksd;')
			->select('ni.*')
			->addSelect('ng.link_to_struct as link_to_struct')
			->from('NewItem ni')
			->innerJoin('ni.NewsGroup ng WITH ng.link_to_struct = ?', $this->getRoute()->getObject()->getId())
			->leftJoin('ng.StructureNewsGroup sng')
  		    ->leftJoin('sng.Structure s WITH s.id = '.$this->getRoute()->getObject()->getId().' and s.lang = ?', $this->getRoute()->getObject()->getLang())
			//->where('ni.group_id <> 0')
			->orderBy('ni.active_start desc, ni.id desc');
             //->andWhere('ng.link_to_struct = ?', $this->getRoute()->getObject()->getId())
        //exit;
		return $q;

	}


}