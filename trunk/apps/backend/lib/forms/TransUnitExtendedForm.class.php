<?php
class TransUnitExtendedForm extends BaseTransUnitForm{
	
	public function configure(){
		$this->useFields(array('variable_id','source','target','cat_id'));
		
		$this->widgetSchema['variable_id'] = new sfWidgetFormInputHidden();
		$this->widgetSchema['cat_id'] = new sfWidgetFormInputHidden();
		$this->widgetSchema['source'] = new sfWidgetFormInputHidden();
	}
	
	protected function getCatalogue(){
		
	}
	
	protected function createCatalogue(){
		
	}
	
	public function getCatalogueID($lang){
		$cat = Doctrine::getTable('Catalogue')->findOneByNameAndTargetLang($this->getCatalogueBaseName() . '.' . $lang,$lang);
		if($cat)return $cat['cat_id'];
		else{
			$cat = new Catalogue();
			$cat->fromArray(array('name' => $this->getCatalogueBaseName() . '.' . $lang , 'source_lang' => 'en', 'target_lang'=> $lang));
			$cat->save();
			return $cat['cat_id'];
		}
		
		
	}
	
	public function getCatalogueBaseName(){
		return "z";
	}
	
	static function getInstance(){
		return new TransUnitExtendedForm();
	}
}