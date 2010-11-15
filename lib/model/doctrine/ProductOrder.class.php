<?php

class ProductOrder extends BaseProductOrder
{
		
	### PAYMENT HANDLING BULLSHIT 
	### REFACTOR !!!
	public $wasPaymentSuccessful = false;
	
	
	public function createBankLinkPayment(){
		return new CPayment( $this->getId(), 'Faye', Currency::convert(BasketCheckedOut::getInstance($this->getId())->price(BasketCheckedOut::TOTAL_PAYABLE), 'EEK' ), 'EEK' );	
	}
	
	
	public function createHiddenFields( $urlCallback ){
		
		  	$bankLink = CBanklink::getBank( $this->getType() );		  	
  			$bankLink->urlCallback = $urlCallback;
  			
  		return $bankLink->HtmlMakePaymentForm( $this->createBankLinkPayment() );
	}
	
	public function getBankLink(){
		return $this->getBankLinkByType( $this->getType() );
	}
	
	
	public function isSuccessful(){
		
	}
	
	public function getInvoiceRelativePath($ext){
		return sfConfig::get('app_sfInvoiceGenerationPlugin_invoice_dir') . $this->getInvoiceFilename($ext);
	}
	
    public function getInvoiceAbsolutePath( $ext ){
  	  return sfConfig::get('sf_web_dir') . '/' . $this->getInvoiceRelativePath( $ext );
    }
    
	public function getInvoiceFilename( $ext = 'pdf' ){
		return $this->order_number . '.' . $ext; 
	}
	
	
	public function getHasNotes(){
		return $this->hasNotes() ? 'yes' : 'no';
	}
	
	public function hasNotes(){
		if($this->getNotes()) return true;
		else return false;
	}
	
	static function getBankLinkByType( $type ){
		return CBanklink::getBank( $type );
	}
	
	static function HandleCallback( $type ){
		$bankLink = self::getBankLinkByType( $this->getRequestParameter('bank') );
		$payment = $bankLink->HandleCallback();
		
		$order = $this->getTable()->find( $payment->ixOrder );
		
		if( $payment && $payment->isSuccessful )
			$order->wasPaymentSuccessful = true;
		else
			$order->wasPaymentSuccessful = false;
		
		return $order;
	}
	
	
	
}