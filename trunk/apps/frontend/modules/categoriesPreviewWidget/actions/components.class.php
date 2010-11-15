<?php
//require_once dirname(__FILE__).'/../../categoriesLeftMenuWidget/lib/CategoriesLeftMenuHelper.class.php';
class categoriesPreviewWidgetComponents extends myComponents
{
	

  public function executeRender(){
  	
//	$this->helper = $this->getHelper();
//	$this->categories = new Doctrine_Collection('ProductGroup');
//	foreach($this->getQuery()->execute() as $index => $cat){
//		if(!$this->helper->hiddenNode($cat)){
//			$this->categories->add($cat);
//		}
//	}

      $this->category = $this->getAction()->getRoute()->getCategoryObject();

      $this->banners = $this->getBanners();

	
  }

  protected function getBanners(){
  	$q = Doctrine::getTable('Banner')->createQuery('b')
  		->select('b.*')
  		->from('Banner b')
  		->innerJoin('b.BannerGroup bg')
  		->innerJoin('bg.StructureBannerGroups sbg')
  		->innerJoin('sbg.Structure s WITH s.id = ?', $this->getRoute()->getObject()->getId())
  		->where('bg.type = ?', 'logos')
  		->orderBy('b.pri asc')
  		->limit(3);

        return $q->execute();
  }
  
//  protected function getQuery(){
//  	$q = Doctrine::getTable('ProductGroup')->createQuery('categoriesMenu')
//				->select('c.*')
//				->from('ProductGroup c')
//				->where('c.level = ?', 1)
//				->andWhere('c.picture IS NOT NULL')
//				->orderBy('c.lft asc')
//				->setHydrationMode(Doctrine::HYDRATE_RECORD_HIERARCHY);
//
//	return Doctrine::getTable('ProductGroup')->addFrontendViewConstraints($q, $this->getUser()->getCulture());
//  }
//
//  protected function getHelper(){
//  	return new CategoriesLeftMenuHelper();
//  }
  
}