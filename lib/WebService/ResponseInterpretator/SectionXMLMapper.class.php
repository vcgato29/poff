<?php


class SectionXMLMapper extends XMLMapper {

	const EST_URL = 'http://www.eventival.eu/poff/14/et/ws/2ae44138cee5011f9cd2d474f11bfbd9/films/sections.xml';
	const ENG_URL = 'http://www.eventival.eu/poff/14/en/ws/2ae44138cee5011f9cd2d474f11bfbd9/films/sections.xml';
	private $tableType = 'ProductGroup';

	public function execute($response) {
		parent::execute($response);
		$this->getData($this->tableType);
	}

	public function mapSections() {
// Because english names are located at a different XML file
		$request = new FetchAdXmlRequest(self::ENG_URL);
		$this->enArray = $request->send()->getResponseArray();
		foreach($this->responseArray['section'] as $index => $section) {
			$enName = $this->validateElement($this->enArray['section'][$index]['name']);
			$enDescription = $this->validateElement($this->enArray['section'][$index]['description']);
			$estName = $this->validateElement($section['name']);
			$estDescription = $this->validateElement($section['description']);

			$section['eventival_id'] = $this->validateElement($section['id']);

			$section['Translation']  = array('et' => array('name' => $estName,
														   'description' => $estDescription),
										     'en' => array('name' => $enName,
														   'description' => $enDescription)
									   );
			$section['title'] = $estName;
			unset($section['id']);
			unset($section['name']);
			unset($section['description']);

			$id = $this->checkData($this->tableType, $section['eventival_id']);
			if (!$id) {
				$this->createData($this->tableType, $section);
			} else {
				$this->updateData($this->tableType, $section, $id);
			}
		}
	}

	public function mapSection() {

	}
}