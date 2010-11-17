<?php

class FetchAdXmlRequest extends SimpleWebRequest{

	const PILETILEVI = 1;
	const CINEMA = 2;
	const PACKAGE = 3;
	const FILM = 4;
	const SCREENING = 5;
	const SECTION = 6;

	const PILETILEVI_URL = 'http://www.piletilevi.ee/xml.php?promoter=127756&shop_provider=poff';
	const CINEMAS_URL = 'http://www.eventival.eu/poff/14/et/ws/2ae44138cee5011f9cd2d474f11bfbd9/films/cinemas.xml';
	const PACKAGES_URL = 'http://www.eventival.eu/poff/14/et/ws/2ae44138cee5011f9cd2d474f11bfbd9/film-packages.xml';
	const FILMS_URL = 'http://www.eventival.eu/poff/14/en/ws/2ae44138cee5011f9cd2d474f11bfbd9/films/categories/10/publications-locked.xml';
	const FILMS_URL2 = 'http://www.eventival.eu/poff/14/en/ws/2ae44138cee5011f9cd2d474f11bfbd9/films/categories/9/publications-locked.xml';
	const SCREENINGS_URL = 'http://www.eventival.eu/poff/14/en/ws/2ae44138cee5011f9cd2d474f11bfbd9/films/categories/8/screenings.xml';
	const SECTIONS_URL = 'http://www.eventival.eu/poff/14/et/ws/2ae44138cee5011f9cd2d474f11bfbd9/films/sections.xml';

	public function send($action = null) {
		$this->response = parent::send();
		if( $this->response && is_object($this->response) ){
			if ($action) {
				$xmlObject = $this->mapperChoice($action);
			} else {
				$xmlObject = new XMLMapper();
			}
			$xmlObject->execute($this->response->getContent());
			return $xmlObject;
		} else {
			return false;
		}
	}

	private function mapperChoice($action) {
		switch ($action) {
			case self::CINEMA:
				return new CinemaXMLMapper();
				break;
			case self::SECTION:
				return new SectionXMLMapper();
				break;
			case self::FILM:
				return new FilmXMLMapper();
				break;
			case self::PACKAGE:
				return new PackageXMLMapper();
				break;
			case self::SCREENING:
				return new ScreeningXMLMapper();
				break;
			default:
				return new XMLMapper();
				break;
		}
	}

	public function __construct( $url ){

		$params['url'] = $url;
		$params['request_data'] = "";
		$params['method'] = 'GET';

		parent::__construct( $params );
	}
}