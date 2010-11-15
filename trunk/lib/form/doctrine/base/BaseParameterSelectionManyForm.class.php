<?php

/**
 * ParameterSelectionMany form base class.
 *
 * @method ParameterSelectionMany getObject() Returns the current form's model object
 *
 * @package    jobeet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedInheritanceTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseParameterSelectionManyForm extends ParameterForm
{
  protected function setupInheritance()
  {
    parent::setupInheritance();

    $this->widgetSchema->setNameFormat('parameter_selection_many[%s]');
  }

  public function getModelName()
  {
    return 'ParameterSelectionMany';
  }

}
