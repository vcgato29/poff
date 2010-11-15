<?php 
/**
* @package BankLink
* @author Jani Luukkanen
*/
class CPayment
{
	public $ixOrder; // Order identification number (viitenumber)
	public $txtOrderDescription; // Order comments in human-readable text form (selgitus)
	public $cPrice; // Price to be paid
	public $nCurrency; // Currency
	
	public $isSuccessful; 	// When the callback handler returns the payment object, it fills this field
							// with True (when the payment was successful) or False (when it was cancelled).
	
	public function __construct($ixOrder, $txtOrderDescription, $cPrice, $nCurrency = "EEK", $isSuccessful = False)
	{
		$this->ixOrder = $ixOrder;
		$this->txtOrderDescription = $txtOrderDescription;
		$this->cPrice = $cPrice;
		$this->nCurrency = $nCurrency;
		$this->isSuccessful = $isSuccessful;
	}
}
?>