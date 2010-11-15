<?php
//TODO:
// 1.) Optimize queries
// 2.) Optimize code
// 3.) Optimize deleteData()
// 4.) Add separate mapCinema() & mapCinemaHall() support
// 5.) Formatting
// 6.) update mapPackage()
class EventivalXMLMapper extends SimpleWebResponseInterpretator{

	public $requestType;
	public $piletileviURL = 'http://localhost/piletilevi/xml.xml';
	private $data = array();

	public function execute( $response ){
		parent::execute($response);

		$this->setResponseArray($this->convertResponse2Array());
	}

	public function mapObjects() {
		switch ($this->requestType) {
			case 'Cinema':
				$this->getData('Cinema');
				$this->mapCinemas();
				break;
			case 'Films':
				$this->getData('Product');
				$this->mapFilms();
				break;
			case 'Packages':
				$this->getData('ProductPackage');
				$this->mapPackages();
				break;
			case 'Screenings':
				$this->getData('Screening');
				$this->mapScreenings();
				break;
			//Pavel 9.11.2010
			case 'Sections':
				$this->getData('ProductGroup');
				$this->mapSections();
				break;
			//Pavel 9.11.2010
			default:
				break;
		}
	}

	private function mapScreenings() {
		//Check for delete
		foreach($this->data as $indexData => $data) {
			foreach($this->responseArray['screening'] as $val) {
				if ($data['eventival_id'] == $val['id']) {
					$this->data[$indexData]['status'] = 'update';
					break;
				}
				$this->data[$indexData]['status'] = 'drop';
			}
			if ($this->data[$indexData]['status'] == 'drop') {
				$this->deleteData('Screening', $this->data[$indexData]['id']);
				unset($this->data[$indexData]);
			}
		}

		//Info from piletilevi
		$request = new FetchEventivalXMLWebRequest(array('url' => $this->piletileviURL));
		$piletileviArray = $request->send()->getResponseArray();

		foreach($this->responseArray['screening'] as $index => $val) {
			$action = $this->w($val['id']);
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
				$dbHallId = $this->mapCinemaHall($hallId);
			}

			$val['cinema_hall_id'] = $dbHallId;

			if (isset($val['film'])) {
				$filmId = $val['film']['id'];
				unset($val['film']);
				$query = Doctrine_Query::create()
							   ->from('Product data')
							   ->select('data.id')
							   ->where('data.type = "film" AND data.eventival_id = ?', $filmId);
				$dbFilm = $query->fetchOne();
				if ($dbFilm) {
					$dbFilmId = $dbFilm->getId();
				} else {
					$dbFilmId = $this->mapFilm($filmId);
				}
				$val['product_id'] = $dbFilmId;
			} else if (isset($val['package'])) {
				$packageId = $val['package']['@attributes']['id'];
				unset($val['package']);
				$query = Doctrine_Query::create()
							   ->from('Product data')
							   ->select('data.id')
							   ->where('data.type = "package" AND data.eventival_id = ?', $packageId);
				$dbPackage = $query->fetchOne();
				if ($dbPackage) {
					$dbPackageId = $dbPackage->getId();
				} else {
					$dbPackageId = $this->mapPackage($packageId);
				}
				$val['product_id'] = $dbPackageId;
			}

			$val['eventival_id'] = $val['id'];

			//From piletilevi
			foreach($piletileviArray['concerts']['concert'] as $concert) {
				$code = substr($concert['title'], 0, strpos($concert['title'], " "));
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

			unset($val['id']);
			unset($val['presentation']);
			unset($val['qa']);

			if ($action == 'create') {
				$this->createData('Screening', $val);
			} else {
				$this->updateData('Screening', $val, $action);

			}
		}
	}

