<?php

class FilmXMLMapper extends XMLMapper {

	private $filmBaseUrl = 'http://www.eventival.eu/poff/14/et/ws/2ae44138cee5011f9cd2d474f11bfbd9/films/';
	private $tableType = 'Product';

	public function execute($response) {
		parent::execute($response);
		$this->getData($this->tableType);
	}

	public function mapFilms() {
		foreach($this->responseArray['item'] as $film) {
			$this->mapFilm($film['id']);
			sleep(5); //Because eventival can't give us data this "fast"
		}
	}

	public function mapFilm($filmID, $type = 'ProductFilm') {
		$url = $this->filmBaseUrl . $filmID . '.xml';
		$request = new FetchAdXmlRequest($url);
		$xmlObj = $request->send();
		$filmArray = $xmlObj->getResponseArray();

		$film['eventival_id'] = $this->validateElement($filmArray['ids']['system_id']);
		$film['Translation'] = array('et' => array('name' => is_array($filmArray['titles']['title_local']) ? '' : $filmArray['titles']['title_local'],
												   'description' => is_array($filmArray['publications']['et']['synopsis_long']) ? '' : $filmArray['publications']['et']['synopsis_long'],
												   'director_bio' => is_array($filmArray['publications']['et']['directors_bio']) ? '' : $filmArray['publications']['et']['directors_bio'],
												   'country' => is_array($filmArray['film_info']['countries']['country']) ? implode(',', $filmArray['film_info']['countries']['country']) : $filmArray['film_info']['countries']['country'],
												   'language' => is_array($filmArray['publications']['et']['languages']) ? implode(',', $filmArray['publications']['et']['languages']) : $filmArray['publications']['et']['languages'],
												   'synopsis' => is_array($filmArray['publications']['et']['synopsis_long']) ? implode(',', $filmArray['publications']['et']['synopsis_long']) : $filmArray['publications']['et']['synopsis_long']),
									 'en' => array('name' => is_array($filmArray['titles']['title_english']) ? '' : $filmArray['titles']['title_english'],
												   'description' => is_array($filmArray['publications']['en']['synopsis_long']) ? '' : $filmArray['publications']['en']['synopsis_long'],
												   'director_bio' => is_array($filmArray['publications']['en']['directors_bio']) ? '' : $filmArray['publications']['en']['directors_bio'],
												   'country' => is_array($filmArray['film_info']['countries']['country']) ? implode(',', $filmArray['film_info']['countries']['country']) : $filmArray['film_info']['countries']['country'],
												   'language' => is_array($filmArray['publications']['en']['languages']) ? implode(',', $filmArray['publications']['en']['languages']) : $filmArray['publications']['en']['languages'],
												   'synopsis' => is_array($filmArray['publications']['en']['synopsis_long']) ? implode(',', $filmArray['publications']['en']['synopsis_long']) : $filmArray['publications']['en']['synopsis_long']),
									'ru' => array('name' => is_array($filmArray['titles']['title_english']) ? '' : $filmArray['titles']['title_english'],
												   'description' => is_array($filmArray['publications']['en']['synopsis_long']) ? '' : $filmArray['publications']['en']['synopsis_long'],
												   'director_bio' => is_array($filmArray['publications']['en']['directors_bio']) ? '' : $filmArray['publications']['en']['directors_bio'],
												   'country' => is_array($filmArray['film_info']['countries']['country']) ? implode(',', $filmArray['film_info']['countries']['country']) : $filmArray['film_info']['countries']['country'],
												   'language' => is_array($filmArray['publications']['en']['languages']) ? implode(',', $filmArray['publications']['en']['languages']) : $filmArray['publications']['en']['languages'],
												   'synopsis' => is_array($filmArray['publications']['en']['synopsis_long']) ? implode(',', $filmArray['publications']['en']['synopsis_long']) : $filmArray['publications']['en']['synopsis_long'])
		);

        $film['original_title'] = $filmArray['titles']['title_original'];

		$film['director_name'] = is_array($filmArray['publications']['en']['directors']) ?
			implode(',', $filmArray['publications']['en']['directors']) : $filmArray['publications']['en']['directors'];
		if($film['director_name']=="")  {
			if(isset($filmArray['film_info']['directors']['director']['name']) or isset($filmArray['film_info']['directors']['director']['surname'])) $film['director_name'] = $filmArray['film_info']['directors']['director']['name']
		 					   . ' ' . $filmArray['film_info']['directors']['director']['surname'];
        }

		$film['director_filmography'] = is_array($filmArray['publications']['et']['directors_filmography']) ?
		implode(',', $filmArray['publications']['et']['directors_filmography']) : $filmArray['publications']['et']['directors_filmography'];

		$film['producer'] = is_array($filmArray['publications']['en']['producers']) ?
		implode(',', $filmArray['publications']['en']['producers']) : $filmArray['publications']['en']['producers'];
		$film['writer'] = is_array($filmArray['publications']['en']['writers']) ?
		implode(',', $filmArray['publications']['en']['writers']) : $filmArray['publications']['en']['writers'];


        $film['webpage'] = is_array($filmArray['film_info']['website_official']) ? '' : $filmArray['film_info']['website_official'];
        $film['festivals'] = is_array($filmArray['publications']['en']['synopsis_short']) ? '' : $filmArray['publications']['en']['synopsis_short'];

        $film['year'] = is_array($filmArray['film_info']['completion_date']['year']) ? null : $filmArray['film_info']['completion_date']['year'];
		$film['runtime'] = is_array($filmArray['film_info']['length']) ? null : $filmArray['film_info']['length'];

        $film['trailer_link'] = is_array($filmArray['film_info']['online_trailer_url']) ? null : $filmArray['film_info']['online_trailer_url'];

		foreach($filmArray['publications']['en']['crew']['contact'] as $filmcrew) {

			if($filmcrew['type']['id']==6) $film['music'] = is_array($filmcrew['text']) ? '' : $filmcrew['text'];
		    if($filmcrew['type']['id']==7) $film['editor'] = is_array($filmcrew['text']) ? '' : $filmcrew['text'];
		    if($filmcrew['type']['id']==9) $film['production'] = is_array($filmcrew['text']) ? '' : $filmcrew['text'];
			if($filmcrew['type']['id']==127) $film['world_sales'] = is_array($filmcrew['text']) ? '' : $filmcrew['text'];
		    if($filmcrew['type']['id']==126) $film['distributor'] = is_array($filmcrew['text']) ? '' : $filmcrew['text'];
		    if($filmcrew['type']['id']==15) $film['cast'] = is_array($filmcrew['text']) ? '' : $filmcrew['text'];
		    if($filmcrew['type']['id']==5) $film['operator'] = is_array($filmcrew['text']) ? '' : $filmcrew['text'];

		}


	    $id = $this->checkData($this->tableType, $film['eventival_id']);
		if (!$id) {
			$id = $this->createData($this->tableType, $film);
		} else {
			$this->updateData($this->tableType, $film, $id);
		}

		// Section == ProductGroup
		if (isset($filmArray['eventival_categorization']['sections']['section'])) { // Because eventival can't get their sections updated

			if(isset($filmArray['eventival_categorization']['sections']['section'][0])) {
				foreach($filmArray['eventival_categorization']['sections']['section'] as $groupProduct) {
				   $sectionId = $groupProduct['id'];
			       $query = Doctrine_Query::create()
										   ->from('ProductGroup data')
										   ->select('data.id')
										   ->whereIn('data.eventival_id', $sectionId);

					$dbSection = $query->fetchOne();
					if($dbSection) {
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
				}
			}
		    else {
		       $sectionId = $filmArray['eventival_categorization']['sections']['section']['id'];
		       $query = Doctrine_Query::create()
									   ->from('ProductGroup data')
									   ->select('data.id')
									   ->whereIn('data.eventival_id', $sectionId);

				$dbSection = $query->fetchOne();
				if($dbSection) {
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
		    }

		}
		//echo $filmArray['titles']['title_original'] .' was added!<br />';
		return $id;
	}
}