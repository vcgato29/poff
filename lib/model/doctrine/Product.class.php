<?php

/**
 * Product
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    jobeet
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 6820 2009-11-30 17:27:49Z jwage $
 */
class Product extends BaseProduct
{

	/*  syncronization with Directo */
	public function sync(){
//		$sync = new ProductSyncer(array($this->getId()));
//		return $sync->sync();
	}

	public function postSave($evt = null){
		Doctrine::getConnectionByTableName($this->getTable()->getTableName())->setAttribute(Doctrine_Core::ATTR_HYDRATE_OVERWRITE, false); // we do not want to refresh our records
		$this->updateLuceneIndex();
		Doctrine::getConnectionByTableName($this->getTable()->getTableName())->setAttribute(Doctrine_Core::ATTR_HYDRATE_OVERWRITE, true);
	}

	public function preSave($evt = null){

		Doctrine::getConnectionByTableName($this->getTable()->getTableName())->setAttribute(Doctrine_Core::ATTR_HYDRATE_OVERWRITE, false); // we do not want to refresh our records
		$this->updateSlug();
		Doctrine::getConnectionByTableName($this->getTable()->getTableName())->setAttribute(Doctrine_Core::ATTR_HYDRATE_OVERWRITE, true);

		return parent::preSave($evt);
	}

	// generate unique slug.
	public function updateSlug(){
		
		foreach($this->Translation as $index => $val){
			if(!$val['name'])continue;
			$newSlug = $val['slug'] ? $val['slug'] : oxtSluggableTranslit::urlize($val['name']);
			$origSlug = $newSlug;
			$c = 1;
			$col = $this->getTable()->findI18nSlug($newSlug);
			while($col->count() >= 1 ){
				if($col->count()==1 && $col->getFirst()->getId() == $this->getId())break;
				
				$newSlug = $origSlug . '-' .($c++);
				$col = $this->getTable()->findI18nSlug($newSlug);
			}
			
			$val['slug'] = $newSlug;

		}
	}
	
	
	public function updateLuceneIndex(){

		//delete existing entries
		$index = $this->getTable()->getLuceneIndex();
	 
		// remove existing entries
		foreach ($index->find('pk:'.$this->getId()) as $hit){
		  $index->delete($hit->id);
		}
		
		// create new Lucene document
		$doc = new Zend_Search_Lucene_Document();
		
		// store product primary key to identify it in the search results
  		$doc->addField(Zend_Search_Lucene_Field::Keyword('pk', $this->getId()));
					
		
  		$tr = Doctrine::getTable('ProductTranslation')->createQuery()
  				->from('ProductTranslation pt')
  				->where('pt.id = ?' , $this->getId())->execute();
  				

		$doc->addField(Zend_Search_Lucene_Field::UnStored('original_title', $this->getOriginalTitle(), 'utf-8'));
  		
  		// add fields to index depending on existing Translations
		foreach( $tr->toArray() as $transArr ){
			
			$lang = $transArr['lang'];
			unset($transArr['lang'], $transArr['id'],  $transArr['volume'], $transArr['slug']);
			
			foreach( $transArr as $field => $value ){
				$fieldName = $field . '_' . $lang; // (name_en, name_fi),  (description_en, description_fi)
				$doc->addField(Zend_Search_Lucene_Field::UnStored($fieldName, strip_tags($value), 'utf-8'));
			}
			
		}

		// add product to the index
		$index->addDocument($doc);
		$index->commit();
		
	}

	public function updateProductGroupConnections( $connections ){
		$this->deleteProductGroupConnections();
		
		
		foreach( $connections as $conn ){
			$rel = new ProductVsProductGroup();
			$rel->fromArray( array( 'group_id' => $conn, 'product_id' => $this->getId() ) );
			$rel->save();
		}
			
		$this->save();
	}
	
	public function deleteProductGroupConnections(){
			$this->ProductGroups->delete();
	}
	
	public function updateProduct2ProductConnections( $connections ){
		
		$this->unlink('ConnectedProducts', array_values( $this->ConnectedProducts->getPrimaryKeys() ) );
		$this->link('ConnectedProducts', $connections );
		
		$this->save();		

	}
	

	
	
	public function getPriForm(){
		$form =<<<EOD
		<input type="text" size=2 style="background-color:#EFEFEF;border:1px solid #777777;text-align: center; " name="product_pri[{$this->id}]" value="{$this->pri}" />	
EOD;
	return $form;
	}
	
	public function getProductGroupsForList(){
		$result = array(-1);
		foreach( $this->ProductGroups as $prodGroup ){
			$result[] = $prodGroup['group_id'];
		}
		
		$prodGroups = Doctrine::getTable('ProductGroup')
			->createQuery('prodgroups')
			->from('ProductGroup pg')
			->whereIn('pg.id', $result)
			->execute();
			
		$str = '';
		
		foreach( $prodGroups as $prodGroup ){
			$str = $str . $prodGroup['title'] . ' <br />';
		}
		
		return $str;
		
	}
	
	
	public function getOneProductPictureByParameter( $parameter = 'default' ){
		return Doctrine::getTable('ProductPictures')->findOneByParameterAndProductId( $parameter, $this->id );
	}
	
	
	
	public function buildLink( $lang ){
		
		$pgs = $this->getProductGroups();
		if( $pgs )
			return	Doctrine::getTable('ProductGroup')
					->find($pgs[0]['group_id'])
					->buildLink( $lang );
				
		return '#';
		
	}
	
	
	public function getCommentsQuery(){
		return Doctrine::getTable('ProductComment')->getCommentsQuery( $this->getId() );
	}
	
	/*
	 * used in FRONTEND
	 * 
	 * if there is normal price AND discount price -> give discounte price
	 * if there is normal price AND no dicsount price -> normal price
	 * if only discount price -> discount price
	 * 
	 */
	public function getPriceActual(){
		
		if( $this->getDiscountPrice() ){
			return $this->getDiscountPrice();
		}
		
		return $this->getPrice();
		
	}

}