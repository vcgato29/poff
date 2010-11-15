<?php
require_once dirname(__FILE__).'/../../query/lib/SimpleContactForm.class.php';
require_once dirname(__FILE__).'/../../query/lib/queryHelper.class.php';
require_once dirname(__FILE__).'/../../query/lib/queryConfiguration.class.php';

class contactUsFormActions extends myFrontendAction{

	public function preExecute(){
		$this->helper = new queryHelper();
		$this->configuration = new queryConfiguration();
		$this->form = $this->configuration->getSimpleContactForm();
	}
	
	
	public function executeContact(sfWebRequest $request){
		$this->setLayout('layout_widgets_off');

		$this->node = $this->getRoute()->getObject();
	
	}

	public function executeSubmit(sfWebRequest $request){
		sfProjectConfiguration::getActive()->loadHelpers(array('I18N', 'Variable'));
		
		$this->setLayout(false);

		$this->form->bind($request->getParameter($this->form->getName()));
		if($this->form->isValid()){


		 $this->sendEmail(variable('system email', 'admin@olly.ee'),'olly.ee',variable('system email', 'denis.firsov@gmail.com'),'Contact form', implode('<br />',$this->form->getValues()) );

			$this->renderPartial('global/json', array('item' => array(
				'code' => 200,
				'notice' => __('Andmed edukalt saadetud')
			)));

		}else{
			$this->renderPartial('global/json', array('item' => array(
				'code' => 500,
				'errors' => $this->form->getErrors()
			)));
			
		}
		

		
		return sfView::NONE;

	}
	

	public function sendEmail( $from, $fromName, $to, $subject, $content ){
		
		$message = $this->getMailer()
						->compose(
		      				array( $from => $fromName ),
		      				$to,
		      				$subject,
		      				$content 
		      					);

		      					
		    $message->setContentType('text/html'); 
		    $this->getMailer()->send( $message );
	}
}