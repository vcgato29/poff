<?php

abstract class DataHolder{

    private $user;

    private static $instances;

    public function  __construct() {
    }



    public function getHolderName(){
        return 'query';
    }

    abstract public function getName();


    public function saveFormValues($values){
        $savedUserInput = $this->getUser()->getAttribute($this->getHolderName());

        $savedUserInput[$this->getName()] = $values;
        
        $this->getUser()->setAttribute($this->getHolderName(), $savedUserInput);
    }

    public function getSavedFormValues(){
        $savedUserInput = $this->getUser()->getAttribute($this->getHolderName());

		if($savedUserInput && isset($savedUserInput[$this->getName()]))
			return $savedUserInput[$this->getName()];
		else
			return array();

    }


    static function getInstance($instanceName){
        switch($instanceName){
            case 'contact':
                if(!isset(self::$instances['contact']))
                    self::$instances['contact'] = new ContactDataHolder();

                return self::$instances['contact'];
                break;
            case 'dimensions':
                if(!isset(self::$instances['dimensions']))
                    self::$instances['dimensions'] = new DimensionsDataHolder();

                return self::$instances['dimensions'];
                break;
			case 'profiles':
                if(!isset(self::$instances['profiles']))
                    self::$instances['profiles'] = new ProfilesDataHolder();

                return self::$instances['profiles'];
                break;
			case 'products':
                if(!isset(self::$instances['products']))
                    self::$instances['products'] = new ProductsDataHolder();

                return self::$instances['products'];
                break;
			case 'attachments':
                if(!isset(self::$instances['attachments']))
                    self::$instances['attachments'] = new AttacmentsDataHolder();

                return self::$instances['attachments'];
                break;
            default:
                trigger_error('wrong instance name: ' . $instanceName);
                break;
        }
    }

	static function clear(){
		self::getInstance('contact')->getUser()->setAttribute(self::getInstance('contact')->getHolderName(), array());
	}


    public function getUser(){
        return sfContext::getInstance()->getUser();
    }
    
    
}