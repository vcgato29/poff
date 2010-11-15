<?php
class basketPageActions extends myFrontendAction{
	
	public function preExecute(){
		parent::preExecute();
		$this->setLayout('layout_widgets_off');
	}
	
	public function executeTest(){
//			$arguments = array('host' => $this->getRequest()->getHost() );
//			$options = array();
//			
//			$invoiceGenTask = new sfInvoiceMailerTask(sfContext::getInstance()->getEventDispatcher(), new sfFormatter());
//			chdir(sfConfig::get('sf_root_dir')); // hack to start task from Action
//			$invoiceGenTask->run($arguments, $options);
//	
//			return sfView::NONE;
	}
	
	public function executeIndex(sfWebRequest $request){
		$this->controller = $this;
		
		$this->products = myBasket::getInstance()->isEmpty() ? array() : myBasket::getInstance()->prepareDataForView();
				
		$this->subtotalPrice = myBasket::getInstance()->getTotalPrice();
		
		$this->continueShoppingNode = Doctrine::getTable('Structure')->findOneByParameterAndLang('productCatalog', $this->getRoute()->getObject()->getLang());
						
		$this->signInform = new SignInForm();
	}
	
	public function executeAddProductToBasket(sfWebRequest $request){
		$this->setLayout(false);
		sfProjectConfiguration::getActive()->loadHelpers(array('I18N'));

		$this->params = array();
		if(myBasket::getInstance()->addProduct( $request->getParameter('productID'), (int)$request->getParameter('qty') )){
			
			$this->params['html'] = $this->getComponent('basketPage','basket', array('visible' => true) );
			$this->params['message'] = __('Product added to basket. Add more?');
			$this->params['message_short'] = __('Added to basket');
			
			$this->params['code'] = 200;
		}else{
			$this->params['code'] = 500;
			$this->params['message'] = __('error occured while adding product to basket.');
			$this->params['message_short'] = __('error');
		}
	}
	
	public function executeDeleteFromBasket(sfWebRequest $request){
		$this->setLayout(false);
		sfProjectConfiguration::getActive()->loadHelpers(array('Currency'));
		
		myBasket::getInstance()->deleteProduct( $request->getParameter('productID') );
		
		$this->params = array();
		$this->params['html'] = $this->getComponent('basketPage','basket', array('visible' => true) );
		$this->params['total'] = price_format(myBasket::getInstance()->getTotalPrice(), $this->getUser() ); 
		
		$this->setTemplate('addProductToBasket');
	}
	
