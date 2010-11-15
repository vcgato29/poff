<?php

/**
 * translations module helper.
 *
 * @package    jobeet
 * @subpackage translations
 * @author     Your name here
 * @version    SVN: $Id: helper.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class translationsGeneratorHelper extends BaseTranslationsGeneratorHelper
{
	public function getDefaultLanguages(){
		return array('et', 'en', 'ru');
	}
}
