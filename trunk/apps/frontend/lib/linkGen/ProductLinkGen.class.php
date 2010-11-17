<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ProductLinkGen
 *
 * @author aneto
 */
class ProductLinkGen extends LinkGen {

	protected function init(){
		
	}

    public function collectionLinks($elements, $additionalParams = array()){
		$links = array();

		foreach($this->collectionLinkParts($elements, $additionalParams) as $id => $linkParts){
				if(!isset($linkParts['route'])){
					$links[$id] = '#nolink';
					continue;
				}
				$route = $linkParts['route'];
				unset($linkParts['route']);
				$links[$id] = url_for($route, $linkParts);
		}

		return $links;
	}


	


	public function getRoute(){
		
	}

	public function getRoutePrefix(){
		return 'product_page_lvl_';
	}

	// very inefficient method
	public function link($id,$additionalParams = array()){
		$data = $this->collectionLinks(array(array('id' => $id)), $additionalParams);

		return $data[$id];
	}

	public function linkParts($id,$additionalParams = array()){
		throw new Exception('todo method');
	}


	public function collectionLinkParts($elements, $additionalParams = array()){

		
		$ids = $this->getIds($elements);

		

//		if(count($elements) == 1){
//			print_r($ids);
//			exit;
//		}

		$result = array();
//		print_r($ids);
//		exit;

		$res = $this->getQuery($ids)
				->execute();


		if(!empty($res)){
			foreach($res as $product){


				//print_r($node);exit;
				$structNode =  $product['ProductGroups'][0]['ProductGroup']['LinkedStructures'][0]['Structure'];
				$group = $product['ProductGroups'][0]['ProductGroup'];

				if(($parts = $this->getProductGroupLinkParts($group['id']) )){
					$result[$product['id']] =
								array_merge(
										$parts,
										$additionalParams,
										array(
											'product_slug' => $product['Translation'][$this->getCulture()]['slug'],
											'route' => $this->getRoutePrefix() . ($structNode['level'] - 1)
											)
					);

				}else{
					$result[$product['id']] = array();
				}


			}
		}

		foreach($ids as $id){
			if(!isset($result[$id]))
				$result[$id] = array();
		}



		return $result;
	}
	
	protected function getProductGroupLinkParts($id){
		return LinkGen::getInstance(LinkGen::PRODUCT_GROUP)->linkParts($id);
	}
	
	protected function getQuery($ids){
		
		$q =  Doctrine_Query::create()
			->from('Product p')
			->select('p.*,pt.*,pgvp.*,pg.*,pgt.*,spg.*,s.*')
			->innerJoin('p.ProductGroups pgvp')
			->innerJoin('pgvp.ProductGroup pg')
			->innerJoin('pg.LinkedStructures spg')
			->innerJoin('spg.Structure s WITH s.lang = ?', array( Doctrine::getTable('Language')->findOneByAbr($this->getCulture())->getUrl()))
			->innerJoin('pg.Translation pgt WITH pgt.lang = ?', 'en')
			->innerJoin('p.Translation pt WITH pt.lang = ? AND pt.name != ""', $this->getCulture())
			->whereIn('p.id', $ids)
			->andWhereIn('pg.parameter', array('default','fest'))
			->setHydrationMode(Doctrine::HYDRATE_ARRAY);
			
			
		return $q;
	}


	
}