	public function executeChangeAmount(sfWebRequest $request){
		$this->setLayout(false);
		
		myBasket::getInstance()->changeAmount($request->getParameter('productID'), $request->getParameter('qty'));
		
		$this->params = array();
		$this->params['html'] = $this->getComponent('basketPage','basket', array('visible' => true) );
		$this->params['total'] = price_format(myBasket::getInstance()->getTotalPrice(), $this->getUser() );
		
		foreach(myBasket::getInstance()->prepareDataForView() as $prod){
			if($prod['product']['id'] == $request->getParameter('productID'))
				$this->params['price'] = price_format($prod['product']['price_actual'] * $prod['quanity'], $this->getUser());	
		}

		$this->setTemplate('addProductToBasket');
	}
	
	
	public function executeCheckout(sfWebRequest $request){
		# validate request
		if(!myBasket::getInstance()->getProducts()) // if basket is empty redirect to referer
			$this->redirect($request->getReferer()); 
		
		# checkout
		$order = myBasket::getInstance()->checkout();
		
		# delete products from basket
		foreach(myBasket::getInstance()->getProducts() as $id => $qty)
			myBasket::getInstance()->deleteProduct($id);
		
		# redirect to "order" action
		$this->redirect($this->getComponent('linker', 'basket', array('action' => 'order', 'orderID' => $order['id']) ) );
	}
	
	
	public function executeOrder(sfWebRequest $request){
		$order = Doctrine::getTable('ProductOrder')->find($this->getRequestParameter('orderID'));
		
		$this->forward404Unless($this->getUser()->isMyOrder($order) && $order->getStatus() == ProductOrderTable::STATUS_NEW);
		
		$this->controller = $this;
		$this->products = BasketCheckedOut::getInstance($order['id'])->prepareDataForView();
		
		$this->priceTotalPayable = 	BasketCheckedOut::getInstance($order['id'])->price(BasketCheckedOut::TOTAL_PAYABLE);
		$this->priceShipping = 		BasketCheckedOut::getInstance($order['id'])->price(BasketCheckedOut::SHIPPING_PRICE);
		$this->priceBasketTotal = 	BasketCheckedOut::getInstance($order['id'])->price(BasketCheckedOut::TOTAL_NO_SHIPPING);
		
		$this->termsAndConditionsNode = Doctrine::getTable('Structure')->findOneByParameterAndLang('terms_and_conditions', $this->getRoute()->getObject()->getLang());

		$this->shippingZones = $this->getShippingZones();
		$this->shops = $this->getShops();
		
		$this->orderingForm = new OrderingForm($order);
	}
	
	
	public function executeOrderSubmit(sfWebRequest $request){
		$this->setLayout(false);
		
		$order = Doctrine::getTable('ProductOrder')->find($this->getRequestParameter('orderID'));
		
		$this->forward404Unless($this->getUser()->isMyOrder($order) && $order->getStatus() == ProductOrderTable::STATUS_NEW);
		
		$this->orderingForm = new OrderingForm(
								Doctrine::getTable('ProductOrder')->find($this->getRequestParameter('orderID') ) );
		
		
		$this->orderingForm->bind($request->getParameter($this->orderingForm->getName()));
		
		if($this->orderingForm->isValid()){
			$order = $this->orderingForm->save();
			
			$result['code'] = 200;
			$result['link'] = $this->getComponent('linker', 'proceedToPayment', array('order' => $order));
		}else{
			sfProjectConfiguration::getActive()->loadHelpers(array('I18N'));
			
			$result['code'] = 500;
			$result['errors'] = $this->orderingForm->getErrorsAssociatedToFieldIDs();
			
			//apply translations to all ERRORS
			foreach($result['errors'] as $index => &$error){
				$result['errors'][$index] = __($error);
			}
		}
		
		$this->renderPartial('global/json', array('item' => $result ));
		return sfView::NONE;
	}
	
	
	public function executeChangeShippingZone(sfWebRequest $request){
		sfProjectConfiguration::getActive()->loadHelpers(array('Currency', 'Number'));
		
		$this->forward404Unless($this->getUser()->isMyOrder(
								Doctrine::getTable('ProductOrder')->find($this->getRequestParameter('orderID') ) ) );
		
		$id = $this->getRequestParameter('orderID');
		if($request->getParameter('zoneID') == 0){
			return $this->renderPartial('global/json', array('item' => array('total' => price_format(BasketCheckedOut::getInstance($id)->price(BasketCheckedOut::TOTAL_NO_SHIPPING)), 
				'shipping' => price_format(0))));
		}

		$zone = BasketCheckedOut::getInstance($id)->shippingCost($this->getRequestParameter('zoneID'));
		$total = BasketCheckedOut::getInstance($id)->price(BasketCheckedOut::TOTAL_NO_SHIPPING) + $zone;
		
		return $this->renderPartial('global/json', array('item' => array('total' => price_format($total), 'shipping' => price_format($zone) )));		
	}
	
	
	public function executeProceedToPayment(sfWebRequest $request){
		$this->setLayout(false);
		$order = Doctrine::getTable('ProductOrder')->find($this->getRequestParameter('orderID'));
		
		$this->forward404Unless($this->getUser()->isMyOrder($order));
		
		if($order->getPayInCurrency() != $this->getUser()->getCurrency()->getAbbr()){ // set new currency if changed during ORDERING FORM filling
			$order->setPayInCurrency($this->getUser()->getCurrency()->getAbbr());
			$order->save();
		}
		
		$this->html = $order->createHiddenFields($this->getComponent('linker', 'verifyPayment', array('order' => $order)));
		$this->link = $order->getBankLink()->urlServer;
	}
	
