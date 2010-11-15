<?php

class ProductPageConfiguration{

	public function getCalculatorForm(){
		return new CalculatorForm();
	}

	public function getCalculatorData(){
		include(sfConfig::get('sf_root_dir') . '/kalkulaator_config.php');

		return array(
				'VIHMAVEE_SYSTEEMI_RUUTMEETRI_HIND' => $VIHMAVEE_SYSTEEMI_RUUTMEETRI_HIND,
				'LISATARVIKUTE_RUUTMEETRI_HIND' => $LISATARVIKUTE_RUUTMEETRI_HIND,
				'VANA_KATUSE_EEMALDAMISE_HIND' => $VANA_KATUSE_EEMALDAMISE_HIND,
				'pindala_vahemik' => $pindala_vahemik,
				'materjal' => $materjal,
				'k6rgus' => $k6rgus,
				'liigendus' => $liigendus,
				);
	}


	public function dropDownValues($whos){

		$data = $this->getCalculatorData();
		$result = array();

		switch($whos){
			case 'k6rgus':
			case 'liigendus':
				foreach($data[$whos] as $item)
					$result[$item['name']] = $item['coef'];
				break;
			case 'materjal':
				foreach($data[$whos] as $item)
					$result[$item['name']] = $item['price'];
				break;
			default:

				break;
		}

		return $result;

	}

}
