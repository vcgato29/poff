<?php

class XMLMapper extends SimpleWebResponseInterpretator{

	const PILETILEVI_URL = 'http://www.piletilevi.ee/xml.php?promoter=127756&shop_provider=pff';
	protected $data;

	public function execute( $response ){
		parent::execute($response);
		$this->setResponseArray($this->convertResponse2Array());
		unset($this->response);
	}

	protected function validateElement($element) {
		if (isset($element)) {
			if (is_array($element)) {
				if (!empty($element)) {
					$element = implode(',', $element);
				} else {
					$element = '';
				}
			} else {
				return $element;
			}
		} else {
			$element = '';
		}
		return $element;
	}

	protected function getData($object) {
		$query = Doctrine_Query::create()
						   ->from($object . ' data')
						   ->select('data.id, data.eventival_id')
						   ->where('data.eventival_id != ?', '');
		$data = $query->fetchArray();

		$this->data[$object] = $data;
	}

	// Returns false OR id of item to update
	protected function checkData($object, $id) {
		if (isset($this->data[$object])) {
			foreach ($this->data[$object] as $data) {
				if ($data['eventival_id'] == $id) {
					return $data['id'];
				}
			}
		}
		return false;
	}

	protected function createData($object, $data) {
		$createObject = new $object();
		$createObject->fromArray($data);
		if ($object != 'ProductGroup') {
			$createObject->save();
		} else {
			$query = Doctrine_Query::create()->select('id')->from('ProductGroup')->where('level = ?', '0');
			$root = $query->fetchOne();
			$createObject->getNode()->insertAsLastChildOf($root);
		}
		return $createObject->getId();
	}

	protected function updateData($object, $data, $id) {
		$obj = Doctrine_Query::create()
				->select('data.*')
				->from($object . ' data')
				->where('id = ?', $id)
				->fetchOne();
		$obj->synchronizeWithArray($data);
		$obj->save();
	}

	public function convertResponse2Array() {
		$xml = simplexml_load_string($this->response, 'SimpleXMLElement', LIBXML_NOCDATA);

		return $this->xmlIntoArray($xml);
	}

	private function xmlIntoArray($xmlData, $arrSkipIndices = array()) {
		$arrData = array();

		// if input is object, convert into array
		if (is_object($xmlData)) {
			$xmlData = get_object_vars($xmlData);
		}

		if (is_array($xmlData)) {
			foreach ($xmlData as $index => $value) {
				if (is_object($value) || is_array($value)) {
					$value = $this->xmlIntoArray($value, $arrSkipIndices); // recursive call
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