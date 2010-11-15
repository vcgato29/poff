<?php
class seoComponents extends myComponents
{
	const ARTICLE_PAGE = 1;
	const CATEGORY_PAGE = 2;
	const PRODUCT_PAGE = 4;
	
  public function executePageTitle(){
	$route = $this->getRoute();
	$title = '';
	
	
	switch($this->getCurrentPageType()){
		case self::ARTICLE_PAGE:
			$title = $this->getStructurePageTitle($this->getRoute()->getObject());
			$title = $this->getRoute()->getObject()->getTitle() . " - " . $title;
			break;
		case self::PRODUCT_PAGE:
			$title = $this->getRoute()->getProductObject()->getName();
		case self::CATEGORY_PAGE:
			$title = $title . 
					' - ' . $this->getProductCategoryPageTitle($this->getRoute()->getCategoryObject());
	}
	$title = trim($title, ' - ');
	
	$this->title = $title;
	
  }
  
  
  public function executeMetas(){
  	$this->description = $this->generateMetaDescription();
  	$this->keywords = $this->generateMetaKeywords();
  }
  
    
  protected function generateMetaDescription(){
  	sfProjectConfiguration::getActive()->loadHelpers('StringFunc');
  	
  	$result = '';
  	switch($this->getCurrentPageType()){
  		case self::ARTICLE_PAGE: //pealkiri. Sisu (250 chars)
  			if($this->getRoute()->getObject()->getMetadescription()) return $this->getRoute()->getObject()->getMetadescription();
  			
  			$content = truncate(strip_tags( $this->getRoute()->getObject()->getTitle() . 
  							'. ' . $this->getRoute()->getObject()->getContent() ) , 250, ''  );
  			
  			break;
  		case self::CATEGORY_PAGE:  // category name, products
  			if($this->getRoute()->getCategoryObject()->getMetaDescription()) return $this->getRoute()->getCategoryObject()->getMetaDescription();
  			
  			$content = implode( ',' , $this->getProductCategoryPageWords($this->getRoute()->getCategoryObject()));
  			break;
  		case self::PRODUCT_PAGE: //toote nimi (kategooriad) - toode kirjelduse esimesed tähemärgid		
  			$content =  $this->getRoute()->getProductObject()->getName()
  						. ' (' . implode(', ', $this->getProductCategoryPageWords($this->getRoute()->getCategoryObject())) . ') '
  						. $this->getRoute()->getProductObject()->getDescription();
  			break;
  	}
  	$result = truncate(strip_tags($content), 250, '');
  	return $result;
  }
  
  
  protected function generateMetaKeywords(){
  	
  	switch($this->getCurrentPageType()){
  		case self::ARTICLE_PAGE:
  			if($this->getRoute()->getObject()->getMetakeywords())return $this->getRoute()->getObject()->getMetakeywords();
  			break;
  		case self::CATEGORY_PAGE:
			if($this->getRoute()->getCategoryObject()->getMetaKeywords())return $this->getRoute()->getCategoryObject()->getMetaKeywords();
  			break;
  	}
  	
  	$arr = preg_split("/[\s,()]+/", $this->generateMetaDescription());
  	foreach($arr as $i => $v){
  		if(strlen($v) > 3)
  			$arr[$i] = strtolower($v);
  		else
  			unset($arr[$i]);
  	}
  	
  	$arr = array_unique($arr);
  	return implode(', ', $arr);
  }
  
  
  protected function getCurrentPageType(){
  	$result = 0;
  	if($this->getRoute()->getObject()){
  		$result = self::ARTICLE_PAGE;
  	}
  	
    if($this->getRoute()->getCategoryObject()){
  		$result = self::CATEGORY_PAGE;
  	}
  	
    if($this->getRoute()->getProductObject()){
  		$result = self::PRODUCT_PAGE;
  	}

  	return $result;
  }

  protected function getProductCategoryPageTitle($obj){
  	return implode(' - ', $this->getProductCategoryPageWords($obj));
  }
  
  protected function getProductCategoryPageWords($obj){
  	$result = array();
  	$result[] = $obj['name'];
  		foreach($this->getCategoryAncestors($obj) as $anc){
			if($anc['title'] && $anc['level'] >= 1)
				$result[] = $anc['name'];
		}
		return $result;
  }
  
  protected function getStructurePageTitle($obj){
  	$title = '';
  	foreach($this->getStructureAncestors($obj) as $anc){
		if($anc['title'] && !$anc['isHidden'] && $anc['level']  > 1)
			$title = $anc['title'] .  " - " . $title;
	}
	
	return $title;
  }
  
  protected function getCategoryAncestors($cat){
  	return $cat->getNode()->getAncestors();
  }
  
  protected function getStructureAncestors($node){
  	return $node->getNode()->getAncestors();
  }
  
}