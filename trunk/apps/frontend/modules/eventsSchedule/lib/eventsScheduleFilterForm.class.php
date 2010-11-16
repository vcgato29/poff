<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of eventsScheduleFilterForm
 *
 * @author aneto
 */
class eventsScheduleFilterForm extends BaseProductExemplarFormFilter{
    public function configure(){

		$this->widgetSchema['scheduled_time'] = new sfWidgetFormSelect(array('choices'  => $this->getDates() ));
		$this->validatorSchema['scheduled_time'] = new sfValidatorPass(array('required' => false));

		$this->widgetSchema['location'] = new sfWidgetFormSelect(array('choices'  => $this->getLocations() ));
		$this->validatorSchema['location'] = new sfValidatorPass(array('required' => false));

		$this->widgetSchema['cinema'] = new sfWidgetFormSelect(array('choices'  => $this->getCinemas() ));
		$this->validatorSchema['cinema'] = new sfValidatorPass(array('required' => false));
		//parent::configure();
	}

    protected function addLocationColumnQuery(Doctrine_Query $query, $field, $values) {
    	if($values && $values != 'empty'){
			$query->andWhere( 'r.location = ?', "${values}");
		}

    }

    protected function addCinemaColumnQuery(Doctrine_Query $query, $field, $values) {
    	if($values && $values != 'empty'){
			$query->andWhere( 'r.cinema = ?', "${values}");
		}
    }

    protected function addScheduledTimeColumnQuery(Doctrine_Query $query, $field, $values) {
		switch($values){
			case 'from_now':
				$query->andWhere( 'r.scheduled_time >= ?', date('Y-m-d'));
				break;
			case 'all':
				break;
			default:
				$values  = str_replace('.', '-', $values);
				$day_start = date('Y-m-d', strtotime($values));
				$day_end = date('Y-m-d 23:59', strtotime($values) + 24*60*60);
				
				$query->andWhere( "r.scheduled_time >= ? AND r.scheduled_time <= ?", array($day_start, $day_end));
				break;
		}


    }

	protected function getLocations(){
		$result = Doctrine_Query::create()
			->from('ProductExemplar pe')
			->select('DISTINCT location')
			->where('location != ""')
			->setHydrationMode(Doctrine::HYDRATE_SINGLE_SCALAR)
			->execute();

		if(!is_array($result))
			$result = array($result);


		$values = array_merge(array('Linn:'),$result);
		$keys = array_merge(array('empty'),$result);

		return array_combine($keys, $values);

	}

	protected function getCinemas(){
		$result = Doctrine_Query::create()
			->from('ProductExemplar pe')
			->select('DISTINCT cinema')
			->where('cinema != ""')
			->setHydrationMode(Doctrine::HYDRATE_SINGLE_SCALAR)
			->execute();

		if(!is_array($result))
			$result = array($result);

		$values = array_merge(array('Kino:'),$result);
		$keys = array_merge(array('empty'),$result);


		return array_combine($keys, $values);
	}

	protected function getDates(){

		$result = Doctrine_Query::create()
			->from('ProductExemplar pe')
			->select("DISTINCT DATE_FORMAT(scheduled_time, '%d.%m.%Y')")
			->where('scheduled_time != ""')
			->orderBy('scheduled_time asc')
			->setHydrationMode(Doctrine::HYDRATE_SINGLE_SCALAR)
			->execute();

		if(!is_array($result))
			$result = array($result);

		$values = array_merge(array('Kuupäev:','Kõik'),$result);
		$keys = array_merge(array('from_now' , 'all'),$result);


		return array_combine($keys, $values);
	}
}
?>
