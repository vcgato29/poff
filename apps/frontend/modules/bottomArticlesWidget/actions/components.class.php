<?php

require_once(dirname(__FILE__) . '/../../article/actions/components.class.php');
class bottomArticlesWidgetComponents extends myComponents
{

	
  public function executeRender(){
	$this->bottomArticle = $this->getQuery()->execute()->getFirst();
  }
  
  public function getQuery(){
  	$q = Doctrine::getTable('Structure')->createQuery('ba')
  		->from('Structure s')
		->where('s.lang = ?', $this->getRoute()->getObject()->getLang())
		->andWhere('s.slug = ?', 'footer')
		->limit(1);
		
	return $q;
  }
  
  
}