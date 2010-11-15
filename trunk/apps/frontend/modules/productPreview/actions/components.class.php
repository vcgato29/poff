<?php
require_once(dirname(dirname(__FILE__)) . '/lib/productPreviewConfiguration.class.php');

class productPreviewComponents extends myComponents{

	public function executeRender(){


		$this->configuration = new productPreviewConfiguration();

		$this->form = $this->configuration->getFilterForm();

		if($this->getRequest()->getMethod() == sfRequest::POST){
			$this->processForm($this->form);
		}

		$this->chars =  $this->getUniqueCharacters();
		$this->node = $this->getRoute()->getObject();

		$this->products = $this->buildQuery()->execute();


	}


	public function executeLinastused(){

		$this->linastused =
				Doctrine_Query::create()
					->from('ProductExemplar pe')
					->select('pe.*, p.*, pt.*')
					->where('pe.scheduled_time >= ? AND pe.scheduled_time <= ?', array(date('Y-m-d'), date('Y-m-d 23:59:59', time() + 24*60*60)))
					->innerJoin('pe.Product p')
					->innerJoin('p.Translation pt WITH pt.lang = ? AND pt.name != ""', $this->getUser()->getCulture())
					->orderBy('pe.scheduled_time asc')
					->limit(40)
					->execute();

	}


	private function buildQuery()
	{
		$tableMethod = '';

		if(null == $this->form)
			$this->form = $this->configuration->getFilterForm($this->configuration->getFilters());

		$this->form->setTableMethod($tableMethod);
		$query = $this->form->buildQuery($this->configuration->getFilters());

		$root = $query->getRootAlias();
		if(($char = $this->getRequest()->getParameter('alphabet_filter', false))){
			$query->andWhere("${root}.Translation.name LIKE ? COLLATE utf8_estonian_ci AND ${root}.Translation.lang = ?", array("{$char}%", $this->getUser()->getCulture()) );
		}
		else  {			$query->andWhere("${root}.Translation.name LIKE ? COLLATE utf8_estonian_ci AND ${root}.Translation.lang = ?", array("A%", $this->getUser()->getCulture()) );
		}

		$query->innerJoin($query->getRootAlias() . '.ProductGroups pgconn')
				->innerJoin('pgconn.ProductGroup pg')
				->innerJoin('pg.Translation t')
				->leftJoin($query->getRootAlias() . '.ProductPictures pp WITH pp.parameter = ?', 'default')
				->innerJoin($query->getRootAlias() . '.Translation pt WITH pt.lang = ?', $this->getUser()->getCulture())
				->orderBy("pt.name asc");



		return $query;
	}



	private function processForm($form){
		$form->bind($this->getRequest()->getParameter($form->getName()));
		if ($form->isValid())
		{
		  $this->configuration->setFilters($form->getValues());
		}else{
			$errSchema = $form->getErrorSchema();
			foreach($errSchema as $index => $err){
				echo $index . ": " . $err . "\n";
			}
			echo "not valid";exit;
		}

		$this->getAction()->redirect(LinkGen::getInstance(LinkGen::STRUCTURE)->link($this->getRoute()->getObject()->getId()));
	}


	private function getUniqueCharacters(){


		$culture = $this->getUser()->getCulture();

		$sql = "SELECT DISTINCT ORD( UPPER( SUBSTR( name, 1, 1 ) ) ), UPPER( SUBSTR( name, 1, 1 ) ) as first_letter
					FROM `product_translation`
					WHERE lang = '${culture}'
					ORDER BY first_letter ASC";

		$conn = Doctrine_Manager::connection();
		$pdo = $conn->execute($sql);
		$pdo->setFetchMode(Doctrine_Core::FETCH_ASSOC);
		return $pdo->fetchAll();

	}
}