<?php

abstract class RequestProcessor{


    private $user;
    private $form;
    private $request;

    private $data;

    public function __construct(myUser $user, sfForm $form = null, sfWebRequest $request = null){
        $this->user = $user;
        $this->form = $form;
        $this->request = $request;
    }

    
    protected function getUser(){
        return $this->user;
    }

    protected function getForm(){
        return $this->form;
    }

    protected function getRequest(){
        return $this->request;
    }


    abstract function getHolderName();

    protected function getFormValues(){
        return $this->getForm()->getValues();
    }



    public function validateForm(){
        $this->getForm()->bind( $this->getRequest()->getParameter($this->getForm()->getName()), 
                                $this->getRequest()->getFiles($this->getForm()->getName()) );


        if($this->getForm()->isValid()){
            return true;
        }else{
            return false;
        }
    }


    public function getErrors(){
        return $this->getForm()->getErrors();
    }

    public function saveFormValues(){
        DataHolder::getInstance($this->getHolderName())->saveFormValues($this->getFormValues());
    }


    public function getSavedFormValues(){
        return DataHolder::getInstance($this->getHolderName())->getSavedFormValues();
        
    }


    
    abstract function processForm();

}
