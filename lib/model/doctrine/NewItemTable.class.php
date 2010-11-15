<?php

class NewItemTable extends Doctrine_Table
{

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
	  return sfConfig::get('sf_data_dir').'/newitem.index/index';
	}

}