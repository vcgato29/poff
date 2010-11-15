<?php

function variable($var, $default = null){
	sfProjectConfiguration::getActive()->loadHelpers(array('I18N'));

	
	
	$r = trim(trim(__($var, array(), 'variables'), '['), ']');
	if($r == $var){
		$sf_user = sfContext::getInstance()->getUser();
		$prevCult = $sf_user->getCulture();
		$sf_user->setCulture(TransUnitVariable::UNIVERSAL_LANG);
		$r = __($var, array(), 'variables');
		$sf_user->setCulture($prevCult);
	}
	
	
	
	if($r  == $var && $default)
		$r = $default;
	
	return $r;
}