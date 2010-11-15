<?php

class newsBlock3WidgetComponents extends myComponents{

    public function executeRender(){
        // newsblock widget
  	$q = Doctrine::getTable('NewItem')->createQuery('n')
  		->select('n.*')
  		->addSelect('bg.link_to_struct as link_to_struct')
  		->from('NewItem n')
  		->innerJoin('n.NewsGroup bg')
  		->innerJoin('bg.StructureNewsGroup sbg')
  		->innerJoin('sbg.Structure s WITH s.id = ?', $this->getRoute()->getObject()->getId())
  		->orderBy('n.pri asc')
  		->where('bg.type = ?', 'row')
		->addOrderBy('n.pri asc, n.id desc')
  		->limit(2);

        $this->news = $q->execute();

    }

}