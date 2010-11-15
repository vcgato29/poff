<?php

require_once dirname(__FILE__).'/../lib/queryConfiguration.class.php';

class queryComponents extends myComponents{


    public function setup(){
        $this->configuration = new queryConfiguration();
    }


    public function executeLeftMenu(){
		$this->helper = new queryHelper();
    }


    public function executeDimensionsForm(){
        $this->setup();
        $this->form = $this->configuration->getDimensionsForm($this->roofID);
    }
    

}