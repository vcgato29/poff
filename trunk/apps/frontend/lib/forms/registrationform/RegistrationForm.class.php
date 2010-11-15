<?php
class RegistrationForm extends BasePublicUserForm
{
	const REG_NEW_ADDRESS = "register_new_address";
	const EDIT_NEW_ADDRESS = "new_address";
	
	public $currencies = false;

   public function configure()
   {

     $this->setNameFormat();
     $this->useFields(array( 'login', 'name','email', 'city', 'country', 'zip', 'password', 'address1', 'address2', 'state', 'currency' ));
     
	$this->validatorSchema->setPostValidator(
      new sfValidatorDoctrineUnique(array('model' => 'PublicUser', 'column' => array('login')), array('invalid' => 'Choose other login.'))
    );
    
    $this->validatorSchema['login'] = new sfValidatorString(array(),array('required' => ' '));
    $this->validatorSchema['email'] = new sfValidatorEmail(array(),array('required' => ' ','invalid' => 'Wrong email.'));
     

    
     if(!$this->isNew())
	 	foreach($this->getObject()->Addresses as $index => $adr)
	 		$this->embedForm( 'form_' . $index, new PublicUserAddressesForm($adr));
	 	

	 $this->setupNewAddressForm();
   }
   
   
   public function getNewAddressObject(){
   	return $this->getEmbeddedForm(RegistrationForm::REG_NEW_ADDRESS)->getObject();
   }
   
   public function setNameFormat(){
   		$this->widgetSchema->setNameFormat('register[%s]');
   }
   
   	public function bind(array $taintedValues = null, array $taintedFiles = null) {
   		

   		if(!$this->newAddressSubmitted($taintedValues) && isset($this[RegistrationForm::EDIT_NEW_ADDRESS])){
   			
	   		foreach($this[RegistrationForm::EDIT_NEW_ADDRESS] as $index => $field){
				$this->validatorSchema[RegistrationForm::EDIT_NEW_ADDRESS][$index] = new sfValidatorPass();
			}
		}
   		
		return parent::bind($taintedValues, $taintedFiles);
   	}
   	
   	public function newAddressSubmitted( array $taintedValues = null ){
   		
   		if(!$taintedValues){
   			$taintedValues = $this->getTaintedValues();
   		}
   		
   		if(isset($taintedValues[RegistrationForm::EDIT_NEW_ADDRESS])){
			$newAddressValues = $taintedValues[RegistrationForm::EDIT_NEW_ADDRESS];
			$c = 0;
			foreach($newAddressValues as $val){
				if($val)++$c;
			}
			
			if($c < 3){
				return false;
			}else{
				return true;
			}
		}
		
		return false;
   		
   	}
   	
   	/**
   	 * Embeds *NEW* PublicUserAddressesForm.
   	 * If current object isNew() then embed "register_new_address", otherwise embed "new_address"
   	 */
   	protected function setupNewAddressForm(){
   		if(!$this->isNew()){
   			$usr = new PublicUserAddresses();
   			$usr->PublicUser = $this->getObject();
   			$this->embedForm(RegistrationForm::EDIT_NEW_ADDRESS,new PublicUserAddressesForm($usr));
   			
   		}else{
   			$this->embedForm(RegistrationForm::REG_NEW_ADDRESS,new PublicUserAddressesForm());
   		}
   	}
   	
   
	public function saveEmbeddedForms($con = null, $forms = null)
	{
			
	    if (is_null($con)){
	      $con = $this->getConnection();
	    }
	
	    if (is_null($forms)){
	      $forms = $this->embeddedForms;
	    }
	
	    foreach ($forms as $key => $form){
	    	// skip if EDIT_NEW_ADDRESS is not filled
	    	// NEVER skip REG_NEW_ADDRESS
			if($key == RegistrationForm::EDIT_NEW_ADDRESS && !$this->newAddressSubmitted()) continue;
			
	      if ($form instanceof sfFormDoctrine){
	        $form->bind($this->values[$key]);
	        $form->doSave($con);
	
	        $form->saveEmbeddedForms($con);
	      }
	      else{
	        $this->saveEmbeddedForms($con, $form->getEmbeddedForms());
	      }
	    }
	}
	
	public function getCurrencies(){
		if(!$this->currencies)
			$this->currencies = Doctrine::getTable('Currency')->findAll();
		return $this->currencies;
	}

} 