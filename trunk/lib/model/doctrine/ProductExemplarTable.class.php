<?php

/**
 * ProductExemplarTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class ProductExemplarTable extends Doctrine_Table
{
    /**
     * Returns an instance of this class.
     *
     * @return object ProductExemplarTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('ProductExemplar');
    }

	static function getLocations(){
		$result = Doctrine_Query::create()
			->from('ProductExemplar pe')
			->select('DISTINCT location')
			->where('location != ""')
			->setHydrationMode(Doctrine::HYDRATE_SINGLE_SCALAR)
			->execute();

		if(!is_array($result))
			$result = array($result);

		return $result;

	}

	static function getCinemas(){
		$result = Doctrine_Query::create()
			->from('ProductExemplar pe')
			->select('DISTINCT cinema')
			->where('cinema != ""')
			->setHydrationMode(Doctrine::HYDRATE_SINGLE_SCALAR)
			->execute();

		if(!is_array($result))
			$result = array($result);

		return $result;
	}

	static function getDates(){

		$result = Doctrine_Query::create()
			->from('ProductExemplar pe')
			->select("DISTINCT DATE_FORMAT(scheduled_time, '%d.%m.%Y')")
			->where('scheduled_time != ""')
			->orderBy('scheduled_time asc')
			->setHydrationMode(Doctrine::HYDRATE_SINGLE_SCALAR)
			->execute();

		return $result;

	}
}