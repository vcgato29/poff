<?php

/**
 * ProductComment form.
 *
 * @package    jobeet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class ProductCommentForm extends BaseProductCommentForm
{
  public function configure()
  {
  	$this->useFields( array( 'name', 'message' ) );
  	
  	$this->validatorSchema['name'] = new sfValidatorString(array( 'required' => true, 'min_length' => 2 , 'max_length' => 500));
  	$this->validatorSchema['message'] = new sfValidatorString(array( 'required' => true, 'min_length' => 2 , 'max_length' => 500));
  }
}
