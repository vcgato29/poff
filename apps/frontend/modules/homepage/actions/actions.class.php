<?php

require_once( dirname( __FILE__ ) . '/../../categoryPage/actions/actions.class.php' ); // showin, showby actions

class homepageActions extends myFrontendAction{
	
	public $showByAr = array(6,9,12,15);
	public $showIn = array('list' => 'maincontent', # request value (stored in user session) => CSS class for products container
							'grid' => 'maincontent2');
	
	//public function preExecute(){}
	
	
	public function executeIndex(sfWebRequest $request){}
	
	
	public function executeChangeCurrency(sfWebRequest $request){
		if($cur = Doctrine::getTable('Currency')->find($this->getRequestParameter('currencyID'))){
			$this->getUser()->setCurrency($cur);
			
			$this->dispatcher->notify(new sfEvent($this, 'user.currency_changed'));	
		}
				
		$this->redirectToReferer();	
	}
	

	public function executePasswordReminder(sfWebRequest $request) {
		$form = new PasswordReminderForm();
		
		if($this->processReminderForm($form)){
			$this->getUser()->setFlash('reminder.message', 'check your email');
		}else{
			$this->getUser()->setFlash('reminder.message', 'wrong email');
		}
		
		$this->redirectToReferer();
	}
	
	
	public function executeShowby(sfWebRequest $request){
		if(in_array($this->getRequestParameter('val'), categoryPageActions::$showByAr)){
			$this->getUser()->setAttribute('showby', $this->getRequestParameter('val'));
		}
		
		// remove "page=" parameter to prevent last page error when increasing "showby"
		$link = preg_replace('/(&?)page=(\d+)/', '', $request->getReferer());
		$this->redirect($link);
	}
	
	
	public function executeShowin(sfWebRequest $request){
		if(!isset( categoryPageActions::$showIn[$this->getRequestParameter('val')] )) return sfView::NONE;
		
		$this->getUser()->setAttribute('showin', $this->getRequestParameter('val'));
		
		$this->redirectToReferer();
	}

	
	protected function processReminderForm($form){
		sfProjectConfiguration::getActive()->loadHelpers(array('I18N', 'Variable'));
		
		$form->bind($this->getRequestParameter($form->getName()));
		
		
		if($form->isValid()){
			if($usr = Doctrine::getTable('PublicUser')->findOneByEmail($form->getValue('email'))){
				$message = $this->getMailer()
								->compose(	array( variable('reminder email','aneto1@gmail.com') => __('Password reminder bot') ),
												  	$usr->getEmail(),
													__('Password reminder'),
													__('Your password is %1%', array('%1%' => $usr['password']))
										);
	 
	    		return $this->getMailer()->send($message);
			}
		}
		
		return false;
	}
	
	
	protected function redirectToReferer(){
		if( $this->getRequest()->getReferer() )
			$this->redirect( $this->getRequest()->getReferer() );
		else{
			$this->redirect( $this->getComponent('linker', 'localizedHomepage') );
		}
	}
}