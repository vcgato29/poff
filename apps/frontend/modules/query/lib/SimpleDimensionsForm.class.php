<?php

class SimpleDimensionsForm extends sfForm{

    private $dimensions;

    public function __construct(array $info, $index){

        $this->dimensions = $info['amount_of_segments'];


        parent::__construct(null, null, false);

        $this->setDefault('katuse tüüp', $index);
        $this->setDefault('katuse skeema', $info['big_picture_url']);
    }


    public function configure(){

        $this->setNameFormat();

        $this->widgetSchema['katuse tüüp'] = new sfWidgetFormInput();
        $this->widgetSchema['katuse skeema'] = new sfWidgetFormInput();
        $this->widgetSchema['katuse pindala'] = new sfWidgetFormInput();
        $this->widgetSchema['katuse mõõdistamine'] = new sfWidgetFormInput();
        

        $this->validatorSchema['katuse tüüp'] = new sfValidatorString(array('required' => false,'min_length' => 0, 'max_length' => 200));
        $this->validatorSchema['katuse skeema'] = new sfValidatorString(array('required' => false,'min_length' => 0, 'max_length' => 200));
        $this->validatorSchema['katuse pindala'] = new sfValidatorString(array('required' => false,'min_length' => 0, 'max_length' => 200));
        $this->validatorSchema['katuse mõõdistamine'] = new sfValidatorString(array('required' => false,'min_length' => 0, 'max_length' => 200));

        $this->configureDimensions();
        
    }


    public function configureDimensions(){
        for($i = 1; $i <= $this->getDimensions(); ++$i){
            $this->widgetSchema[$this->dimName($i)] = new sfWidgetFormInput();
            $this->validatorSchema[$this->dimName($i)] = new sfValidatorString(array('required' => false,'min_length' => 0, 'max_length' => 100));
        }

    }

    public function dimName($i){
        $char = 'A';
        for($z = 1; $z < $i; ++$z)
            ++$char;
        return $char;
    }


    public function getDimensions(){
        return $this->dimensions;
    }
    
    
   public function setNameFormat(){
        $this->widgetSchema->setNameFormat(self::getFormName() . '[%s]');
   }



   public function validateForm(sfWebRequest $request){
       $this->bind($request->getParameter($this->getName()), array());

       if($this->isValid()){
           return true;
       }else{
           return false;
       }

   }

   public function getErrors(){
   $result = array();

    foreach($this->getErrorSchema() as $index => $val){
        $result[$index] = $val->__toString();
    }
    return $result;

   }


   static function getFormName(){
       return 'dimensions';
   }



}