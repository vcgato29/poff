<?php

class ArchiveListWidgetComponents extends myComponents{

	public function executeRender(){

		$this->curNode = $this->getRoute()->getObject();

	  	$this->nodes_parent = Doctrine::getTable('Structure')->
			createQuery('all')
			->select('sl.*')
			->from('Structure sl')
			->where('sl.parameter = ?' , 'archive')
			->andWhere('sl.lang = ?',  $this->getRoute()->getObject()->getLang())
			->setHydrationMode(Doctrine::HYDRATE_RECORD)
			->limit(1)
			->execute();

		$this->nodes = Doctrine::getTable('Structure')->
			createQuery('all')
			->select('sl.*')
			->from('Structure sl')
			->where('sl.parentid = ?' , $this->nodes_parent[0]['id'])
			->andWhere('sl.lang = ?',  $this->getRoute()->getObject()->getLang())
			->setHydrationMode(Doctrine::HYDRATE_RECORD)
			->execute();
	    //echo '<pre>';
		//print_r($this->nodes);
	    //echo '</pre>';
	    //$this->nodes = $this->getNodes();
		$this->basket = myBasket::getInstance();

	}

}
