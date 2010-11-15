<?php

class publicUserRegistrationActions extends myFrontendAction{
	
	public function preExecute(){
		$this->curNode = $this->getRoute()->getObject();
		$this->controller = $this;
		parent::preExecute();
		$this->setLayout('layout_widgets_off');
	}
	
	
	/* registration index action */
	public function executeIndex(sfWebRequest $request){
		# redirect if already registered
		if($this->getUser()->isAuthenticated()) 
			$this->redirect( $this->getComponent('linker', 'mySettingsLinkBuilder', array()) );
		
		// action => submit; if user comes with 'basket' parameter, then add it aslo to submit action		
		$this->submitActionParams = $request->hasParameter('basket') ? array('action' => 'submit', 'basket' =>  $request->getParameter('basket')) : array('action' => 'submit');
		$this->form = new RegistrationForm();
	}

	
	/* registration submit action */
	public function executeSubmit(sfWebRequest $request){
		# assign all INDEX variables
		$this->executeIndex($request);

		
		if($this->processForm($this->form)){
			$publicUser = $this->form->save(); 	// saving new user with addresses
			$publicUser->Addresses[0] = $this->form->getNewAddressObject(); // link new address to just saved use
			$publicUser->save();
			
			// auth user
			$this->getUser()->authAs($publicUser);
			
			// notify listeners
			$this->dispatcher->notify(new sfEvent($this, 'user.registered'));
			
			// set flashes
			$this->getUser()->setFlash('mysettings.message', 'Your are registered now.');

			//redirect to "MY SETTINGS"
			$this->redirect( $this->getComponent('linker', 'mySettingsLinkBuilder') );
		}else{
			$this->getUser()->setFlash('mysettings.message', 'Please complete all sections outlined in red.');
			
			// which errors show to user
			$schema = $this->form->getErrorSchema();
			$this->getUser()->setFlash('mysettings.errors', array( $schema['login'], $schema['email'] ) );
		}		
		
		$this->setTemplate('index');
	}
	
	
	/* 'My Settings' index action */
	public function executeMySettings(sfWebRequest $request){
		$this->form = new RegistrationForm($this->getUser()->getObject());
	}
	
	
	/* 'My Settings' submti action */
	public function executeEditSettings(sfWebRequest $request){
		$this->executeMySettings($request);

		if($this->processForm($this->form)){
			$this->form->save();
			
			if( $this->form->getObject()->Addresses->count() == 5 ){ // MAX 5 addresses
				$this->form->getObject()->Addresses[4]->delete();
			}
			
			$this->getUser()->setFlash('mysettings.message', 'Settings saved.');
			
			$this->dispatcher->notify(new sfEvent($this, 'user.settings_updated'));
			
			# redirect to "MY SETTINGS"
			$this->redirect( $this->getComponent('linker', 'mySettingsLinkBuilder', array()) );
		}else{
			$this->getUser()->setFlash('mysettings.message', 'Please complete all sections outlined in red.');
		}

		$this->setTemplate('mySettings');
	}
	
	
	public function executeDeleteAddress(sfWebRequest $request){
		$address = Doctrine::getTable('PublicUserAddresses')->find($this->getRequestParameter('addressID'));
		
		$this->forward404Unless($address && $address->public_user_id === $this->getUser()->getObject()->getId());
					
		$address->delete();
		$this->getUser()->setFlash('mysettings.message', 'Shipping address deleted.');
		
		# redirect to "MY SETTINGS"
		$this->redirect( $this->getComponent('linker', 'mySettingsLinkBuilder', array()) );
	}
	
	
	public function executeOrders(sfWebRequest $request){
		$this->orders = Doctrine::getTable('ProductOrder')->createQuery('orders')
							->select('*')
							->from('ProductOrder po')
							->where('po.public_user_id = ?', $this->getUser()->getObject()->getId())
							->andWhere('po.is_hidden = ?', false)
							->orderBy('po.created_at DESC')
							->execute();
	}
	
	public function executeInvoice( $request ){
		$order = Doctrine::getTable('ProductOrder')->find($this->getRequestParameter('invoiceID'));
		
		$this->forward404Unless($this->getUser()->isMyOrder($order));
		
		if(!file_exists($order->getInvoiceAbsolutePath('pdf'))){	// init invoice generation task
			$arguments = array('orderID' => $this->getRequestParameter('invoiceID') );
			$options = array('host' => $request->getHost(), 'culture' => $this->getUser()->getCulture());
			
			$invoiceGenTask = new sfInvoiceGenerationTask(sfContext::getInstance()->getEventDispatcher(), new sfFormatter());
			chdir(sfConfig::get('sf_root_dir')); // hack to start task from Action
			$invoiceGenTask->run($arguments, $options);
		}
		
		# We'll be outputting a PDF
		header('Content-type: application/pdf');
		
		# It will be called
		header('Content-Disposition: attachment; filename="' . $order->getInvoiceFilename('pdf') . '"');
		
		# The PDF source
		readfile($order->getInvoiceAbsolutePath('pdf'));
		
		return sfView::NONE;
	}
	
	public function executeRenameInvoice( $request ){
		$this->setLayout(false);
		$this->order = Doctrine::getTable('ProductOrder')->find($this->getRequestParameter('invoiceID'));
		
		$this->forward404Unless($this->getUser()->isMyOrder($this->order));
		
		$this->order->setTitle($this->getRequestParameter('name'));
		$this->order->save();
		
	}
	
	public function executeHideInvoice($request){
		$this->setLayout(false);
		$this->order = Doctrine::getTable('ProductOrder')->find($this->getRequestParameter('invoiceID'));
		
		$this->forward404Unless($this->getUser()->isMyOrder($this->order));
		
		$this->order->setIsHidden(true);
		$this->order->save();
		
		return sfView::NONE;
	}
	
	
	public function executeSignInIndex($request){
		$this->getUser()->setFlash('signin.error', 'Login Required');
		$this->getUser()->setAttribute('user.signed_in.continue_url',$request->getUri());
		
		$this->redirect( $this->getComponent('linker', 'localizedHomepage') );
	}
	
	
	public function executeSignIn( $request ){
		
		# new form
		$form = new SignInForm();
		$form->bind( $request->getParameter($form->getName()) );
		if( $form->isValid() ){
			$user = Doctrine::getTable('PublicUser')->findOneByCredentials($form->getValue('username'), $form->getValue('password'));
			if( $user )
				$this->getUser()->authAs($user);
		}
		
		# if user is still not authenticated => set flashes
		if( !$this->getUser()->isAuthenticated() ){
			$this->getUser()->setFlash( $request->getParameter('message', 'signin.error'), 'username or password is wrong');
		}else{
			$this->dispatcher->notify(new sfEvent($this, 'user.signed_in'));
		}

		$add = $request->hasParameter('anchor') ? '#' . $request->getParameter('anchor', '') : '';
		$this->redirect( $request->getReferer() . $add );
	}
	
	
	public function executeLogOut( $request ){
		$this->getUser()->logOut();
		
		$this->redirect( $this->getComponent('linker', 'localizedHomepage') );
	}
	
	protected function processForm($form){
		$arrToBind = $this->getRequestParameter($form->getName());
		
		// TODO: ensure that user can change only their own settings
		
		$form->bind($arrToBind, array());
		
		if($form->isValid()){
			return true;
		}else{
			return false;
		}
		
		return true;
	}
}