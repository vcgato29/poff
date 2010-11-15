<?php

/**
 * ParameterTextfield form base class.
 *
 * @method ParameterTextfield getObject() Returns the current form's model object
 *
 * @package    jobeet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedInheritanceTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseParameterTextfieldForm extends ParameterForm
{
  protected function setupInheritance()
  {
    parent::setupInheritance();

    $this->widgetSchema->setNameFormat('parameter_textfield[%s]');
  }

  public function getModelName()
  {
    return 'ParameterTextfield';
  }

}
