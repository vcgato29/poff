<?php


class CalculatorForm extends sfForm{

	public function configure(){

		parent::configure();
		$this->setNameFormat();

		$this->widgetSchema['laius'] = new sfWidgetFormInput();
		$this->widgetSchema['pikkus'] = new sfWidgetFormInput();
		$this->widgetSchema['liigendus'] = new sfWidgetFormInput();
		$this->widgetSchema['kõrgus'] = new sfWidgetFormInput();
		$this->widgetSchema['materjal'] = new sfWidgetFormInput();
		$this->widgetSchema['vana katuse eemaldamine'] = new sfWidgetFormInput();

		$this->validatorSchema['laius'] = new sfValidatorString(array('required' => true, 'min_length' => 1, 'max_length' => 100));
		$this->validatorSchema['pikkus'] = new sfValidatorString(array('required' => true, 'min_length' => 1, 'max_length' => 100));
		$this->validatorSchema['liigendus'] = new sfValidatorString(array('required' => false, 'min_length' => 0, 'max_length' => 100));
		$this->validatorSchema['materjal'] = new sfValidatorString(array('required' => false, 'min_length' => 0, 'max_length' => 100));
		$this->validatorSchema['kõrgus'] = new sfValidatorString(array('required' => false, 'min_length' => 0, 'max_length' => 100));
		$this->validatorSchema['vana katuse eemaldamine'] = new sfValidatorString(array('required' => false, 'min_length' => 0, 'max_length' => 100));

		$this->setDefault('vana katuse eemaldamine', 1);

	}

	public function setNameFormat(){
		$this->widgetSchema->setNameFormat('arvutat[%s]');
	}

}