	public function executeVerifyPayment( sfWebRequest $request ){
		$this->setLayout(false);
		sfProjectConfiguration::getActive()->loadHelpers(array('I18N', 'Variable'));
		
		$this->forward404Unless($this->getUser()->isMyOrder(
								Doctrine::getTable('ProductOrder')->find($this->getRequestParameter('orderID') ) ) );
		
		# getting current banklink object
		$bankLink = CBanklink::getBank( Doctrine::getTable('ProductOrder')->find($request->getParameter('orderID'))->getType() );
		
		
		# handling BANK callback and creating payment
		$payment = $bankLink->HandleCallback();
		
		
		# getting ORDER object
		$order = Doctrine::getTable('ProductOrder')->find( $payment->ixOrder );
		
		/* if order is still NEW: change status, generate ticket, send e-mail to user, send request to webservice */
		if( $order->getStatus() == ProductOrderTable::STATUS_NEW ){
			//$order->raw_response = $this->logRequestVariables();
			if( $payment && $payment->isSuccessful ){
				
				$order->status = ProductOrderTable::STATUS_PAID;
				$order->save();
				
				# send invoice to mail
				//generate invoice
//				$arguments = array('orderID' => $order['id'] );
//				$options = array('host' => $request->getHost(), 'culture' => $this->getUser()->getCulture());
//				$invoiceGenTask = new sfInvoiceGenerationTask(sfContext::getInstance()->getEventDispatcher(), new sfFormatter());
//				chdir(sfConfig::get('sf_root_dir')); // hack to start task from Action
//				$invoiceGenTask->run($arguments, $options);
				

			}else{
				$order->status = ProductOrderTable::STATUS_CANCELED;
				$order->save();
			}
			
			
		}
		
		$this->redirect($this->getComponent('linker', 'myOrdersLinkBuilder'));

	}
	
	public function executeRestartOrder($request){
		$this->setLayout(false);
		sfProjectConfiguration::getActive()->loadHelpers(array('I18N'));
		
		foreach(myBasket::getInstance()->getProducts() as $id => $qty){
			myBasket::getInstance()->deleteProduct($id);
		}
		
		$order = Doctrine::getTable('ProductOrder')->find($request->getParameter('orderID'));
		$this->forward404Unless($this->getUser()->isMyOrder($order));
		
		
		$deleted = array();
		foreach($order->OrederedItems as $item){
			# check if product is still in DB
			if(!Doctrine::getTable('Product')->find($item['product_id'])){
					$deleted[] = $item['name'];
					continue;
			}
			
			myBasket::getInstance()->addProduct($item['product_id'], $item['quanity']);
		}
		
		
		if($deleted){
			$this->getUser()->setFlash('basket.error', __('Products %1% are currently out of stock', array('%1%' => strtoupper(implode(', ', $deleted)))));
		}
		
		$this->redirect($this->getComponent('linker', 'basket', array()));
	}
	
	private function getShippingZones(){
		$q = Doctrine::getTable('ShippingZone')->createQuery()
			->from('ShippingZone s')
			->innerJoin("s.Translation t WITH t.lang = ? AND t.name != ?",array($this->getUser()->getCulture(), ''));
			
		return $q->execute();
	}
	
	private function getShops(){
		$q = Doctrine::getTable('Shop')->createQuery()
			->from('Shop s')
			->innerJoin("s.Translation t WITH t.lang = ? AND t.address != ?",array($this->getUser()->getCulture(), ''));
			
		return $q->execute();	
	}
	
}