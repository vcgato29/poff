<?php

/**
 * ParameterSelectionMany form.
 *
 * @package    jobeet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class ParameterSelectionManyForm extends ParameterSelectionForm
{
  /**
   * @see ParameterForm
   */
  public function configure()
  {
    parent::configure();
  }
  
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
