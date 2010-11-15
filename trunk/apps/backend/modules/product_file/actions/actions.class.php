<?php
class product_fileActions extends sfActions{


    public function preExecute(){
        $this->setLayout('popuplayout');
    }

    public function executeIndex(sfWebRequest $request){
     
        $this->files = Doctrine::getTable('ProductFile')->createQuery('')
                        ->from('ProductFile pf')
                        ->innerJoin('pf.Product p')
                        ->where('p.id = ?', $request->getParameter('id'))
                        ->orderBy('pf.pri')
                        ->execute();


        $this->form = new ProductFilesContainerForm( Doctrine::getTable('Product')->find( $request->getParameter('id') ) );

        

    }
    

    public function executeSwfupload(sfWebRequest $request){
        $this->form = new ProductFileForm(array(),array(),false); # disabled "_csrf_token"
        $this->form->processForm( $this, $request );

        exit;	# "Complete" status in SWFuploader
    }
    

    public function executeUpdate(sfWebRequest $request){
        $this->setLayout( 'popuplayout' );
        $this->form = new ProductFilesContainerForm( Doctrine::getTable('Product')->find( $request->getParameter('id') )  );
        $this->form->processForm( $this, $request );

        if( $request->hasParameter('deletepics') )
                foreach( $request->getParameter('deletepics') as $picId ){
                        Doctrine::getTable('ProductFile')->find($picId)->delete();
                }

        $this->redirect( $request->getReferer() );
    }

    public function executePriority(sfWebRequest $request){

        switch( $request->getParameter('order') ){
                case 'up':
                        Doctrine::getTable('ProductFile')->increasePriority( $request->getParameter('id') );
                        break;
                case 'down':
                        Doctrine::getTable('ProductFile')->decreasePriority( $request->getParameter('id') );
                        break;
        }

        $this->redirect( $request->getReferer() );

    }

}