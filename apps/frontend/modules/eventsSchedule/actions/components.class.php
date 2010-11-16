<?php
require_once(dirname(dirname(__FILE__)) . '/lib/evnetsScheduleConfiguration.class.php');

class eventsScheduleComponents extends myComponents{
	
	public function executeRender(){

		$this->configuration = new evnetsScheduleConfiguration();

		$this->filters = $this->configuration->getFilterForm($this->configuration->getFilters());

		$this->linastused = $this->buildQuery()->execute();
		$this->userLinastused = $this->getUserLinastused();


		$products = array();
		foreach($this->linastused as $lin){
			$products[] = $lin['Product'];
		}

		$this->productsLinks = LinkGen::getInstance(LinkGen::PRODUCT)->collectionLinks($products);
		
	}

	  protected function buildQuery()
	  {
		$tableMethod = '';

		if(null == $this->filters)
			$this->filters = $this->configuration->getFilterForm($this->configuration->getFilters());

		$this->filters->setTableMethod($tableMethod);
		$query = $this->filters->buildQuery($this->configuration->getFilters());


		$root = $query->getRootAlias();
		$query->orderBy($root.'.scheduled_time asc')
				->innerJoin("{$root}.Product p")
				->innerJoin('p.Translation pt')
				->innerJoin("{$root}.Translation pet WITH pet.lang = ?", $this->getUser()->getCulture());
		
		return $query;
	  }

	public function getUserLinastused(){
		$result = array(-1);
		
		if($this->getUser()->isAuthenticated()){
			$pe = Doctrine_Query::create()
					->from('ProductExemplar pe')
					->select('pe.*')
					->innerJoin('pe.UserProductExemplars upe WITH upe.user_id = ?', $this->getUser()->getObject()->getId())
					->execute();

			if($pe)
				$result = $pe->getPrimaryKeys();
		}

		return $result;
	}

	//    return $this->getUser()->setAttribute('product_exemplar.filters', $filters, 'admin_module');


	
}