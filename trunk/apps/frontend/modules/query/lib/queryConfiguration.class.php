<?php

class queryConfiguration{


    public function getSimpleContactForm(){
        return new SimpleContactForm();
    }


    public function getFileAttachmentsForm(){
        return new SimpleFileAttachmentsForm();
    }

    public function getDimensionsForm($t){
        return new SimpleDimensionsForm($this->getDimensionInfoByIndex($t), $t);
    }

    public function getDimensionsInfo(){
        include(sfConfig::get('sf_root_dir') . '/dimensions.php');
        return $data;
    }


    public function getDimensionInfoByIndex($i){

        foreach($this->getDimensionsInfo() as $index => $ar){
            if($i == $index) return $ar;
        }

        return false;
    }


    public function getProfilesInfo(){
		include(sfConfig::get('sf_root_dir') . '/profiilid_varvid_pinnakated.php');

		return array('profiles' => $profiilid, 'colors' => $varvid, 'covers' => $pinnakate);
    }

    public function getProfilesForm(){
		return new SimpleProfilesForm();
    }


	public function getProductsForm(){
		return new SimpleProductsForm();
	}


}