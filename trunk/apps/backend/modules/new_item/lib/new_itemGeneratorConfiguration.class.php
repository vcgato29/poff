<?php

/**
 * new_item module configuration.
 *
 * @package    jobeet
 * @subpackage new_item
 * @author     Your name here
 * @version    SVN: $Id: configuration.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class new_itemGeneratorConfiguration extends BaseNew_itemGeneratorConfiguration
{
	public function getFilterDefaults(){
		
		$request = sfContext::getInstance()->getRequest();
		$group = sfContext::getInstance()->getRequest()->getParameter('group_id');
		if( $group ){
			return array('group_id'=>$group);
		}
		
		if( $request->hasParameter('nodeid') ){
			if( $request->getParameter('nodeid') == 0 )
				return array();
			return array('relatives' => array( $request->getParameter('nodeid') ));
		}
		
		return parent::getFilterDefaults();
	}
}
