<?php

class SimpleFileAttachmentsForm extends sfForm{

    public function configure(){
        $this->setNameFormat();

        
        for($i = 1; $i <= $this->getPicturesAmount(); ++$i){
            $this->widgetSchema['picture' . $i] = new sfWidgetFormInputFile();
            $this->validatorSchema['picture' . $i] = new sfValidatorFile( 
                    array( 'required' => false,
                            'max_size' => 2097152, // 2MB
                            'mime_types' => 'web_images') );
        }
    }

    public function getPicturesAmount(){
        return 4;
    }

    public function processForm(sfWebRequest $request){

        $result = array();

        $this->bind( $request->getParameter($this->getName()), $request->getFiles($this->getName()) );



        if(!$this->isValid()) return false;


        for($i = 1; $i <= $this->getPicturesAmount(); ++$i){

            if(!$this->getValue('picture'. $i)) break;

            $file = $this->getValue('picture'. $i);



            $dst = $this->getRandomPictureName();
            $file->save($dst);
            $result[] = $dst;

            
        }

        return $result;
    }


    public function getRandomPictureName(){
        @mkdir(sfConfig::get('sf_web_dir') . '/queries', 0777, true);
        return tempnam(sfConfig::get('sf_web_dir') . '/queries', "pic_") . '.jpg';
    }


   public function setNameFormat(){
        $this->widgetSchema->setNameFormat('attachment[%s]');
   }

   public function getErrors(){
   $result = array();

    foreach($this->getErrorSchema() as $index => $val){
        $result[$index] = $val->__toString();
    }
    return $result;

   }


}