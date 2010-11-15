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
class productPreviewFilterForm extends BaseProductFormFilter{
    public function configure(){

	 sfProjectConfiguration::getActive()->loadHelpers('I18N');

		$this->widgetSchema['scheduled_time'] = new sfWidgetFormSelect(array('choices'  => $this->getDates() ));
		$this->validatorSchema['scheduled_time'] = new sfValidatorPass(array('required' => false));

		$this->widgetSchema['location'] = new sfWidgetFormSelect(array('choices'  => $this->getLocations() ));
		$this->validatorSchema['location'] = new sfValidatorPass(array('required' => false));

		$this->widgetSchema['cinema'] = new sfWidgetFormSelect(array('choices'  => $this->getCinemas() ));
		$this->validatorSchema['cinema'] = new sfValidatorPass(array('required' => false));

		$this->widgetSchema['keyword'] = new sfWidgetFormInputText(array(), array('class' => 'txt', 'title' => __('Keyword')));
		$this->widgetSchema['keyword']->setDefault(__('Keyword'));
		$this->validatorSchema['keyword'] = new sfValidatorPass(array('required' => false));

		$this->widgetSchema['programm'] = new sfWidgetFormSelect(array('choices'  => $this->getProgramms() ));
		$this->validatorSchema['programm'] = new sfValidatorPass(array('required' => false));

		$this->useFields(array('scheduled_time', 'location', 'cinema', 'keyword', 'programm'));

	}

    protected function addLocationColumnQuery(Doctrine_Query $query, $field, $values) {
    	if($values && $values != 'empty'){
			$query->andWhere( 'r.Translation.country LIKE ?', "%${values}%");
		}

    }

    protected function addProgrammColumnQuery(Doctrine_Query $query, $field, $values) {
    	if($values && $values != 'empty'){
			$query->andWhere( 'r.ProductGroups.group_id = ?', "${values}");
		}

    }

    protected function addKeywordColumnQuery(Doctrine_Query $query, $field, $values) {
    	if($values && $values != __('Keyword')){
			$culture = sfContext::getInstance()->getUser()->getCulture();
			$query->andWhere( 'r.original_title LIKE ? OR r.producer LIKE ? OR r.director_name LIKE ? OR r.director_filmography LIKE ? OR r.writer LIKE ? OR r.festivals LIKE ? OR r.Translation.description LIKE ? AND r.Translation.lang = ? OR r.Translation.name LIKE ? AND r.Translation.lang = ? OR r.Translation.synopsis LIKE ? AND r.Translation.lang = ? OR r.Translation.director_bio LIKE ? AND r.Translation.lang = ?', array("%${values}%", "%${values}%", "%${values}%", "%${values}%", "%${values}%", "%${values}%", "%${values}%", $culture, "%${values}%", $culture, "%${values}%", $culture, "%${values}%", $culture));
		}

    }

    protected function addCinemaColumnQuery(Doctrine_Query $query, $field, $values) {
    	if($values && $values != 'empty'){
			$query->where( 'r.Exemplars.cinema = ?', "${values}");
		}
    }

    protected function addScheduledTimeColumnQuery(Doctrine_Query $query, $field, $values) {
		switch($values){
			case 'empty':
				//$query->andWhere( 'r.scheduled_time >= ?', date('Y-m-d'));
				break;
			default:
				$values  = str_replace('.', '-', $values);
				$day_start = date('Y-m-d', strtotime($values));
				$day_end = date('Y-m-d 23:59', strtotime($values) + 24*60*60);

				$query->andWhere( "r.Exemplars.scheduled_time >= ? AND r.Exemplars.scheduled_time <= ?", array($day_start, $day_end));
				break;
		}

    }

	protected function getLocations(){

		$culture = sfContext::getInstance()->getUser()->getCulture();

		$qResult = Doctrine_Query::create()
			->from('Product p')
			->innerJoin('p.Translation pt WITH pt.lang = ?', $culture)
			->select('p.id, pt.country')
			->where('pt.country != ""')
			->groupBy('pt.country')
			->setHydrationMode(Doctrine::HYDRATE_ARRAY)
			->execute();

		foreach($qResult as $item){
			if(strlen($item['Translation'][$culture]['country'])<3) $result[] = $item['Translation'][$culture]['country'];
		}


		if(!is_array($result))
			$result = array($result);


		$values = array_merge(array('Riik:'),$result);
		$keys = array_merge(array('empty'),$result);

		return array_combine($keys, $values);

	}

	protected function getCinemas(){

		$result = ProductExemplarTable::getCinemas();

		$values = array_merge(array('Kino:'),$result);
		$keys = array_merge(array('empty'),$result);


		return array_combine($keys, $values);
	}

	protected function getDates(){

		$result = ProductExemplarTable::getDates();

		$values = array_merge(array('Kuupäev:'),$result);
		$keys = array_merge(array('empty'),$result);


		return array_combine($keys, $values);
	}


	protected function getProgramms(){
		$result = array();
		$culture = sfContext::getInstance()->getUser()->getCulture();

		$qResult = Doctrine_Query::create()
					->from('ProductGroup pg')
					->where('pg.level = 1')
					->innerJoin('pg.Translation pgt WITH pgt.lang = ? AND pgt.name != ""', $culture)
					->innerJoin('pg.Products pconn')
			        ->innerJoin('pconn.Product p')
			        ->innerJoin('p.Translation pt WITH pt.lang = ?',  $culture)
					->setHydrationMode(Doctrine::HYDRATE_ARRAY)
					->execute();


		foreach($qResult as $item){
			$values[] = $item['Translation'][$culture]['name'];
			$keys[] = $item['Translation'][$culture]['id'];
		}



		$values = array_merge(array('Programms:'),$values);
		$keys = array_merge(array('empty'),$keys);


		return array_combine($keys, $values);



	}
}
?>
