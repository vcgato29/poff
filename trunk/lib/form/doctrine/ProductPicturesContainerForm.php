<?php
class ProductPicturesContainerForm extends ProductForm
{
	
	public function configure(){
		
		$this->useFields( array('id') );
		
		foreach( $this->getObject()->ProductPictures as $pic ){ 
			$this->embedForm( 'picture_' . $pic['id'] , new ProductPicturesForm( $pic ) );	
		}
		
	}
	
	public function processForm( $controller, $request ){
		
		$this->bind( $request->getParameter('product')  , $request->getFiles() );
		
		if( $this->isValid() ){
			$this->save();

		}
		
	} 
	
	
	
	
}