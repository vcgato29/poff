<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ProductGroupLinkGen
 * We assume that ProductGroup tree is not TOO big (MAX 1000 elements)
 * In production groupMap should be cached
 *
 * @author aneto
 */
class ProductGroupLinkGen extends LinkGen{

	static $groupMap;

	protected function init(){
		$q = Doctrine_Query::create()
			->from('ProductGroup pg')
			->leftJoin('pg.Translation pgt')
			->innerJoin('pg.StructureProductGroup spg')
			->innerJoin('spg.Structure s WITH s.lang = ?', Doctrine::getTable('Language')->findOneByAbr($this->getCulture())->getUrl())
			->setHydrationMode(Doctrine::HYDRATE_ARRAY_HIERARCHY);

		$this->setData($q->execute());
	}


	protected function setData($data){
		$this->traverse($data);
	}

	private function traverse($data){
		foreach($data as $node){
			self::$groupMap[$node['id']] = array(
				'node' => $node['StructureProductGroup'][0]['Structure']['id'],
				'group' => array('c1' => $node['Translation'][$this->getCulture()]['slug'])
			);

			if(isset($node['__children']) && !empty($node['__children'])){
				$this->traverse($node['__children']);
			}
		}
	}


	public function link($id,$additionalParams = array()){

		if(($linkParts = $this->linkParts($id, $additionalParams))){
			$route = $linkParts['route'];
			unset($linkParts['route']);
			return url_for($route, $linkParts);
		}
		else
			return '#no_group_link';



	}

	public function linkParts($id,$additionalParams = array()){

		$nodeParts = LinkGen::getInstance(LinkGen::STRUCTURE)->linkParts(self::$groupMap[$id]['node']);
		$route = 'category_page_lvl_' . (count($nodeParts));
		$groupParts = self::$groupMap[$id]['group'];

		return array_merge($nodeParts ,$groupParts, array('route' => $route) ,$additionalParams);
	}
}
?>