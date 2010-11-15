<?php

/**
 * ParameterTextBox form base class.
 *
 * @method ParameterTextBox getObject() Returns the current form's model object
 *
 * @package    jobeet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedInheritanceTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseParameterTextBoxForm extends ParameterForm
{
  protected function setupInheritance()
  {
    parent::setupInheritance();

    $this->widgetSchema->setNameFormat('parameter_text_box[%s]');
  }

  public function getModelName()
  {
    return 'ParameterTextBox';
  }

}
