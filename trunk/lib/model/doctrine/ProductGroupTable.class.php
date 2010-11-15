<?php

class ProductGroupTable extends PriorityNestedTable
{
	public function findAll( $hydrationMode = null ){
		$q = Doctrine::getTable('ProductGroup')->createQuery('prodgroup')
				->from('ProductGroup pg');
				
		return $this->addDefaultSort( $q )->execute();
	}
	
	
	public function findAllQuery(){
		return Doctrine::getTable('ProductGroup')->createQuery('prodgroup')
				->from('ProductGroup pg');		
	}
	
	public function addNoRootContstraint( Doctrine_Query $q ){
		return $q->andWhere($q->getRootAlias().'.level > ?' , 0 );
	}
	
	public function addFrontendViewConstraints( Doctrine_Query $q, $culture ){
		return $this->addNoRootContstraint($q)
				->leftJoin("c.Translation t WITH t.lang = ? AND t.name != ''" , $culture);
				//->innerJoin('c.Translation t WITH t.lang = ?', $culture);
	}
	
	public function getActiveProductGroups(){
		return $this->findAll();	
	}
	
	
	public function addDefaultSort(Doctrine_Query $q){
		return $q->orderBy( $q->getRootAlias(). '.lft ASC');
	}
	
	public function getRoot(){
		$roots = $this->getTree()->fetchRoots();
		return $roots[0];
	}
	
	public function findI18nSlug($slug){
		return $this->createQuery()
				->from('ProductGroup p')
				->innerJoin('p.Translation t WITH t.slug = ?', $slug)
				->execute();
	}

}