<?php

/**
 * ParameterOption form.
 *
 * @package    jobeet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class ParameterOptionForm extends BaseParameterOptionForm
{
  public function configure()
  {
  	unset($this['created_at']);
  	unset($this['updated_at']);
  	unset($this['param_id']);
  	
  	
    $languages = array();
    
  	foreach( Doctrine::getTable('Language')->findAll() as $lang ){
  		$languages[] = $lang->getAbr();
  	}

  	if( !$this->isNew() ){
  		if( $this->getObject()->getParameter()->getMultilang() ){
  			$this->embedI18n( $languages );
  			unset($this['title']);
  		}
  	}else{
  		$this->embedI18n( $languages );
  	}
  	
  	
  	
  }
  

  
	public function saveEmbeddedForms($con = null, $forms = null)
	{
		# save object first of all
		$this->getObject()->save();
	  
	    if (is_null($con))
	    {
	      $con = $this->getConnection();
	    }
	
	    if (is_null($forms))
	    {
	      $forms = $this->embeddedForms;
	    }
	
	    foreach ($forms as $key => $form)
	    {
	      if ($form instanceof sfFormDoctrine)
	      {
	
	        $form->bind($this->values[$key]);
	        $form->doSave($con);
	
	        $form->saveEmbeddedForms($con);
	      }
	      else
	      {
	        $this->saveEmbeddedForms($con, $form->getEmbeddedForms());
	      }
	    }
	} 
}
