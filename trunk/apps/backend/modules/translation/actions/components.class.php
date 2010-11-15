<?php

class translationComponents extends sfComponents
{
	public function executeChangeLanguageForm()
	{
		$abr = array();
		foreach( Doctrine::getTable('Language')->findAll() as $lang )
			$abr[] = $lang->getAbr();

		$this->abr = $abr;
	}
		
}