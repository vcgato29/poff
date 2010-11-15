<?php

/**
 * ParameterSelectionSingle filter form base class.
 *
 * @package    jobeet
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedInheritanceTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseParameterSelectionSingleFormFilter extends ParameterFormFilter
{
  protected function setupInheritance()
  {
    parent::setupInheritance();

    $this->widgetSchema->setNameFormat('parameter_selection_single_filters[%s]');
  }

  public function getModelName()
  {
    return 'ParameterSelectionSingle';
  }
}
