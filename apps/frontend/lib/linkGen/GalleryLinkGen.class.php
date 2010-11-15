<?php

class GalleryLinkGen extends LinkGen{

	public function link($id, $additionalParams = array()){
		if(!isset($additionalParams['link_to_struct'])){
			throw new Exception('Gallery should be linked to structure element');
		}else{
			$link_to_struct = $additionalParams['link_to_struct'];
			unset($additionalParams['link_to_struct']);
		}

		$structNode = LinkGen::getInstance(LinkGen::STRUCTURE)->linkParts($link_to_struct);

		return url_for('gallery_page_lvl_' . (count($structNode)-1), array_merge(
				$additionalParams,
				$structNode
		));

	}

	protected function init(){

	}

	public function linkParts($id, $additionalParams = array()){

	}

}

?>
