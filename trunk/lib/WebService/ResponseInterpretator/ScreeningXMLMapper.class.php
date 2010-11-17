<?php

class ScreeningXMLMapper extends XMLMapper {

	private $tableType = 'Screening';

	public function execute($response) {
		parent::execute($response);
		$this->getData($this->tableType);
	}


	public function mapScreenings() {
		//Info from piletilevi
		$request = new FetchAdXmlRequest(FetchAdXmlRequest::PILETILEVI_URL);
		$piletileviArray = $request->send()->getResponseArray();
		foreach($this->responseArray['screening'] as $index => $val) {
			// Getting DB ID for CinemaHall relations
			$hallId = $val['cinema_hall_id'];
			$query = Doctrine_Query::create()
							   ->from('CinemaHall data')
							   ->select('data.id')
							   ->where('data.eventival_id = ?', $hallId);
			$dbHall = $query->fetchOne();
			if ($dbHall) {
				$dbHallId = $dbHall->getId();
			} else {
			//	$dbHallId = $this->mapCinemaHall($hallId);
			}

			$val['cinema_hall_id'] = $dbHallId;

			if (isset($val['film'])) {
				$filmId = $val['film']['id'];
				unset($val['film']);
				$args = array('film', $filmId);
				$query = $this->getProductQuery($args);
				$dbFilm = $query->fetchOne();
				if ($dbFilm) {
					$dbFilmId = $dbFilm->getId();
					//Hack for schelude
					Doctrine::getTable('Product')->find($dbFilmId)->setScheduled($val['start'])->save();
				} else {
					$filmMapper = new FilmXMLMapper();
					$dbFilmId = $filmMapper->mapFilm($filmId);
					Doctrine::getTable('Product')->find($dbFilmId)->setScheduled($val['start'])->save();
				}
				$val['product_id'] = $dbFilmId;
			} else if (isset($val['package'])) {
				$packageId = $val['package']['@attributes']['id'];
				unset($val['package']);
				$args = array('package', $packageId);
				$query = $this->getProductQuery($args);
				$dbPackage = $query->fetchOne();
				if ($dbPackage) {
					$dbPackageId = $dbPackage->getId();
					Doctrine::getTable('Product')->find($dbPackageId)->setScheduled($val['start'])->save();
				} else {
					$packageMapper = new PackageXMLMapper();
					$dbPackageId = $packageMapper->mapPackage($packageId);
					//Hack for schelude
					Doctrine::getTable('Product')->find($dbPackageId)->setScheduled($val['start'])->save();
				}
				$val['product_id'] = $dbPackageId;
			}

			$val['eventival_id'] = $val['id'];

			//From piletilevi
			foreach($piletileviArray['concerts']['concert'] as $concert) {
				if (is_array($concert['title'])) {
					$code = null;
				} else {
					$code = substr($concert['title'], 0, strpos($concert['title'], " /"));
				}
				if ($val['code'] == $code) {
						$val['availability'] = $concert['status'];
						//TODO: Optimize check without notice error output
						if ((@is_array($concert['deliveries']['zebra']))) {
							$val['web_sales'] = 1;
						} else {
							$val['web_sales'] = 0;
						}
						$val['piletilevi_id'] = $concert['id'];
					break;
				}
			}
			$val['start'] = strtotime($val['start']);
			$id = $this->checkData($this->tableType, $val['id']);

			unset($val['id']);
			unset($val['presentation']);
			unset($val['qa']);
			
			if (!$id) {
				$this->createData($this->tableType, $val);
			} else {
				$this->updateData($this->tableType, $val, $id);
			}
		}
	}

	private function getProductQuery($args) {
		$query = Doctrine_Query::create()
					   ->from('Product data')
					   ->select('data.id')
					   ->where('data.type = ? AND data.eventival_id = ?', $args);
		return $query;
	}

	private function getProductFromDbQuery($pId) {
		$query = Doctrine_Query::create()
								->from('Product data')
								->select('data.*')
								->where('data.id = ?', $pId);
	}
}