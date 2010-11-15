<?php

/**
 * news_group module configuration.
 *
 * @package    jobeet
 * @subpackage news_group
 * @author     Your name here
 * @version    SVN: $Id: configuration.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class news_groupGeneratorConfiguration extends BaseNews_groupGeneratorConfiguration
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
