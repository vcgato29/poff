<?php

/**
 * banner module configuration.
 *
 * @package    jobeet
 * @subpackage banner
 * @author     Your name here
 * @version    SVN: $Id: configuration.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class bannerGeneratorConfiguration extends BaseBannerGeneratorConfiguration
{
	public function getFilterDefaults(){
		$request = sfContext::getInstance()->getRequest();

		if( $request->hasParameter('nodeid') ){
			if( $request->getParameter('nodeid') == 0 )
				return array();
			return array('relatives' => array( $request->getParameter('nodeid') ));
		}
		
		if(  $request->hasParameter('group_id') ){
			return array( 'banner_group_id' => array( $request->getParameter('group_id')  ) );
		}
		return parent::getFilterDefaults();
	}
}
