<?php

class TranslationForm extends BaseTransUnitForm{
	
	
	public function configure(){
		$this->useFields(array('id', 'source', 'cat_id'));
		
		$this->widgetSchema['id'] = new sfWidgetFormInputHidden();
		$this->widgetSchema['cat_id'] = new sfWidgetFormInputHidden();
		$this->validatorSchema['source'] = new sfValidatorPass();
		//$this->validatorSchema['translated'] = new sfValidatorPass();
		
		if(!$this->isNew())
			$this->configureMultilang($this->getLangs());
		
		$this->widgetSchema->setNameFormat('transunit[%s]');
	}
	
	public function embedTransUnitQuickTranslation($source, $langs){
	
		$this->embedExistingVariables($source, $langs);
		$this->embedNewVariables($source, $langs);

	}
	
	
	protected function configureMultilang($langs){
		if($this->isNew())throw new Exception('this method is apropriate to already saved objects only');
		
		// embed existing variables
		$this->embedExistingVariables($this->getObject()->getSource(), $this->getLangs());

		
		// embed new variables 
		$this->embedNewVariables($this->getObject()->getSource(), $this->getLangs());
	}
	
	public function embedNewVariables($source, $langs){
			foreach($langs as $lang){
			if(!isset($this[$this->getEmbedFieldName($source, $lang)])){
				$tu = new TransUnit();
				$tu->fromArray(array('target' => '', 
									 'translated' => 1,
									 'source' => $source,
									 'cat_id' => TransUnitExtendedTranslationForm::getInstance()->getCatalogueID($lang) ) );
				
				$this->embedForm($this->getEmbedFieldName($source, $lang), new TransUnitExtendedTranslationForm($tu, array(), false));
			}
		}
	}
	
	
	public function embedExistingVariables($source, $langs){
			foreach(Doctrine::getTable('TransUnit')->findBySource($source) as $index => $var){
				if($var->Catalogue && in_array($var->Catalogue->target_lang, $langs)){
					$var->setTranslated(1);
					$this->embedForm($this->getEmbedFieldName($var['source'], $var->Catalogue->target_lang), new TransUnitExtendedTranslationForm($var, array(), false));
				}
			}
	}
	
	public function getEmbedFieldName($source, $lang){
		return 'transunit_'. str_replace(array('%', ' '),array('_','_'),$source) . "_" . $lang;
	}
	
	public function getLangs(){
		$result = array();
		foreach(Doctrine::getTable('Language')->findAll() as $lang){
			$result[] = $lang['abr'];
		}
		return $result;
	}	
	
	
	public function bind(array $taintedValues = null, array $taintedFiles = null){

//		print_r($taintedValues);
//		exit;
		$taintedValues = array_merge($taintedValues, array('cat_id' => TransUnitExtendedTranslationForm::getInstance()->getCatalogueID('en')));
		
		return parent::bind($taintedValues, $taintedFiles);
	}
	
	
	
	
}