<?php

class TransUnitExtendedTranslationForm extends TransUnitExtendedForm{
	public function configure(){
		parent::configure();
		$this->widgetSchema['target'] = new sfWidgetFormInput();
	}
	public function getCatalogueBaseName(){
		return 'messages';
	}
	
	static function getInstance(){
		return new TransUnitExtendedTranslationForm();
	}
}