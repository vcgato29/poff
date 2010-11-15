<?php
class myFrontendAction extends sfActions{

	public function preExecute(){

		switch ($this->getRoute()->getObject()->getLang()){
			case 'est':
				$culture = 'et';
				break;
			case 'eng':
				$culture = 'en';
				break;
			case 'fr':
				$culture = 'fr';
				break;
			default:
				$culture = 'et';
		}


		$this->getUser()->setCulture($culture);

		$this->setLayout($this->getRoute()->getObject()->getLayout());

		//FB::send($this->getRoute()->getObject()->toArray());
	}

	protected function logRequestVariables(){

		ob_start();
		echo "POST:\n";
		print_r($_POST);
		echo "\nGET:\n";
		print_r($_GET);

		return utf8_encode( ob_get_clean() );
	}


	protected function renderJson( $ar ){
		return $this->renderPartial('global/json', $ar  );
	}

}
