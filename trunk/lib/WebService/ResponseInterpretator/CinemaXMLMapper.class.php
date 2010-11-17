<?php

class CinemaXMLMapper extends XMLMapper {

	const EST_URL = 'http://www.eventival.eu/poff/14/et/ws/2ae44138cee5011f9cd2d474f11bfbd9/films/cinemas.xml';
	const ENG_URL = 'http://www.eventival.eu/poff/14/en/ws/2ae44138cee5011f9cd2d474f11bfbd9/films/cinemas.xml';
	private $tableType = 'Cinema';

	public function execute($response) {
		parent::execute($response);
		$this->getData($this->tableType);
	}

	public function mapCinemas() {
		// Because english names are located at a different XML file
		$request = new FetchAdXmlRequest(self::ENG_URL);
		$this->enArray = $request->send()->getResponseArray();
		foreach($this->responseArray['cinema'] as $index => $cinema) {
			$enName = $this->validateElement($this->enArray['cinema'][$index]['name']);
			$estName = $this->validateElement($cinema['name']);

			$cinema['eventival_id'] = $this->validateElement($cinema['id']);

			$cinema['Translation']  = array('et' => array('name' => $estName),
										    'en' => array('name' => $enName)
									  );

			// Extract CinemaHall data from Cinema
			$halls = $cinema['cinema_halls'];
			$enHalls = $this->enArray['cinema'][$index]['cinema_halls'];

			// Single and many Cinema Hall are parsed differently
			if (!isset($halls['cinema_hall']['id'])) {
				$halls = array_pop($halls);
				$enHalls = array_pop($enHalls);
			}

			unset($cinema['cinema_halls']);
			unset($cinema['name']);
			unset($cinema['id']);

			$action = $this->checkData($this->tableType, $cinema['eventival_id']);
			if (!$action) {
				$cinId = $this->createData($this->tableType, $cinema);
			} else {
				$cinId = $action;
				$this->updateData($this->tableType, $cinema, $cinId);
			}

			//cinema halls
			foreach($halls as $index => $hall) {
				$enHallName =  $this->validateElement($enHalls[$index]['name']);
				$estHallName = $this->validateElement($hall['name']);

				$hall['eventival_id'] = $hall['id'];
				$hall['cinema_id']	  =	$cinId;
				$hall['Translation']  = array('et' => array('name' => $estHallName),
										      'en' => array('name' => $enHallName)
									    );

				unset($hall['id']);
				unset($hall['name']);

				$query = Doctrine_Query::create()
								   ->from('CinemaHall data')
								   ->select('data.id')
								   ->where('data.eventival_id = ?', $hall['eventival_id']);
				$dbHall = $query->fetchOne();
				if ($dbHall) {
					$this->updateData('CinemaHall', $hall, $dbHall->getId());
				} else {
					$this->createData('CinemaHall', $hall);
				}
			}
		}
	}

	public function mapCinema($cinema) {

	}

	public function mapCinemaHall($hallID) {
//		$url = 'http://www.eventival.eu/poff/14/et/ws/2ae44138cee5011f9cd2d474f11bfbd9/films/cinemas.xml';
//		$request = new FetchEventivalXMLWebRequest(array('url' => $url));
//		$cinemaArray = $request->send()->getResponseArray();
//
//		$url = 'http://www.eventival.eu/poff/14/en/ws/2ae44138cee5011f9cd2d474f11bfbd9/films/cinemas.xml';
//		$request = new FetchEventivalXMLWebRequest(array('url' => $url));
//		$engCinemaArray = $request->send()->getResponseArray();
//		foreach($cinemaArray[$this->tableType] as $index => $cinema) {
//			foreach($cinema['cinema_halls'] as $index => $halls) {
//				if(@is_array($halls[0])) {
//					foreach($halls as $indexHall => $hall) {
//						if ($hall['id'] == $hallID) {
//							$cinemaId = $cinema['id'];
//							$cin = $cinema;
//							$engCin = $engCinemaArray[$this->tableType][$index];
//							$saveHall = $hall;
//							$engHall = $engCinemaArray[$this->tableType][$index]['cinema_halls'][$indexHall];
//							break;
//						}
//					}
//				} else {
//					if ($halls['id'] == $hallID) {
//						$cinemaId = $cinema['id'];
//						$cin = $cinema;
//						$engCin = $engCinemaArray[$this->tableType][$index];
//						$saveHall = $halls;
//						$engHall = $engCinemaArray[$this->tableType][$index]['cinema_halls'];
//						break;
//					}
//				}
//			}
//		}
//		$query = Doctrine_Query::create()
//						   ->from('Cinema data')
//						   ->select('data.id')
//						   ->where('data.eventival_id = ?', $cinemaId);
//		$dbCinema = $query->fetchOne();
//		if ($dbCinema) {
//			$dbCinemaId = $dbCinema->getId();
//		} else {
//			$dbCinemaId = $this->mapCinema($cin);
//		}
//		$val['eventival_id'] = $hallID;
//		$val['cinema_id'] = $dbCinemaId;
//		$val['Translation'] = array('et' => array('name' => $saveHall['name']),
//									'en' => array('name' => $engHall['name'])
//							  );
//
//		return  $this->createData('CinemaHall', $val);
	}
}