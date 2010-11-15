<?php
class ProductFilesContainerForm extends ProductForm
{

    public function configure()
    {

        $this->useFields( array('id') );

        foreach( $this->getObject()->ProductFiles as $file ){
                $this->embedForm( 'file_' . $file['id'] , new ProductFileForm( $file ) );
        }

    }

    public function processForm( $controller, $request ){

        $this->bind( $request->getParameter('product')  , $request->getFiles() );

        if( $this->isValid() ){
                $this->save();
        }

    }

}