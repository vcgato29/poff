<?php

/**
 * ProductTranslation form.
 *
 * @package    jobeet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class ProductTranslationForm extends BaseProductTranslationForm
{
  public function configure()
  {
  	$this->widgetSchema['name'] = new sfWidgetFormInput();
  	$this->widgetSchema['description'] = new sfWidgetFormInput( array(), array( 'size' => 40 ) );
  	$this->widgetSchema['longdescription'] = new sfWidgetFormTextarea( array(), array( 'cols' => 35 ) );
  }
}