	private function mapCinemas() {
		// Because english names are located at a different XML file
		$request = new FetchEventivalXMLWebRequest(
				array('url' =>'http://www.eventival.eu/poff/14/en/ws/2ae44138cee5011f9cd2d474f11bfbd9/films/cinemas.xml')
							             );
		$enArray = $request->send()->getResponseArray();

		foreach($this->responseArray['cinema'] as $index => $cinema) {
			$action = $this->checkData($cinema['id']);

			$enName = $enArray['cinema'][$index]['name'];
			$cinema['eventival_id'] = $cinema['id'];

			$cinema['Translation']  = array('et' => array('name' => $cinema['name']),
										    'en' => array('name' => $enName)
									  );

			// Extract CinemaHall data from Cinema
			$halls = $cinema['cinema_halls'];
			$enHalls = $enArray['cinema'][$index]['cinema_halls'];

			// Single and many Cinema Hall are parsed differently
			if (!isset($halls['cinema_hall']['id'])) {
				$halls = array_pop($halls);
				$enHalls = array_pop($enHalls);
			}

			unset($cinema['cinema_halls']);
			unset($cinema['name']);
			unset($cinema['id']);

			if ($action == 'create') {
				$cinId = $this->createData('Cinema', $cinema);
			} else {
				$cinId = $action;
				$this->updateData('Cinema', $cinema, $action);
			}

			//cinema halls
			foreach($halls as $index => $hall) {
				$enHall = $enHalls[$index]['name'];

				$hall['eventival_id'] = $hall['id'];
				$hall['cinema_id']	  =	$cinId;
				$hall['Translation']  = array('et' => array('name' => $hall['name']),
										      'en' => array('name' => $enHall)
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

	private function mapCinema($cinema) {

	}

	private function mapCinemaHall($hallID) {
		$url = 'http://www.eventival.eu/poff/14/et/ws/2ae44138cee5011f9cd2d474f11bfbd9/films/cinemas.xml';
		$request = new FetchEventivalXMLWebRequest(array('url' => $url));
		$cinemaArray = $request->send()->getResponseArray();

		$url = 'http://www.eventival.eu/poff/14/en/ws/2ae44138cee5011f9cd2d474f11bfbd9/films/cinemas.xml';
		$request = new FetchEventivalXMLWebRequest(array('url' => $url));
		$engCinemaArray = $request->send()->getResponseArray();
		foreach($cinemaArray['cinema'] as $index => $cinema) {
			foreach($cinema['cinema_halls'] as $index => $halls) {
				if(@is_array($halls[0])) {
					foreach($halls as $indexHall => $hall) {
						if ($hall['id'] == $hallID) {
							$cinemaId = $cinema['id'];
							$cin = $cinema;
							$engCin = $engCinemaArray['cinema'][$index];
							$saveHall = $hall;
							$engHall = $engCinemaArray['cinema'][$index]['cinema_halls'][$indexHall];
							break;
						}
					}
				} else {
					if ($halls['id'] == $hallID) {
						$cinemaId = $cinema['id'];
						$cin = $cinema;
						$engCin = $engCinemaArray['cinema'][$index];
						$saveHall = $halls;
						$engHall = $engCinemaArray['cinema'][$index]['cinema_halls'];
						break;
					}
				}
			}
		}
		$query = Doctrine_Query::create()
						   ->from('Cinema data')
						   ->select('data.id')
						   ->where('data.eventival_id = ?', $cinemaId);
		$dbCinema = $query->fetchOne();
		if ($dbCinema) {
			$dbCinemaId = $dbCinema->getId();
		} else {
			$dbCinemaId = $this->mapCinema($cin);
		}
		$val['eventival_id'] = $hallID;
		$val['cinema_id'] = $dbCinemaId;
		$val['Translation'] = array('et' => array('name' => $saveHall['name']),
									'en' => array('name' => $engHall['name'])
							  );

		return  $this->createData('CinemaHall', $val);
	}

	private function mapPackages() {

	}

	private function mapFilms() {
		//print_r($this->responseArray['item']);
		$i = 0;
		echo '<u>ALL: '.count($this->responseArray['item']).'</u><br /><br /><br />';
		foreach($this->responseArray['item'] as $film) {
		    $i++;
			//if($i>28) {
			echo '<b>#'.$i.'</b><br />';
			$this->mapFilm($film['id']);
			echo '<br /><br />';
			//sleep(5);
            //if(is_integer($i/30)) sleep(180);
			//}
		}
	}

	public function mapPackage($packageID) {
		$url = 'http://www.eventival.eu/poff/14/et/ws/2ae44138cee5011f9cd2d474f11bfbd9/film-packages/'.$packageID.'.xml';
		$request = new FetchEventivalXMLWebRequest(array('url' => $url));
		$packageArray = $request->send()->getResponseArray();

		$action = $this->checkData($packageArray['ids']['system_id']);

		$package['eventival_id'] = $packageArray['ids']['system_id'];
		$package['title_original'] = $packageArray['titles']['title_original'];
		$package['Translation'] = array('et' => array('name' => is_array($packageArray['titles']['title_local']) ? '' : $packageArray['titles']['title_local'],
												   ),
									 'en' => array('name' => is_array($packageArray['titles']['title_english']) ? '' : $packageArray['titles']['title_english'],
												   )
							  );
		$package['code'] = time();

		if ($action == 'create') {
			$id = $this->createData('ProductPackage', $package);
			foreach ($packageArray['film_ids']['id'] as $film) {
				$query = Doctrine_Query::create()
							   ->from('Product data')
							   ->select('data.id')
							   ->where('data.type = "film" AND data.eventival_id = ?', $film);
				$dbFilm = $query->fetchOne();
				if ($dbFilm) {
					$dbFilmId = $dbFilm->getId();
				} else {
					$dbFilmId = $this->mapFilm($film, 'ProductPackageFilm');
				}
				$packageVsFilm = new ProductVsProduct();
				$packageVsFilm->fromArray(array(
					'product1' => $id,
					'product2' => $dbFilmId
				));
				$packageVsFilm->save();
			}
		} else {
			//UPDATE
			$id = $action;
		}
		return $id;
	}

	private function mapFilm($filmID, $type = 'Product') {
	    if(strlen(join('',file('http://www.eventival.eu/poff/14/et/ws/2ae44138cee5011f9cd2d474f11bfbd9/films/'.$filmID.'.xml')))<300) return false;

		echo $url = 'http://www.eventival.eu/poff/14/et/ws/2ae44138cee5011f9cd2d474f11bfbd9/films/'.$filmID.'.xml';
		$request = new FetchEventivalXMLWebRequest(array('url' =>$url));
		$filmArray = $request->send()->getResponseArray();

		//$url = 'http://www.eventival.eu/poff/14/en/ws/2ae44138cee5011f9cd2d474f11bfbd9/films/'.$filmID.'.xml';
		//$request = new FetchEventivalXMLWebRequest(array('url' =>$url));
		//$filmArray2 = $request->send()->getResponseArray();

		$action = $this->checkData($filmArray['ids']['system_id']);

		//TODO: redo validation
		$film['eventival_id'] = $filmArray['ids']['system_id'];
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
		$film['director_name'] = is_array($filmArray['publications']['en']['directors']) ?
			implode(',', $filmArray['publications']['en']['directors']) : $filmArray['publications']['en']['directors'];
		if($film['director_name']=="")  {
			$film['original_title'] = $filmArray['titles']['title_original'];
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


		//$film['country'] = is_array($filmArray['film_info']['countries']['country']) ?
		//implode(',', $filmArray['film_info']['countries']['country']) : $filmArray['film_info']['countries']['country'];
		$film['year'] = is_array($filmArray['film_info']['completion_date']['year']) ? null : $filmArray['film_info']['completion_date']['year'];
		$film['runtime'] = is_array($filmArray['film_info']['length']) ? null : $filmArray['film_info']['length'];
		//$film['languages'] = is_array($filmArray['publications']['en']['languages']) ?
		//implode(',', $filmArray['publications']['en']['languages']) : $filmArray['publications']['en']['languages'];
		//$film['subtitles'] = is_array($filmArray['publications']['en']['subtitles']) ?
		//implode(',', $filmArray['publications']['en']['subtitles']) : $filmArray['publications']['en']['subtitles'];
		$film['trailer_link'] = is_array($filmArray['film_info']['online_trailer_url']) ? null : $filmArray['film_info']['online_trailer_url'];

		foreach($filmArray['publications']['en']['crew']['contact'] as $filmcrew) {

			if($filmcrew['type']['id']==6) $film['music'] = $filmcrew['text'];
		    if($filmcrew['type']['id']==7) $film['editor'] = $filmcrew['text'];
		    if($filmcrew['type']['id']==9) $film['production'] = $filmcrew['text'];
			if($filmcrew['type']['id']==127) $film['world_sales'] = $filmcrew['text'];
		    if($filmcrew['type']['id']==126) $film['distributor'] = $filmcrew['text'];
		    if($filmcrew['type']['id']==15) $film['cast'] = $filmcrew['text'];

		}

        //exit;
		//TODO: Check if required
		$film['scheluded'] = '';
		$film['code'] = time();
		if ($action == 'create') {
			$id = $this->createData($type, $film);
		} else {
			$this->updateData('Product', $film, $action);
			$id = $action;
		}

     $this->getData('ProductGroup',1);
     $ProductVsProductGroup['product_id'] = $id;

      if(isset($filmArray['eventival_categorization']['sections']['section'][0])) {      	foreach($filmArray['eventival_categorization']['sections']['section'] as $groupProduct) {
      		$actionGroup = $this->checkData($groupProduct['id'],1);
	        $checkCount =  count($this->getDataVs('ProductVsProductGroup',$id,$actionGroup));

	        //print_r($ProductVsProductGroup);
			if ($checkCount == 0 and $actionGroup != 'create') {
				$ProductVsProductGroup['group_id'] = $actionGroup;
				$this->createData('ProductVsProductGroup', $ProductVsProductGroup, 0);
			}

      	}
      }
      else {
	        $actionGroup = $this->checkData($filmArray['eventival_categorization']['sections']['section']['id'],1);
	        $checkCount =  count($this->getDataVs('ProductVsProductGroup',$id,$actionGroup));

	        //print_r($ProductVsProductGroup);
			if ($checkCount == 0 and $actionGroup != 'create') {
				$ProductVsProductGroup['group_id'] = $actionGroup;
				$this->createData('ProductVsProductGroup', $ProductVsProductGroup, 0);
			}
	  }
		return $id;
	}

	private function mapSections() {
		$url = 'http://www.eventival.eu/poff/14/et/ws/2ae44138cee5011f9cd2d474f11bfbd9/films/sections.xml';
		$request = new FetchEventivalXMLWebRequest(array('url' =>$url));
		$groupArray = $request->send()->getResponseArray();

		$url = 'http://www.eventival.eu/poff/14/en/ws/2ae44138cee5011f9cd2d474f11bfbd9/films/sections.xml';
		$request = new FetchEventivalXMLWebRequest(array('url' =>$url));
		$groupArray2 = $request->send()->getResponseArray();

		$group2 =  $groupArray2['section'];
        $i = 0;
		foreach ($groupArray['section'] as $group) {
			$product_group = '';
			$product_group2 = '';
			$product_group['title'] = $group['name'];
			$product_group['level'] = 1;
			$product_group['lft'] = 2;
			$product_group['eventival_id'] = $group['id'];

			$product_group2 = $group2[$i];

			$product_group['Translation'] = array('et' => array('name' => is_array($group['name']) ? '' : $group['name'],
			                                       'description' => is_array($group['description']) ? '' : $group['description']),
									 'en' => array('name' => is_array($product_group2['name']) ? '' : $product_group2['name'],
									               'description' => is_array($product_group2['description']) ? '' : $product_group2['description']),
									 'ru' => array('name' => is_array($product_group2['name']) ? '' : $product_group2['name'],
									               'description' => is_array($product_group2['description']) ? '' : $product_group2['description'])
							  );
           $action = $this->checkData($product_group['eventival_id']);

            if ($action == 'create') {
				$id = $this->createData('ProductGroup', $product_group);
			} else {
				$this->updateData('ProductGroup', $product_group, $action);
				$product_group['Translation'] = array(
									 'en' => array('name' => is_array($product_group2['name']) ? '' : $product_group2['name'],
									               'description' => is_array($product_group2['description']) ? '' : $product_group2['description'])
							  );
				$this->updateData('ProductGroup', $product_group, $action);
				$id = $action;
			}
            $i++;
		}
        return false;
	}

	private function getDataVs($object,$id,$group_id) {
		$query = Doctrine_Query::create()
						   ->from($object . ' data')
						   //->select('data.*');
						   ->where('data.product_id = ?' , $id)
						   ->andWhere('data.group_id = ?' , $group_id);

		return $query->fetchArray();
	}


	private function getData($object,$mydata=0) {
		$query = Doctrine_Query::create()
						   ->from($object . ' data')
						   ->select('data.id, data.eventival_id');
		$data = $query->fetchArray();

		if($mydata) $this->mydata = $data;
		else $this->data = $data;
	}

	// Returns 'create' OR id of item to update
	//TODO : Add check for deleteData
	private function checkData($id,$mydata=0) {
		// TODO: Rewrite search in a more optimized way
		if($mydata) $adata = $this->mydata;
		else $adata = $this->data;

		foreach ($adata as $data) {
			if ($data['eventival_id'] == $id) {
				return $data['id'];
			}
		}
		return 'create';
	}

	private function createData($object, $data, $id=1) {
		$createObject = new $object();
		$createObject->fromArray($data);
		$createObject->save();

		if($id==1) return $createObject->getId();
	}

	private function updateData($object, $data, $id) {
		$obj = Doctrine_Query::create()
				->select('data.*')
				->from($object . ' data')
				->where('id = ?', $id)
				->fetchOne();
		$obj->synchronizeWithArray($data);
		$obj->save();
	}

	//TODO: Add delete support
	private function deleteData($object, $id) {
		$query = Doctrine_Query::create()
			->delete($object . ' data')
			->where('data.id = '.$id);

		$query->execute();
	}

	public function convertResponse2Array() {
	    //$xml = false;
        //$xml = @simplexml_load_string($this->response);
        //if ($xml)
        return $this->objectsIntoArray(@simplexml_load_string($this->response));
        //else return array();
	}

	private function objectsIntoArray($arrObjData, $arrSkipIndices = array()) {
		$arrData = array();

		// if input is object, convert into array
		if (is_object($arrObjData)) {
			$arrObjData = get_object_vars($arrObjData);
		}

		if (is_array($arrObjData)) {
			foreach ($arrObjData as $index => $value) {
				if (is_object($value) || is_array($value)) {
					$value = $this->objectsIntoArray($value, $arrSkipIndices); // recursive call
				}
				if (in_array($index, $arrSkipIndices)) {
					continue;
				}
				$arrData[$index] = $value;
			}
		}
		return $arrData;
	}
}