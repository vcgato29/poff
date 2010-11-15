<?php

/**
 * bannergroup module configuration.
 *
 * @package    jobeet
 * @subpackage bannergroup
 * @author     Your name here
 * @version    SVN: $Id: configuration.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class bannergroupGeneratorConfiguration extends BaseBannergroupGeneratorConfiguration
{
	public function getFilterDefaults(){
		$request = sfContext::getInstance()->getRequest();

		if( $request->hasParameter('nodeid') ){
			if( $request->getParameter('nodeid') == 0 )
				return array();
			return array('relatives' => array( $request->getParameter('nodeid') ));
		}
		
		return parent::getFilterDefaults();
	}
}
