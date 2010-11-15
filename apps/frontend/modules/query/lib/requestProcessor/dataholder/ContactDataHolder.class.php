<?php

class ContactDataHolder extends DataHolder{
    public function getName(){
        return 'contact';
    }

	public function getUserEmail(){
		$vals = $this->getSavedFormValues();

		return $vals['email'];
	}

	public function sendCopyToUser(){
		$vals = $this->getSavedFormValues();

		return $vals['send_copy'];
	}
    
}