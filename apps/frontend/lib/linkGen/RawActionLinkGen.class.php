<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of RawActionLinkGen
 *
 * @author aneto
 */
class RawActionLinkGen extends LinkGen{
	public function link($id, $additionalParams = array()){
		return url_for('plain_actions', $additionalParams);
	}

	protected function init(){

	}

	public function linkParts($id, $additionalParams = array()){

	}
}
?>
