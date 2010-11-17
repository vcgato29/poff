<?php

class PackageXMLMapper extends XMLMapper {

	private $packageBaseUrl = 'http://www.eventival.eu/poff/14/et/ws/2ae44138cee5011f9cd2d474f11bfbd9/film-packages/';
	private $tableType = 'ProductPackage';

	public function execute($response) {
		parent::execute($response);
		$this->getData($this->tableType);
	}

	public function mapPackages() {
		foreach($this->responseArray['item'] as $package) {
			$this->mapPackage($package['id']);
			sleep(5); //Because eventival can't give us data this "fast"
		}
	}


	public function mapPackage($packageID) {
		$url = $this->packageBaseUrl.$packageID.'.xml';
		$request = new FetchAdXmlRequest($url);
		$xmlObj = $request->send();
		$packageArray = $xmlObj->getResponseArray();

		if (isset($packageArray['sections']['section']) && $packageArray['sections']['section'] != '') { // Because eventival can't take test data out of their XML feed
			$package['eventival_id'] = $this->validateElement($packageArray['ids']['system_id']);
			$package['title_original'] = $this->validateElement($packageArray['titles']['title_original']);

			$enName = $this->validateElement($packageArray['titles']['title_english']);
			$estName = $this->validateElement($packageArray['titles']['title_local']);
			if (isset($packageArray['publications']['en']) &&
					!empty($packageArray['publications']['en'])) {
				$enDescription = $this->validateElement($packageArray['publications']['en']['description']);
				$estDescription = $this->validateElement($packageArray['publications']['et']['description']);
			} else {
				$enDescription = '';
				$estDescription = '';
			}

			$package['Translation'] = array('et' => array('name' => $estName,
														  'longdescription' => $estDescription),
											'en' => array('name' => $enName,
														  'longdescription' => $enDescription)
									  );
			$package['code'] = time();
			$package['runtime'] = 0;
			$id = $this->checkData($this->tableType,$package['eventival_id']);
			if (!$id) {
				$id = $this->createData($this->tableType, $package);
				if (!is_array($packageArray['film_ids']['id'])) { //Hack for foreach
					$packageArray['film_ids']['id'] = array(1 => $packageArray['film_ids']['id']);
				}
				foreach ($packageArray['film_ids']['id'] as $film) {
					$query = Doctrine_Query::create()
								   ->from('Product data')
								   ->select('data.id')
								   ->where('data.type = ? AND data.eventival_id = ?', array('package_film', $film));
					$dbFilm = $query->fetchOne();
					if ($dbFilm) {
						$dbFilmId = $dbFilm->getId();
					} else {
						$filmMapper = new FilmXMLMapper();
						$dbFilmId = $filmMapper->mapFilm($film);
						sleep(1);
					}
					$package['runtime'] += Doctrine::getTable('Product')->find($dbFilmId)->getRuntime();
					$query = Doctrine_Query::create()
										   ->from('ProductVsProduct')
										   ->select('product1')
										   ->where('product1 = ? AND product2 = ?', array($id, $dbFilmId));
					$check = $query->fetchOne();
					if (!$check) {
						$packageVsFilm = new ProductVsProduct();
						$packageVsFilm->fromArray(array(
							'product1' => $id,
							'product2' => $dbFilmId
						));
						$packageVsFilm->save();
					}
				}
			} else {
				$query = Doctrine_Query::create()
									   ->from('ProductVsProduct')
									   ->select('product2')
									   ->where('product1 = ?', $id);
				$dbFilms = $query->fetchArray();
				if (!$dbFilms) {
					if (!is_array($packageArray['film_ids']['id'])) { //Hack for foreach
						$packageArray['film_ids']['id'] = array(1 => $packageArray['film_ids']['id']);
					}
					foreach ($packageArray['film_ids']['id'] as $film) {
						$query = Doctrine_Query::create()
									   ->from('Product data')
									   ->select('data.id')
									   ->where('data.type = ? AND data.eventival_id = ?', array('package_film', $film));
						$dbFilm = $query->fetchOne();
						if ($dbFilm) {
							$dbFilmId = $dbFilm->getId();
						} else {
							$filmMapper = new FilmXMLMapper();
							$dbFilmId = $filmMapper->mapFilm($film);
							sleep(1);
						}
						$package['runtime'] += Doctrine::getTable('Product')->find($dbFilmId)->getRuntime();
						$query = Doctrine_Query::create()
											   ->from('ProductVsProduct')
											   ->select('product1')
											   ->where('product1 = ? AND product2 = ?', array($id, $dbFilmId));
						$check = $query->fetchOne();
						if (!$check) {
							$packageVsFilm = new ProductVsProduct();
							$packageVsFilm->fromArray(array(
								'product1' => $id,
								'product2' => $dbFilmId
							));
							$packageVsFilm->save();
						}
					}
					$query = Doctrine_Query::create()
										   ->from('ProductVsProduct')
										   ->select('product2')
										   ->where('product1 = ?', $id);
					$dbFilms = $query->fetchArray();
				}
				foreach($dbFilms as $dbFilmId) {
					$package['runtime'] += Doctrine::getTable('Product')->find($dbFilmId['product2'])->getRuntime();
				}
				$this->updateData($this->tableType, $package, $id);
			}
			if (isset($packageArray['sections']['section']['id'])) {
				$sectionId = $packageArray['sections']['section']['id'];
			} else {
				$sectionId = $packageArray['sections']['section'][0]['id'];
			}
			// Section == ProductGroup
			$query = Doctrine_Query::create()
									   ->from('ProductGroup data')
									   ->select('data.id')
									   ->whereIn('data.eventival_id', $sectionId);
			$dbSection = $query->fetchOne();
			if($dbSection == null) {
			//	$sectionMapper = new SectionXMLMapper();
			//	$dbFilmId = $sectionMapper->mapSection($section);
			} else {
				$dbSectionId = $dbSection->getId();
			}
			if ($dbSectionId) {
				$query = Doctrine_Query::create()
									   ->from('ProductVsProductGroup')
									   ->select('group_id')
									   ->where('group_id = ? AND product_id = ?', array($dbSectionId, $id));
				$check = $query->fetchOne();
				if (!$check) {
					$fVs = array('group_id' => $dbSectionId, 'product_id' => $id);
					$filmVsSection = new ProductVsProductGroup();
					$filmVsSection->fromArray($fVs);
					$filmVsSection->save();
				}
			}
			return $id;
		} else {
			return null;
		}
	}
}