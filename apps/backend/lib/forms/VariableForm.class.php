<?php
class VariableForm extends BaseTransUnitVariableForm{
	
	
	public function configure(){
		
		if(!$this->isNew())
			$this->configureEmbeddedForms();	
	}
	
	protected function configureEmbeddedForms(){
		if($this->isVarMultilang()){
			// foreach lang embed TransUnit form
			$this->configureMultilang($this->getLangs());
		}else{
			// embed only one TransUnit form of default LANGUAGE (en)
			$this->configureUniversal();
		}
	}
	
	
	protected function configureUniversal(){
		return $this->configureMultilang(array(TransUnitVariable::UNIVERSAL_LANG));
	}
	
	protected function configureMultilang($langs){
		// embed existing variables
		foreach($this->getObject()->Variables as $var){
			if($var->Catalogue && in_array($var->Catalogue->target_lang, $langs)){
				$this->embedForm($var->Catalogue->target_lang, new TransUnitExtendedVariableForm($var));
			}
		}
		
		// embed new variables 
		foreach($langs as $lang){
			if(!isset($this[$lang])){
				$tu = new TransUnit();
				$tu->fromArray(array('source' => $this->getObject()->getVariable(), 
									 'target' => '', 
									 'variable_id' => $this->getObject()->getId() ,
									 'translated' => 1 ,
									 'cat_id' => TransUnitExtendedVariableForm::getInstance()->getCatalogueID($lang) ) );
				
				$this->embedForm($lang, new TransUnitExtendedVariableForm($tu));
			}
		}
	}
	
	public function updateObjectEmbeddedForms($values, $forms = null){
		
		foreach($this->getLangs() as $lang){
			$values[$lang]['source'] = $this->getValue('variable');
		}
		
		
		
		return parent::updateOBjectEmbeddedForms($values, $forms);
	}
	
	
	public function getLangs(){
		$result = array();
		foreach(Doctrine::getTable('Language')->findAll() as $lang){
			$result[] = $lang['abr'];
		}
		return $result;
	}
	
	protected function isVarMultilang(){
		if($this->isNew()){
			return $this->getDefault('multilang');
		}else{
			return $this->getObject()->getMultilang();
		}
	}
	
	public function save($con = null){
		$z = parent::save($con);
		
		//$z->Variables->delete(); // DELETE ALL VARIABLES
		
		sfToolkit::clearDirectory( sfConfig::get( 'sf_cache_dir' )  );
		return $z;
	}
}