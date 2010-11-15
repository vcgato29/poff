<?php

function price_format($price, $sf_user = false){
	if(!$sf_user)$sf_user = sfContext::getInstance()->getUser();
	$cur = $sf_user->getCurrency();
	$culture = $sf_user->getCulture();
	
	$numberFormat = new sfNumberFormat($culture);
	
	$ar = sfNumberFormatInfo::getCurrencyInstance($culture)->getPattern();
	
	if($cur->getAbbr() != 'EUR' && $cur->getAbbr() != 'USD'){
		$pattern = str_replace('¤', '', $ar['positive']);
		
		$pattern = trim(str_replace('¤', '', $ar['positive'])) . ' ' .$cur->getAbbr();
	}else{
		$pattern = $ar['positive'];
	}
	
	return $numberFormat->format($cur->getFactor() * $price, $pattern, $cur->getAbbr());
}

function price_convert($q, $toCurrency, $fromCurrency = Currency::DEFAULT_CURRENCY, $culture = null){
	$r = Currency::convert($q, $toCurrency, $fromCurrency);
	

	
	return $r;
}

