<?php

/**
 * Structure form.
 *
 * @package    jobeet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class StructureLanguageForm extends StructureForm
{
  public function configure()
  {
  	

	 
  	$langs = Doctrine::getTable( 'Language' )->findAll();
  	$choices = array();
  	
  	foreach( $langs as $lang ){
  		$choices[$lang['id']] = $lang['title_est'];
  	}
  	

  	
	 $this->setWidgets( array (
	 	'language' =>  new sfWidgetFormSelect( array( 'choices' => $choices ) )
    ) );


  }
}
