<?php

/**
 * ParameterHtml form base class.
 *
 * @method ParameterHtml getObject() Returns the current form's model object
 *
 * @package    jobeet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedInheritanceTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseParameterHtmlForm extends ParameterForm
{
  protected function setupInheritance()
  {
    parent::setupInheritance();

    $this->widgetSchema->setNameFormat('parameter_html[%s]');
  }

  public function getModelName()
  {
    return 'ParameterHtml';
  }

}
