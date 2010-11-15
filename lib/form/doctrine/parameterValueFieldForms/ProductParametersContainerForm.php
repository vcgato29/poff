<?php
class ProductParametersContainerForm extends ProductForm
{
	
	public $params = null;
	public $langs = array( '0' => array( 'abr' => 'et' ), '1' => array( 'abr' => 'en' ) );
	public $files = array();
	
	public function configure(){
		
		# product fields ( only ID needed )
		$this->useFields( array('id') );
		
		# embedding all PARAMETER VALUE[=OPTION] forms
		if( $this->getParams() )
			foreach( $this->getParams() as $param ){
				
				$param->createAndGetParamValueForm( $this->getObject() )
						->setLanguages( $this->getLangsAbr() );
				
				$this->embedForm( 'param_' . $param->getId(),
							# each parameter object should know which PARAMETER VALUE form belongs
							# to him 
								$param->getParamValueForm()			 
							);
			}
		
		
	}

	 
	public function processForm( $controller, $request ){
		
		$this->files = $request->getFiles('product');
		$this->bind( $request->getParameter('product'), $request->getFiles('product') );
		
		if( $this->isValid() ){
			$this->save();
			$controller->redirect( $request->getReferer() );
		}
		
	}
	
	
	public function saveEmbeddedForms($con = null, $forms = null)
	{
		# save object first of all
		
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


	      	$form->bind( $this->values[$key], isset( $this->files[$key]['common_value'] ) ? array( $this->files[$key]['common_value'] ) : array() ); 
	        $form->doSave($con);
	
	        $form->saveEmbeddedForms($con);
	      }
	      else
	      {
	        $this->saveEmbeddedForms($con, $form->getEmbeddedForms());
	      }
	    }
	} 

	public function setParams( $params ){
		$this->params = $params;
	}
	
	public function getParams(){
		return $this->params;

	}

	public function setLangs( $langs ){
		$this->langs = $langs;
	}
	
	public function getLangs(){
		return $this->langs;
	}
	
	public function getLangsAbr(){
		$arr = array();
		foreach( $this->getLangs() as $lang ){
			$arr[] = 	$lang['abr'];
		}
		
		return $arr;
	}
	

}