<?php

/**
 * Currency
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    jobeet
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 6820 2009-11-30 17:27:49Z jwage $
 */
class Currency extends BaseCurrency
{
	
	static $defaultCurrency = true;
	const DEFAULT_CURRENCY = false;
	
	static function convert($q, $toCurrency, $fromCurrency = self::DEFAULT_CURRENCY){
		
		$result = 0;
		
		$from = self::getCurrencyByAbbr($fromCurrency);
		$to = self::getCurrencyByAbbr($toCurrency);
		
//		$result = round(($q * $to['factor']) / $from['factor'], 2, PHP_ROUND_HALF_UP);
		$result = round(($q * $to['factor']) / $from['factor'], 2);
		
		
		return $result;
	}
	
	static function getCurrencyByAbbr($abbr){
		if(self::DEFAULT_CURRENCY !== $abbr)
			return Doctrine::getTable('Currency')->findOneByAbbr($abbr);
		else
			return Doctrine::getTable('Currency')->findOneByFactor(1);
	}
	
	static function getDefaultCurrency(){
		if(!$this->defaultCurrency = $defaultCurrency){
			$this->defaultCurrency = Doctrine::getTable('Currency')->findOneByFactor(1);
		}
		return $this->defaultCurrency;
	}

}