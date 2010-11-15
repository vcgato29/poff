<?php

class ParameterProductValueFileForm extends ParameterProductValueForm{
	public function configure(){
		
		
		
	  	$this->widgetSchema['common_value'] = new sfWidgetFormInputFileEditable( $this->getWidgetConfig() );
	  	$this->validatorSchema['common_value_delete'] = new sfValidatorPass();
	    $this->validatorSchema['common_value'] = new sfValidatorFile( $this->getValidatorConfig() );
	    
	    parent::configure();

	}
	 
  public function updateObject($values = null){
  	
    $object = parent::updateObject($values);
    

    # save original file name for single lang form
    if( $values && $values['common_value'] ){
    	$object->setCommonFilename( $values['common_value']->getOriginalName() );
    }
    
    if( $object && $object->getCommonValue() ){
    	
    	$object->setCommonValue( $this->getUploadSubDir() . str_replace( $this->getUploadSubDir() , '', $object->getCommonValue()));
    }
    return $object;
    
  }
  
  public function setupI18nCallback(){
  	
  	 
  	foreach( $this->getLanguages() as $lang ){
  		

	  	$this->widgetSchema[$lang]['value'] = new sfWidgetFormInputFileEditable( $this->getWidgetConfigForLang( $lang ) );
	  	$this->validatorSchema[$lang]['value_delete'] = new sfValidatorPass();
	    $this->validatorSchema[$lang]['value'] = new sfValidatorFile( $this->getValidatorConfig() );
  	}
		
  }
  
  
	public function bind(array $taintedValues = null, array $taintedFiles = null) {
		
		
//		print_r( $this->getLanguages()  );
//		exit;
		
		foreach( $this->getLanguages() as $lang ){
			
			$obj = $this->getObject();
			if( isset( $taintedValues[$lang] ) && !$taintedValues[$lang]['value'] ){

				if( !$obj->Translation[$lang]->value ){
					try{
						$obj->Translation[$lang]->refresh();
					}catch( Doctrine_Record_Exception $ex ){ $obj->Translation[$lang]->value = ''; }
				}

				
				if( $taintedValues[$lang]['value_delete'] )
					$obj->Translation[$lang]->value = '';
					
				unset($this->embeddedForms[$lang], $taintedValues[$lang], $this[$lang]);
				
			}else if( !isset( $taintedValues[$lang] ) ){
				unset($this->embeddedForms[$lang], $taintedValues[$lang], $this[$lang]);
				$obj->Translation[$lang]->value = '';
			}
				
		}
		
		parent::bind($taintedValues, $taintedFiles);
	
	}
	
  
	public function saveEmbeddedForms($con = null, $forms = null){
	    if (is_null($con)){
	      $con = $this->getConnection();
	    }
	
	    if (is_null($forms)){
	      $forms = $this->embeddedForms;
	    }
	
	    foreach ($forms as $key => $form){
	    	
	      if ($form instanceof sfFormDoctrine){
	 	
	        $form->bind($form->getObject()->toArray());
			$form->doSave($con);

		    if( $form->getObject()->value instanceof sfValidatedFile  ){
		    	
			    $filename = sha1( $form->getObject()->value->getOriginalName()) . $form->getObject()->value->getExtension( $form->getObject()->value->getOriginalExtension());
			     $form->getObject()->value->save( $this->getUploadDir() .$filename );
			     $form->getObject()->filename =  $form->getObject()->value->getOriginalName();
			    $form->getObject()->value =  $this->getUploadSubDir() .$filename;
			    
		    }

	        $form->saveEmbeddedForms($con);
	      }else{
	        $this->saveEmbeddedForms($con, $form->getEmbeddedForms());
	      }
	    }
	} 
  
  public function getEditFormRendereringTemplate(){
  	
  	if( $this->getObject()->getParameter()->getMultilang() )
  		return "multilang_textfieldform";
  	else
  		return "singlelang_textfieldform";
  }
  
  
	public function getValidatorConfig(){
	    return array( 	'required' => $this->isRequired(),
			    		'path' => $this->getUploadDir(),
			    		'mime_types' =>  $this->getMimeTypes() );
	}
	
	
	public function isRequired(){
		return false;
	}
	
	
	public function getMimeTypes(){
		return array( 'text/plain' );
	}
	
	
	public function getUploadDir(){
		return sfConfig::get('sf_upload_dir') . $this->getUploadSubDir();
	}
	
	
	public function getUploadSubDir(){
		return '/productparameter/';
	}
	
	public function getWidgetConfigForLang( $lang ){
		
  		return array(
	  			'file_src' => $this->getFileSrcForLang( $lang ),
	  			'is_image' => $this->isImage(),
				'edit_mode' => !$this->isNew(),
	  			'with_delete' => $this->withDelete(),
      			'template'  => $this->getTemplate(),
	  		
	  		);
	}
	
	
	public function getWidgetConfig(){
  		return array(
	  			'file_src' => $this->getFileSrc(),
	  			'is_image' => $this->isImage(),
				'edit_mode' => !$this->isNew(),
	  			'with_delete' => $this->withDelete(),
      			'template'  => $this->getTemplate(),
	  		
	  		);
	}
	
	
	public function getTemplate(){
		return '<div>
      				<div>%file%</div>
      				<br />%input%<br />
      				<div class="formLabel">%delete% %delete_label%</div>
      			</div>';
	}
	
	
	public function withDelete(){
		return true;
	}
	
	public function isImage(){
		return false;
	}
	
	
	public function getFileSrc(){
		if( $this->getObject()->getCommonValue() )
			return "<a target='_blank' href='/". basename( sfConfig::get('sf_upload_dir') ) .  $this->getObject()->getCommonValue()  ."'> {$this->getFilename()} </a>";
		else
			return 'no file';
	}
	
	public function getFilename(){
		return $this->getObject()->getCommonFilename();
	}
	
	public function getFilenameForLang($lang){
		return $this->getObject()->Translation[$lang]->filename;
	}
	
	public function getFileSrcForLang( $lang ){
		if( $this->getObject()->Translation[$lang]->value  )
			return "<a target='_blank' href='/". basename( sfConfig::get('sf_upload_dir') ) .  $this->getObject()->Translation[$lang]->value  ."'> {$this->getFilenameForLang($lang)} </a>";
		else
			return 'no file';
	}
	
}