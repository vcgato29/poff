<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ScheduleLinkGen
 *
 * @author aneto
 */
class ScheduleLinkGen extends LinkGen {

	public function link($id, $additionalParams = array()){

		$nodeID = $this->getAction()->getRoute()->getObject()->getId();
		$nodeLink = LinkGen::getInstance(LinkGen::STRUCTURE)->linkParts($nodeID);


		return url_for('structure_actions',
			array_merge(
				array('id' => $id, 'p0' => $nodeLink['p0'], 'module' => 'schedule'),
				$additionalParams
			)
		);
	}

	protected function init(){

	}

	public function linkParts($id, $additionalParams = array()){

	}
	
}