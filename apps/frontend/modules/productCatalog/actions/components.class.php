<?php
class productCatalogComponents extends sfComponents
{
	
	protected $firstLevel  = false;
	protected $activeProductGroupSubGroups = false;
	protected $subGroupProducts = false;
	
  public function executeRender()
  {
  	
  	
  	$node = $this->controller->getLastStructureElement();
	$this->lang = $node['lang'];
		
  	
	# select all first level product groups
	$this->productGroups = $this->getFirstLevel();
	# find which one is active [ if there is no requested subgroup, look for default one ]
	$this->activeFirstLevelProductGroup = $this->getFirstLevelActiveProductGroup();
	# for active product group find TWO subgroups
	
	
	$this->seoEffect();
	
	$this->subgroups = $this->findActiveProductGroupSubGroups();
	
	$this->form = new ProductContactForm();
	
	$this->products = $this->findSubGroupProducts();
	$this->activeProducts = $this->findActiveProductsInSubGroups();
	$this->productPictures = $this->findProductsPictures();
	$this->productMessages = $this->findProductMessages();
	
	//$this->findProductsPictures();
	
  	
  }
  
  
  public function seoEffect(){
  	
  	$gr = $this->getFirstLevelActiveProductGroup();
  	
  	$this->getResponse()->addMeta( 'keywords', $gr->getMetaKeywords() );
  	$this->getResponse()->addMeta( 'description', $gr->getMetaDescription() );
  	
  	$this->groupTitle = $gr->getMetaTitle(); 
  	
  }
  
  
  public function findActiveProductsInSubGroups(){
  	
  	$result = array();
  	$products = $this->findSubGroupProducts();
  	
  	foreach( $this->findActiveProductGroupSubGroups() as $subgroup ){
  		if( false ){
  			
  		}else{
  			$ar = current( $products[$subgroup['id']] );
  			$result[$subgroup['id']] = isset( $ar[0] ) ? $ar[0] : array(); 
  		}
  		
  		
  	}
  	
  	return $result;
  }
  
  
  public function findProductsPictures(){

  	$products = $this->findSubGroupProducts();

  	
  	$result = array();
  	
  	foreach( $products as $index => $subGroupProducts ){
  		foreach( $subGroupProducts as $product ){
			$result[$product['id']] = $product->getOneProductPictureByParameter( 'default' );
  		}
  	}
  	
  	return $result;
  }
  
  public function findProductMessages(){
  	$products = $this->findSubGroupProducts();
  	
  	$result = array();
  	
  	foreach( $products as $index => $subGroupProducts ){
  		foreach( $subGroupProducts as $product ){
			$result[$product['id']] = $this->getContext()->getI18N()->__( 'More information about product' , array('%product%' =>  $product['name'] ) );
  		}
  	}
  	
  	
  	return $result;  	
  }
  
  
  public function findSubGroupProducts(){
  	
  	$result = array();
  	if( !$this->subGroupProducts ){
	  	foreach( $this->findActiveProductGroupSubGroups() as $index => $subgroup ){
	  		$q = Doctrine::getTable('Product')->createQuery('products')
	  			->select('p.*, pt.*')
	  			->from('Product p')
	  			->innerJoin('p.Translation pt')
	  			->innerJoin('p.ProductGroups pg')
	  			->innerJoin('p.ProductPictures pp')
	  			->where('pg.group_id = ?', array( $subgroup['id'] ))
	  			->andWhere('pp.parameter = ?', 'default')
	  			->andWhere('pt.lang = ? AND pt.name != ?', array( $this->getUser()->getCulture(), '') );
	  		
	  		
			$result[$subgroup['id']] = $q->execute();
	
	  	}
	  	
	  	$this->subGroupProducts = $result;
  	}
  	
  	return $this->subGroupProducts;
  	
  }
  
  
  
  
  public function findActiveProductGroupSubGroups(){
  	$group = $this->getFirstLevelActiveProductGroup();
  	
	$z = Doctrine::getTable('ProductGroup')->createQuery('subgroups')
			->select('pg.*, pgt.*')
			->from('ProductGroup pg')
			->innerJoin('pg.Translation pgt')
			->where('pg.level = ?', 2 )
			->andWhere('pgt.lang = ? AND pgt.name != ?', array( $this->getUser()->getCulture(), '') )
			->andWhere('pg.lft > ? and pg.rgt < ?', array( $group['lft'], $group['rgt'] ) )
			->orderBy( 'pg.lft ASC' )
			->limit(2);
			
	if( !$this->activeProductGroupSubGroups )
		$this->activeProductGroupSubGroups = $z->execute();
		

	return $this->activeProductGroupSubGroups;
			
  }
  
  public function getFirstLevelActiveProductGroup(){
  	
  	if( $this->hasRequestParameter( $this->getGroupRequestParameter() ) ){
		return Doctrine::getTable('ProductGroup')->findOneBySlug( $this->getRequestParameter('g') );
  	}
  	$ar = $this->getFirstLevel();
  	return $ar[0];
  }
  
  public function getGroupRequestParameter(){
  	return ProductGroup::getRequestParameterName();
  }
  
  
  
  public function getFirstLevel()
  {
  	if( !$this->firstLevel )
		$this->firstLevel = Doctrine::getTable('ProductGroup')->createQuery('preview')
			->select('pg.*, pgt.*')
			->from('ProductGroup pg')
			->innerJoin('pg.Translation pgt')
			->where('pg.level = ? AND pg.picture IS NOT NULL AND pg.picture != ?', array( 1, '' ) )
			->andWhere('pg.picture_inactive IS NOT NULL AND pg.picture_inactive != ?', array( '' ) )
			->andWhere('pgt.lang = ? AND pgt.name != ?', array( $this->getUser()->getCulture(), '') )
			->orderBy( 'pg.lft ASC' )
			->limit(20)
			->execute();

	return $this->firstLevel;
  }
  
}