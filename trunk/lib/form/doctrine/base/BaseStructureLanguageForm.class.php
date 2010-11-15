<?php

/**
 * StructureLanguage form base class.
 *
 * @method StructureLanguage getObject() Returns the current form's model object
 *
 * @package    jobeet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedInheritanceTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseStructureLanguageForm extends StructureForm
{
  protected function setupInheritance()
  {
    parent::setupInheritance();

    $this->widgetSchema->setNameFormat('structure_language[%s]');
  }

  public function getModelName()
  {
    return 'StructureLanguage';
  }

}
