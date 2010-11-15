<?php

class NewsLinkGen extends LinkGen{


	public function  collectionLinks($elements, $additionalParams = array()) {

		if(!isset($additionalParams['link_to_struct'])){
			$results = array();
			$ids = $this->getIds($elements);


			$nodes = Doctrine_Query::create()
				->select('ni.id,ni.slug, s.id')
				->from('NewItem ni')
				->innerJoin('ni.NewsGroup ng')
				->innerJoin('ng.Structure s')
				->whereIn('ni.id', $ids)
				->setHydrationMode(Doctrine::HYDRATE_SCALAR)
				->execute();


			foreach($nodes as $node){
				$results[$node['ni_id']] = $this->link($node['ni_id'],
					array_merge(
						array('link_to_struct' => $node['s_id'], 'slug' => $node['ni_slug']),
						$additionalParams
					)
				);
			}

			return $results;

		}else{
			return parent::collectionLinks($elements, $additionalParams);
		}
	}

	public function link($id, $additionalParams = array()){
		if(!isset($additionalParams['link_to_struct'])){
			throw new Exception('NewItem should be linked to structure element');
		}else{
			$link_to_struct = $additionalParams['link_to_struct'];
			unset($additionalParams['link_to_struct']);
		}

		$structNode = LinkGen::getInstance(LinkGen::STRUCTURE)->linkParts($link_to_struct);
		
		return url_for('newsItem_page_lvl_' . (count($structNode)-1), array_merge(
				$additionalParams,
				$structNode
		), true);
		
	}

	protected function init(){
		
	}
	
	public function linkParts($id, $additionalParams = array()){
		
	}

}

?>
