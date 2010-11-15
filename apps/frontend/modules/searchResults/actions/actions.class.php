<?php

require_once( dirname( __FILE__ ) . '/../../categoryPage/actions/actions.class.php' ); // showin, showby actions

class searchResultsActions extends myFrontendAction{


	public function executeAjax(sfWebRequest $request){
 		$this->setLayout(false);

		$q = Doctrine::getTable('Product')
									->createQuery('ids')
									->select("vp.*, t2.*") // hack to preserve order
									->from('Product vp')
									->leftJoin('vp.Translation t2 WITH t2.lang = ?' , array( $this->getUser()->getCulture() ))
									->leftJoin('vp.ProductGroups pgs')
									->leftJoin('pgs.ProductGroup pg')
									->where('t2.name LIKE ?', $this->getKeyword() . "%")
									->limit(3);

		$this->setCategoryQueryConstraints($q);
		$this->products = $q->execute();
	}


	public function executeDetailed( sfWebRequest $request ){
		$this->setLayout('layout_widgets_off');

		# validating input
		if( !$this->getKeyword() ) $this->redirect($request->getReferer());

		# find products
		$hits = ProductTable::getLuceneIndex()->find( $this->prepareLuceneQuery( $this->getKeyword() ) ); // searching the index
		$this->products = $this->getSearchResultsQuery($hits, 20)->execute();


		# find news
		$hits = NewItemTable::getLuceneIndex()->find( $this->prepareLuceneQuery( $this->getKeyword() ) ); // searching the index
		$this->news = $this->getNewsSearchResultsQuery($hits, 20)->execute();

		# find structure
		$hits = StructureTable::getLuceneIndex()->find( $this->prepareLuceneQuery( $this->getKeyword() ) ); // searching the index
		$this->nodes = $this->getStructureSearchResultsQuery($hits, 20)->execute();


  		# variables for view
  		$this->keyword = $this->getKeyword();




	}


	protected function prepareLuceneQuery($keyword){

		$keyword = strtolower($keyword);

		$query = new Zend_Search_Lucene_Search_Query_Boolean();

		# multiterm query
		$subquery1 = new Zend_Search_Lucene_Search_Query_MultiTerm();
		foreach( explode(' ', $keyword) as $key ){

			if(!trim($key)) continue;
			$subquery1->addTerm(new Zend_Search_Lucene_Index_Term($key));

		}

		# wildcard query
		Zend_Search_Lucene_Search_Query_Wildcard::setMinPrefixLength(1);
		$tokens = preg_split('/ /', $keyword, -1, PREG_SPLIT_NO_EMPTY);
		$lastWord = trim(array_pop($tokens) ) . "*";

		$pattern = new Zend_Search_Lucene_Index_Term($lastWord);
		$subquery2 = new Zend_Search_Lucene_Search_Query_Wildcard($pattern);



		$query->addSubquery($subquery1);
		$query->addSubquery($subquery2);

		return $query;
	}


	protected function getNewsSearchResultsQuery($hits, $limit){
		$ids = array(-1); // defeat Doctrine bug
		foreach( $hits as $hit ){
			$ids[] = $hit->pk;
		}


		$idsStr = implode(',', $ids); // ordered search result IDS -> "5,2,4,13,1"

		$q = Doctrine::getTable('NewItem')
									->createQuery('ids')
									->select("vp.*, FIELD(vp.id, {$idsStr} ) AS field") // hack to preserve order
									->from('NewItem vp')
									->whereIn('id', $ids)
									->orderBy('field')
									->limit($limit);

		return $q;
	}


	protected function getStructureSearchResultsQuery($hits, $limit){
		$ids = array(-1); // defeat Doctrine bug
		foreach( $hits as $hit ){
			$ids[] = $hit->pk;
		}


		$idsStr = implode(',', $ids); // ordered search result IDS -> "5,2,4,13,1"

		$q = Doctrine::getTable('Structure')
									->createQuery('ids')
									->select("vp.*, FIELD(vp.id, {$idsStr} ) AS field") // hack to preserve order
									->from('Structure vp')
									->where('vp.isHidden = ?', false)

									->andWhere('vp.parentid <> 17')

									->andWhere('vp.parentid <> 99')

									->andWhere('vp.parentid <> 107')

									->andWhere('vp.parentid <> 129')
									->whereIn('id', $ids)
									->orderBy('field')
									->limit($limit);

		return $q;
	}

	/* build DQL */
	protected function getSearchResultsQuery( $hits, $limit ){


		$ids = array(-1); // defeat Doctrine bug
		foreach( $hits as $hit ){
			$ids[] = $hit->pk;
		}


		$idsStr = implode(',', $ids); // ordered search result IDS -> "5,2,4,13,1"

		$q = Doctrine::getTable('Product')
									->createQuery('ids')
									->select("vp.*,t.*,pgs.*,pg.*, FIELD(vp.id, {$idsStr} ) AS field") // hack to preserve order
									->from('Product vp')
									->leftJoin('vp.ProductGroups pgs')
									->leftJoin('pgs.ProductGroup pg')
									->whereIn('id', $ids)
									->orderBy('field')
									->limit($limit);

		return $q;
	}

	/* get keyword from request */
	protected function getKeyword(){
		return (strip_tags( stripslashes( htmlspecialchars( trim( $this->getRequestParameter('search') ) ) ) ) );
	}

}