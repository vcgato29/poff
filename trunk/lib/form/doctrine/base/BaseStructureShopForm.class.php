<?php

/**
 * StructureShop form base class.
 *
 * @method StructureShop getObject() Returns the current form's model object
 *
 * @package    jobeet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedInheritanceTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseStructureShopForm extends StructureForm
{
  protected function setupInheritance()
  {
    parent::setupInheritance();

    $this->widgetSchema->setNameFormat('structure_shop[%s]');
  }

  public function getModelName()
  {
    return 'StructureShop';
  }

}
