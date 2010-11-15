<?php

/**
 * translations module configuration.
 *
 * @package    jobeet
 * @subpackage translations
 * @author     Your name here
 * @version    SVN: $Id: configuration.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class translationsGeneratorConfiguration extends BaseTranslationsGeneratorConfiguration
{

	public function getForm($obj = null, $options = array()){
		return new TranslationForm($obj,$options);
	}
}
