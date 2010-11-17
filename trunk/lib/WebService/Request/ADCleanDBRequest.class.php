<?php

class ADCleanDBRequest extends SimpleWebRequest {

	const CINEMAS_URL = 'http://www.eventival.eu/poff/14/et/ws/2ae44138cee5011f9cd2d474f11bfbd9/films/cinemas.xml';
	const PACKAGES_URL = 'http://www.eventival.eu/poff/14/et/ws/2ae44138cee5011f9cd2d474f11bfbd9/film-packages.xml';
	const FILMS_URL = 'http://www.eventival.eu/poff/14/et/ws/2ae44138cee5011f9cd2d474f11bfbd9/films/categories/10/publications-locked.xml';
	const FILMS_URL2 = 'http://www.eventival.eu/poff/14/et/ws/2ae44138cee5011f9cd2d474f11bfbd9/films/categories/9/publications-locked.xml';
	const SCREENINGS_URL = 'http://www.eventival.eu/poff/14/en/ws/2ae44138cee5011f9cd2d474f11bfbd9/films/categories/8/screenings.xml';
	const SECTIONS_URL = 'http://www.eventival.eu/poff/14/et/ws/2ae44138cee5011f9cd2d474f11bfbd9/films/sections.xml';

	public function send() {
		$this->response = parent::send();
		if( $this->response && is_object($this->response) ){
			$this->xmlObject = new XMLMapper();
			$this->xmlObject->execute($this->response->getContent());
			$this->objArray = $this->xmlObject->getResponseArray();
		}

	}

	public function cleanFilmsTables() {
		$ids = array();
		foreach ($this->objArray['item'] as $film) {
			$ids[] = $film['id'];
		}
		$query = $this->getSelectQuery('Product', $ids);
		$query->andWhereIn('type', 'film');
		$result = $query->fetchArray();
		$dbIds = array();
		foreach($result as $index => $id) {
			$dbIds[] = $id['id'];
		}
		if (!empty($dbIds)) {
			$query = Doctrine_Query::create()
								   ->delete()
								   ->from('ProductVsProduct')
								   ->whereIn('product2', $dbIds);
			$query->execute();
		}
		$query = $this->getDropQuery('Product', $ids);
		$query->andWhereIn('type', 'film')->execute();
	}

	public function cleanPackagesTables() {
		foreach ($this->objArray['item'] as $package) {
			$ids[] = $package['id'];
		}
		$query = $this->getSelectQuery('Product', $ids);
		$query->andWhereIn('type','package');
		$result = $query->fetchArray();
		$dbIds = array();
		foreach($result as $index => $id) {
			$dbIds[] = $id['id'];
		}
		if (!empty($dbIds)) {
			$query = Doctrine_Query::create()
								   ->delete()
								   ->from('ProductVsProduct')
								   ->whereIn('product1', $dbIds);
			$query->execute();
		}
		$query = $this->getDropQuery('Product', $ids);
		$query->andWhereIn('type', 'package');
		$query->execute();
	}

	public function cleanCinemasTables() {
		$ids = array();
		$hallIds = array();
		foreach ($this->objArray['cinema'] as $cinema) {
			if (!isset($cinema['cinema_halls']['cinema_hall']['id'])) {
				foreach ($cinema['cinema_halls']['cinema_hall'] as $hall) {
					$hallIds[] = $hall['id'];
				}
			} else {
				$hallIds[] = $cinema['cinema_halls']['cinema_hall']['id'];
			}
			$ids[] = $cinema['id'];
		}
		$this->getDropQuery('Cinema', $ids)->execute();
		$this->getDropQuery('CinemaHall', $hallIds)->execute();
	}

	public function cleanSectionsTables() {
		$ids = array();
		foreach($this->objArray['section'] as $section) {
			$ids[] = $section['id'];
		}
		$query = $this->getDropQuery('ProductGroup', $ids);
		$query->andWhereNotIn('eventival_id', '');
		$query->execute();
	}

	public function cleanScreeningsTables() {
		$ids = array();
		foreach($this->objArray['screening'] as $screening) {
			$ids[] = $screening['id'];
		}
		$this->getDropQuery('Screening', $ids)->execute();
	}

	private function getDropQuery($object, $ids) {
		$query = Doctrine_Query::create()
							   ->delete()
							   ->from($object)
							   ->whereNotIn('eventival_id', $ids);
		return $query;
	}

	private function getSelectQuery($object, $ids) {
		$query = Doctrine_Query::create()
							   ->select('id')
							   ->from($object)
							   ->whereNotIn('eventival_id', $ids);
		return $query;
	}

	public function __construct( $url ){

		$params['url'] = $url;
		$params['request_data'] = "";
		$params['method'] = 'GET';

		parent::__construct( $params );
	}
}