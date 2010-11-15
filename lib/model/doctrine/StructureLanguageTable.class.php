<?php

class StructureLanguageTable extends StructureTable
{
	public function createLangNode( $langObj )
	{
		$langNode = new StructureLanguage();
		
		$langNode->title = $langObj['title_est'];
		$langNode->inherits_layout = 1;
		$langNode->url = $langObj['url'];
		$langNode->description = $langObj['url'];
		$langNode->pageTitle = $langObj['url'];
		$langNode->lang = $langObj['url'];
		$langNode->pri = 0;
		$langNode->parentID = $this->getRoot()->getId();
		
		$langNode->getNode()->insertAsLastChildOf( $this->getRoot() );
		
		return $langNode;
		
	}
	
	public function getRoot()
	{
		return Doctrine::getTable('Structure')->getRoot();
	}
	

}