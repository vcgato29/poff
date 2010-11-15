<?php

/**
 * StructureLanguage filter form base class.
 *
 * @package    jobeet
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedInheritanceTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseStructureLanguageFormFilter extends StructureFormFilter
{
  protected function setupInheritance()
  {
    parent::setupInheritance();

    $this->widgetSchema->setNameFormat('structure_language_filters[%s]');
  }

  public function getModelName()
  {
    return 'StructureLanguage';
  }
}
