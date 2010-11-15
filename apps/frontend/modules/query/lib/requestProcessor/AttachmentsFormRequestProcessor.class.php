<?php

class AttachmentsFormRequestProcessor extends RequestProcessor{


	protected $result = array();

    public function processForm(){

		if($this->validateForm()){

			for($i = 1; $i <= $this->getForm()->getPicturesAmount(); ++$i){

				if(!$this->getForm()->getValue('picture'. $i)) break;

				$file = $this->getForm()->getValue('picture'. $i);



				$dst = $this->getForm()->getRandomPictureName();
				$file->save($dst);
				$this->addPicture($dst);
			}

			return true;
		}else{
			return false;
		}
        
    }

	protected function addPicture($pic){
		$this->result[] = str_replace(sfConfig::get('sf_web_dir'), '', $pic);
	}

	protected function getFormValues(){
        return $this->result;
    }





    public function getHolderName(){
        return 'attachments';
    }
}