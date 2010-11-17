<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of StructureLinkGen
 * We assume that Structure tree is not TOO BIG (max 1000 elements in tree)
 * nodesMap could be cached
 *
 * @author aneto
 */
class StructureLinkGen extends LinkGen{

	private static $nodesMap;

	protected function init(){
		$q = Doctrine_Query::create()
			->from('Structure s')
			->select('s.*')
			->where('s.level >= 1')
			->setHydrationMode(Doctrine::HYDRATE_ARRAY_HIERARCHY);

		$this->setData($q->execute());
	}


	public function linkParts($id, $additionalParams = array()){
		if(isset(self::$nodesMap[$id]))
			return empty($additionalParams) ? self::$nodesMap[$id] : array_merge(self::$nodesMap[$id], $additionalParams);
		return false;
	}


	protected function setData($data){
		parent::setData($data);

		$this->traverse($data,array());
		
	}

	private function traverse($data, $urlParts){
		foreach($data as $node){
			self::$nodesMap[$node['id']] =
				array_merge($urlParts, array('p' . ( $node['level'] -1 )=> $node['slug']));
			if(isset($node['__children']) && !empty($node['__children'])){
				$this->traverse($node['__children'], self::$nodesMap[$node['id']] );
			}
		}
	}



	public function  link($id, $additionalParams = array()) {
		return url_for('main_dispatcher', $this->linkParts($id,$additionalParams));
	}
}
?>
