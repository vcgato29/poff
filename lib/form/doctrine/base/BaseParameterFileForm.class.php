<?php

/**
 * ParameterFile form base class.
 *
 * @method ParameterFile getObject() Returns the current form's model object
 *
 * @package    jobeet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedInheritanceTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseParameterFileForm extends ParameterForm
{
  protected function setupInheritance()
  {
    parent::setupInheritance();

    $this->widgetSchema->setNameFormat('parameter_file[%s]');
  }

  public function getModelName()
  {
    return 'ParameterFile';
  }

}
