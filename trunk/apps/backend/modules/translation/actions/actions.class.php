<?php
class translationActions extends sfActions
{
	public function executeIndex( $request )
	{
		$this->transUnits = Doctrine::getTable('TransUnit')
							->getUniqueTransUnits()
							->andWhere('variable_id IS NULL')
							->execute()
							->toArray();
							
		//echo $this->getContext()->getI18n()->__('Muutuja');
							
	}
	
	
	public function executeNew( $request )
	{
		$this->setLayout('popuplayout');
		$this->langs = Doctrine::getTable('Language')->findAll();
		$this->variable = '';
		$this->setTemplate('edit');
	}
	
	public function executeCreate( $request ){
		$this->clearCache();
		parent::executeCreate( $request );
	}
	
	public function executeEdit( $request )
	{
		$this->setLayout('popuplayout');
		$this->variable = $request->getParameter('source');
		
		$transUnits = Doctrine::getTable('TransUnit')
							->findBySource( $request->getParameter('source') );

		$this->langs = Doctrine::getTable('Language')->findAll();			
		$cats = Doctrine::getTable('Catalogue')->findAll();

		$groupedUnits = array();
		foreach( $transUnits as $tu ){
			foreach( $cats as $cat ){
				if( $tu->cat_id == $cat->cat_id )
					$groupedUnits[$cat->target_lang] = $tu->toArray();
			}
		}
		
		$this->groupedUnits = $groupedUnits;
		
	}
	
	
	public function executeUpdate( $request )
	{
		$source = $request->getParameter( 'transUnit' );
		$unitvars = $request->getParameter('unitvars');
		

		foreach( $unitvars as $lang => $val ){
			// 1. check that $lang catalogue exists
			$catalogue = Doctrine::getTable('Catalogue')->findOneByTargetLangAndName($lang, 'messages.'.$lang);
			if( !$catalogue ){
				//1.1 if not then add it
				$catalogue = new Catalogue();
				$catalogue->fromArray( array( 	'name' => 'messages.'.$lang, 
												'source_lang' => 'en',
												'target_lang' => $lang ) );
				$catalogue->save();
			}

			
			$transUnit = Doctrine::getTable('TransUnit')->findOneByLangAndCategory( $source, $catalogue->cat_id );
			if( !$transUnit ){
				$transUnit = new TransUnit();
				$transUnit->fromArray( array( 'source' => $source ) );
				$transUnit->setCatalogue( $catalogue );									
			}			
			
			
			
			$transUnit->setTarget($val);
			$transUnit->translated = empty($val) ? 0 : 1;

			$transUnit->save();

			
		}
		
		$this->clearCache();
		
		$this->redirect( '@admin_page?module=translation&action=edit&source='.$source );
		
		
	}
	
	public function executeDelete( $request )
	{
		foreach( Doctrine::getTable('TransUnit')
							->findBySource( $request->getParameter('source') ) as $tu ){

			$tu->delete();
		}
		
		$this->redirect( '@admin_page?module=translation&action=index' );
		
	}
	
	public function clearCache(){
		 sfToolkit::clearDirectory( sfConfig::get( 'sf_cache_dir' )  );
	}
	
	
	
	
}