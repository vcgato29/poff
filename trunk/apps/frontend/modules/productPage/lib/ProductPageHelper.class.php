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


	public function getConnectedProducts(Product $product){
		$q = Doctrine_Query::create()
				->select('p.id, cp.*,cpt.*, cpp.*')
				->from('Product p')
				->leftJoin('p.ConnectedProducts cp')
				->innerJoin('cp.ProductPictures cpp')
				->innerJoin('cp.Translation cpt WITH cpt.lang = ? AND cpt.name != ""', $this->getUser()->getCulture())
				->where('p.id = ?', $product['id']);
				//->setHydrationMode(Doctrine::HYDRATE_ARRAY);

		$result = $q->fetchOne();

		if($result)
			return $result['ConnectedProducts'];
		else
			return array();

		

	}


	
	protected function getUser(){
		return sfContext::getInstance()->getUser();
	}
	


}