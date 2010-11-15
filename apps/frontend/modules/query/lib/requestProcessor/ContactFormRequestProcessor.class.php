<?php


class ContactFormRequestProcessor extends RequestProcessor{

    public function processForm(){


        if(!$this->validateForm()){
            throw new QueryInputException();
        }

        $this->saveFormValues();

//        // save data in session
//        $this->saveFormValues($form);
//
//        // generate PDF file from session data
//        $pdf = $this->generatePDF();
//
//        // send PDF to admin AND user
//        $this->sendPDF('denis.firsov@gmail.com', $pdf);
//
//        // clear session query
//        $this->clearSessionQuery();
    }

    public function getHolderName(){
        return 'contact';
    }

    
}
