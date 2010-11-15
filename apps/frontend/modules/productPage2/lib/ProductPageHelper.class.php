<?php

class ProductPageHelper{

	static $productParameters = false;

    public function getProductParameters(Product $product){

		if(!self::$productParameters){

                $txtFieldParameters = array();
                $picParameters = array();
                $htmlParameters = array();
                $articleParameters = array();


                $params = Doctrine::getTable('Product')->getProductParameters($product['id'],1);


                $ppvs = Doctrine::getTable('ParameterProductValue')
                            ->createQuery()
                            ->select('ppv.*, p.*,t.*,ptr.*')
                            ->from('ParameterProductValue ppv')
                            ->andWhere('ppv.product_id = ?', $product['id'])
                            ->leftJoin('ppv.Translation t ')
                            ->innerJoin('ppv.Parameter p')
							->innerJoin("p.Translation ptr WITH ptr.lang = ? AND ptr.name != ''", $this->getUser()->getCulture())
                            ->andWhereIn('p.id', $params->getPrimaryKeys())
                            ->execute();



                foreach($ppvs as $ppv){

                    switch($ppv['Parameter']['type']){
                        case 'TEXTFIELD':
                            $txtFieldParameters[$ppv['Parameter']['name']] = $ppv['value'];
                            break;
                        case 'PICTURE':
                            $picParameters[$ppv['Parameter']['name']] = $ppv['value'];
                            break;
                        case 'HTML':
                            $htmlParameters[$ppv['Parameter']['name']] = $ppv['value'];
                            break;
                        case 'ARTICLE':
                            $articleParameters[] = array('title' => $ppv['Parameter']['name'],
                                                         'action' => 'paramArticle',
                                                        'id' => $ppv['id']) ;
                            break;
                    }

                }




                self::$productParameters = array('txt' => $txtFieldParameters,
                            'pic' => $picParameters,
                            'html' => $htmlParameters,
                            'article' => $articleParameters);
		}





                return self::$productParameters;
    }


	public function getProfilePrice($values){
		$result = 0;
		$purePrice = 0;
		$percent = 0;
		

		if(($vahemik = $this->getPindalaVahemikFor($this->getPindala($values)))){
			$purePrice = $result = $this->getPindala($values) * $values['materjal'] * $vahemik['install_coef'];
		}else{
			$purePrice = $result = $this->getPindala($values) * $values['materjal'];
		}
			
		
		if(isset($values['liigendus']) && $values['liigendus']){
			$result = $purePrice * $values['liigendus'];
		}

		if(isset($values['kõrgus']) && $values['kõrgus']){
			$result = $result + (($purePrice * $values['kõrgus']) - $purePrice);
		}


		return $result;
	}


	public function getOldRoofRemovingPrice($values){

		if($values['vana katuse eemaldamine'] == 0)return 0;

		$result = 0;
		$purePrice = 0;
		$percent = 0;
		
		if(($vahemik = $this->getPindalaVahemikFor($this->getPindala($values)))){
			$purePrice = $result = $this->getPindala($values) *  $vahemik['remove_coef'] * $this->getRoofRemovingConstant();
		}else{
			$purePrice = $result = $this->getPindala($values) * $this->getRoofRemovingConstant();
		}


		if(isset($values['liigendus']) && $values['liigendus']){
			$result = $purePrice * $values['liigendus'];
		}

		if(isset($values['kõrgus']) && $values['kõrgus']){
			$result = $result + (($purePrice * $values['kõrgus']) - $purePrice);
		}

		return $result;
		
			
	}


	public function getAdditionalStuffPrice($values){
		$pindala = $values['laius'] * $values['pikkus'];
		$configuration = new ProductPageConfiguration();
		$data = $configuration->getCalculatorData();

		return $pindala * $data['LISATARVIKUTE_RUUTMEETRI_HIND'];
	}

	public function waterSystemPrice($values){

		$pindala = $values['laius'] * $values['pikkus'];
		$configuration = new ProductPageConfiguration();
		$data = $configuration->getCalculatorData();


		return $pindala * $data['VIHMAVEE_SYSTEEMI_RUUTMEETRI_HIND'];
	}


	public function getTotalPrice($values){
		return $this->waterSystemPrice($values) +
				$this->getAdditionalStuffPrice($values) +
				$this->getOldRoofRemovingPrice($values) +
				$this->getProfilePrice($values);
	}

	protected function getRoofRemovingConstant(){
		$configuration = new ProductPageConfiguration();
		$data = $configuration->getCalculatorData();
		return $data['VANA_KATUSE_EEMALDAMISE_HIND'];
	}

	protected function getPindala($values){
		return $values['laius'] * $values['pikkus'];
	}

	protected function getCalculatorData(){
		$configuration = new ProductPageConfiguration();
		return $configuration->getCalculatorData();
	}


	protected function getPindalaVahemikud(){
		$data = $this->getCalculatorData();

		return $data['pindala_vahemik'];
	}

	protected function getPindalaVahemikFor($pindala){
		foreach($this->getPindalaVahemikud() as $pindalaItem){
			if($pindalaItem['start'] <= $pindala && $pindalaItem['end'] >= $pindala){
				return $pindalaItem;
			}
		}


		return false;
	}

	protected function getUser(){
		return sfContext::getInstance()->getUser();
	}
	


}