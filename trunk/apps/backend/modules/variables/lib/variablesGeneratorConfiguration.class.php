<?php

/**
 * variables module configuration.
 *
 * @package    jobeet
 * @subpackage variables
 * @author     Your name here
 * @version    SVN: $Id: configuration.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class variablesGeneratorConfiguration extends BaseVariablesGeneratorConfiguration
{
	public function getForm($obj = null, $options = array()){
		return new VariableForm($obj);
	}
}
