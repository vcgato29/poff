<?php

class CounterWidgetComponents extends myComponents{

	public function executeRender(){
		$q = Doctrine::getTable('TransUnit')->createQuery('v')
  		->select('v.*')
  		->from('TransUnit v')
  		->where('v.msg_id = ?', '2')
  		->limit(1);
        $this->counter = $q->execute();

	}

}
