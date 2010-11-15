<?php

/**
 * Language form.
 *
 * @package    jobeet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class LanguageForm extends BaseLanguageForm
{
  public function configure()
  {

  	
	 $this->useFields(array( 'title_est', 'isHidden', 'title'  ) );
	 $this->setWidgets( array(
	 	'title'   => new sfWidgetFormInputText( array(), array( 'size' => 25, 'class' => 'formInput' ) ),
      	'title_est'   => new sfWidgetFormInputText( array(), array( 'size' => 25, 'class' => 'formInput' ) ),
	 	'isHidden' => new sfWidgetFormInputCheckbox()
    ));
	 
  }
}
