<?php
class TransUnitExtendedVariableForm extends TransUnitExtendedForm{
	
	public function getCatalogueBaseName(){
		return 'variables';
	}
	
	static function getInstance(){
		return new TransUnitExtendedVariableForm();
	}
	

}