<?php

require_once dirname(__FILE__).'/../lib/variablesGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/variablesGeneratorHelper.class.php';

/**
 * variables actions.
 *
 * @package    jobeet
 * @subpackage variables
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class variablesActions extends autoVariablesActions
{
  protected function getFilters()
  {
  	$default = array(-1);

   $r['cat_id'] = array_merge($default, parent::getFilters(), VariablesForm::getCatalogueIDs());

   
    return $r;
  }
}
