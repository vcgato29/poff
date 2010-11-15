<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SignInLinkGen
 *
 * @author aneto
 */
class SignInLinkGen extends LinkGen{
	
	public function link($id, $additionalParams = array()){
		if(!isset($id))
			$id = $this->getAction()->getRoute()->getObject()->getId();

		$structNode = LinkGen::getInstance(LinkGen::STRUCTURE)->linkParts(
			$id
		);

		return url_for('structure_actions', array_merge(
				array('p0' => $structNode['p0']),
				array('action' => 'signIn', 'module' => 'publicUserRegistration'),
				$additionalParams
		));

	}

	protected function init(){

	}

	public function linkParts($id, $additionalParams = array()){

	}
}
?>
