<?php

/**
 * ParameterProductOption form.
 *
 * @package    jobeet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class ParameterProductOptionForm extends BaseParameterProductOptionForm
{
  public function configure()
  {
  	//$this->widgetSchema['option_id']  = new sfWidgetFormDoctrineChoice(array( 'multiple' => true, 'model' => $this->getRelatedModelName('ParameterOption'), 'add_empty' => false));
  	//$this->validatorSchema['option_id'] =  new sfValidatorDoctrineChoice(array('multiple' => true ,'model' => $this->getRelatedModelName('ParameterOption')));
  }
  
  
}
