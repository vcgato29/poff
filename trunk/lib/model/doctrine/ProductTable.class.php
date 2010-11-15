<?php

class ProductTable extends Doctrine_Table
{
	
	
	
	public function findAllQuery(){
		
		return $this->createQuery()
			->from('Product p');
	}
	
	public function findI18nSlug($slug){
		return $this->createQuery()
				->select('*')
				->from('Product p')
				->innerJoin('p.Translation t WITH t.slug = ?', $slug)
				->execute();
	}
	
	
	public function addProductPicturesJoin( Doctrine_Query $q, $pic_parameter = false ){
		
		if( !$pic_parameter )
			$result = $q->innerJoin( $q->getRootAlias().'.ProductPictures prod_pics' );
		else{
			$result = $q->innerJoin( $q->getRootAlias().'.ProductPictures prod_pics WITH prod_pics.parameter = ? ', $pic_parameter );
		}		
		

		return $result->addOrderBy('prod_pics.pri asc');
		
		
		
	}
	
	
	public function addProductTranslationJoin( Doctrine_Query $q, $lang = false ){
		if( !$lang )
			return $q->leftJoin( $q->getRootAlias().'.Translation trans' );
		else{
			return $q->leftJoin( $q->getRootAlias().'.Translation trans WITH trans.lang = ?', $lang );
		}
	}
	
	public function addProductCategoryJoin( Doctrine_Query $q ){
		$q->innerJoin( $q->getRootAlias() . '.ProductGroups.ProductGroup prod_group' );//->innerJoin('prod_cat_assoc.ProductGroup');
	}
	
	
	
	public function getAssociatedToCategoryProductsQuery( $catID ){
		
		return $this->createQuery('category_products')
			->from('Product p')
			->innerJoin('p.ProductGroups pg WITH pg.group_id = ?', $catID )
			->orderBy('p.pri asc');
	}
	
	
	public function getProductParameters( $id, $multilang = 0, $parameter = 'default' )
	{

            
            
		# get product
		$product = $this->find($id);
                

                

		# get product groups primary keys
		$prodGroups = $this->createQuery('asdasd')
                                    ->from('ProductGroup pg')
                                    ->innerJoin('pg.Products p')
                                    ->where('p.product_id = ?', $product['id'])
                                    ->execute();

		$prodGroupsKeys = $prodGroups->getPrimaryKeys();
		$prodGroupsKeys[] = -1;


                
                
		
		# full hierarchy of parameter groups
		$parameterGroups = Doctrine::getTable('ProductGroupVsParameterGroup')
			->findByProdgroupIds( $prodGroupsKeys );
                
			

		foreach( $parameterGroups as $parameterGroup ){
			$parameterGroups->merge( $parameterGroup->getNode()->getAncestors() );
		}
		
		
		# get all parameters of those parameter groups
		$q = Doctrine::getTable( 'Parameter' )->createQuery();

		if($multilang !== false){
			Doctrine::getTable( 'Parameter' )
						->addMultilangCriteria( $q, $multilang );
		}
		
		Doctrine::getTable( 'Parameter' )
					->addParamGroupCriteria( $q,  $parameterGroups->getPrimaryKeys() )
					->addParameterCriteria($q, $parameter);

                

		return $q->execute();					
			
	}
	
	static public function getLuceneIndex()
	{
	  ProjectConfiguration::registerZend();
	 
	  if (file_exists($index = self::getLuceneIndexFile()))
	  {
	    return Zend_Search_Lucene::open($index);
	  }
	 
	  return Zend_Search_Lucene::create($index);
	}
	 
	static public function getLuceneIndexFile()
	{
		//sfConfig::get('sf_environment')
	  return sfConfig::get('sf_data_dir').'/product.index/index';
	}

	static function getStructureProductsQuery()
	{
		return Doctrine::getTable('Structure')->createQuery('b')
			->select('s.*,sng.*,ng.*, pr.* ,p.*')
			->from('Structure s')
			->innerJoin('s.StructureProductGroup sng')
			->innerJoin('sng.ProductGroup ng')
			->innerJoin('ng.Products pr')
			->innerJoin('pr.Product p')
			->orderBy('s.pri, p.pri');
	}

	static function normalizeAssociatedProducts(Doctrine_Query $q)
	{
		$result = array();

		$c = 0;
		foreach($q->execute() as $node){
			$result[$c]['node'] = $node;//->toArray();
			$result[$c]['products'] = array();

			if(isset($node['StructureProductGroup'])){
				foreach($node['StructureProductGroup'] as $sng){
					if(isset($sng['ProductGroup']) && isset($sng['ProductGroup']['Products'])){
						foreach($sng['ProductGroup']['Products'] as $new){
							$result[$c]['products'][] = $new['Product'];//->toArray();
						}
					}
				}
			}
			++$c;
		}

		return $result;

	}

	/*
	 * main constraints for frontend modules
	 *
	 */
	static function commonActivityConstraints(Doctrine_Query $q, $culture = 'et'){
		if($q->hasAliasDeclaration('p') || $q->getRootAlias() == 'p'){
			$q->innerJoin('p.Translation constraintTranslation WITH constraintTranslation.lang = ? AND constraintTranslation.name != ""', $culture);
		}

		return $q;
	}
	


}