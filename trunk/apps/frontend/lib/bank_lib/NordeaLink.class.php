<?php
/**
* @package BankLink
* @author Jani Luukkanen
*/
class NordeaLink extends CBanklink
{
	public $flPrivateKey = 'LEHTI';
	public $flBankCertificate = '';
	public $ixSellerCode = '12345678';
	public $ixTargerAccountNumber = '17001194911';
	public $sTargetAccountOwnerName = 'Music Online OU';
	//public $urlServer = "https://solo3.nordea.fi/cgi-bin/SOLOPM01";
	public $urlServer = "https://netbank.nordea.com/pnbepaytest/epayn.jsp";
	
	public $urlCallback;
	public $nOutputEncoding = 'ISO-8859-4';

	public function __construct() {
		$this->urlCallback = 'http://google.com';
		//$this->nOutputEncoding = $GLOBALS['charset'];
	}

	public function UrlBankServer()
	{
		return $this->urlServer;
	}
	/**
	 * Function returns all the input fields required by the bank using CPayment object.
	 *
	 * @param CPayment $oPayment
	 * @return string HTML including input=hidden tags
	 */
	public function HtmlMakePaymentForm($oPayment, $nInputEncoding = "UTF-8")
	{
		if (strpos($oPayment->cPrice, ","))
		{
			$oPayment->cPrice = (float)str_replace(",", ".", $oPayment->cPrice);
		}
		$rsField = array(
			'SOLOPMT_VERSION'    => '0003',
            'SOLOPMT_STAMP'      => $oPayment->ixOrder + floor($oPayment->cPrice*100),
            'SOLOPMT_RCV_ID'     => $this->ixSellerCode,
			'SOLOPMT_RCV_ACCOUNT'        => $this->ixTargerAccountNumber,
            'SOLOPMT_RCV_NAME'       => $this->sTargetAccountOwnerName,
			'SOLOPMT_LANGUAGE' 	 => "4",
			'SOLOPMT_AMOUNT'     => $oPayment->cPrice,
			'SOLOPMT_REF'        => $this->ReferenceNumber($oPayment->ixOrder),
			'SOLOPMT_DATE'		 => 'EXPRESS',
            'SOLOPMT_CURR'       => $oPayment->nCurrency,
            'SOLOPMT_MSG'        => $oPayment->txtOrderDescription,
			'SOLOPMT_RETURN'     => $this->urlCallback,
			'SOLOPMT_CANCEL'     => $this->urlCallback,
			'SOLOPMT_REJECT'     => $this->urlCallback,
			'SOLOPMT_CONFIRM'    => 'YES',
			'SOLOPMT_KEYVERS'	 => '0001',
			'SOLOPMT_CUR'		 => 'EEK'
       	);

       	$rsField['SOLOPMT_MAC'] = strtoupper(md5(
       		$rsField['SOLOPMT_VERSION'] . "&" .
       		$rsField['SOLOPMT_STAMP'] . "&" .
       		$rsField['SOLOPMT_RCV_ID'] . "&" .
       		$rsField['SOLOPMT_AMOUNT'] . "&" .
       		$rsField['SOLOPMT_REF'] . "&" .
       		$rsField['SOLOPMT_DATE'] . "&" .
       		$rsField['SOLOPMT_CUR'] . "&" .
       		$this->flPrivateKey . "&"));
/*		echo md5(
       		$rsField['SOLOPMT_VERSION'] . "&" .
       		$rsField['SOLOPMT_STAMP'] . "&" .
       		$rsField['SOLOPMT_RCV_ID'] . "&" .
       		$rsField['SOLOPMT_AMOUNT'] . "&" .
       		$rsField['SOLOPMT_REF'] . "&" .
       		$rsField['SOLOPMT_DATE'] . "&" .
       		$rsField['SOLOPMT_CUR'] . "&" .
       		$this->flPrivateKey . "&");
*/
    	$html = '';
    	foreach ($rsField as $ixField => $fieldValue)
    	{
    		$html .= '<input type="hidden" name="' . $ixField . '" value="' . htmlspecialchars(iconv($nInputEncoding, $this->nOutputEncoding, $fieldValue)) . '" />' . "\n";
    	}
    	return $html;
	}
	/**
	 * Function that processes the callback from the bank and returns CPayment objects with isSuccessful
	 * (and other applicable) parameters filled according to the answers from the bank.
	 *
	 * @return CPayment
	 */
	public function HandleCallback()
	{
		$rsField = array();

	    foreach ((array)$_REQUEST as $ixField => $fieldValue)
	    {
	        if (substr($ixField, 0, 8) == 'SOLOPMT_')
	        {
	            $rsField[$ixField] = $fieldValue;
	        }
	    }
	    if (isset($rsField['SOLOPMT_RETURN_PAID'])) # Successful payment
	    {
		    if (strtoupper(md5(
				$rsField['SOLOPMT_RETURN_VERSION'] . "&" .
				$rsField['SOLOPMT_RETURN_STAMP'] . "&" .
				$rsField['SOLOPMT_RETURN_REF'] . "&" .
				$rsField['SOLOPMT_RETURN_PAID'] . "&" .
				$this->flPrivateKey . "&"
				)) != $rsField['SOLOPMT_RETURN_MAC'])
			{
				trigger_error ("Invalid signature", E_USER_ERROR);
			}
			$cPrice = (float)($rsField['SOLOPMT_RETURN_STAMP']-floor($rsField['SOLOPMT_RETURN_REF']/10));
			//print floor($rsField['SOLOPMT_RETURN_REF']/10);
			return new CPayment(floor($rsField['SOLOPMT_RETURN_REF']/10), $cPrice, null, null, True);
	    }
	    else 	# Payment was cancelled
	    {
	    	if (strtoupper(md5(
				$rsField['SOLOPMT_RETURN_VERSION'] . "&" .
				$rsField['SOLOPMT_RETURN_STAMP'] . "&" .
				$rsField['SOLOPMT_RETURN_REF'] . "&" .
				$rsField['SOLOPMT_RETURN_PAID'] . "&" .
				$this->flPrivateKey . "&"
				)) != $rsField['SOLOPMT_RETURN_MAC'])
			{
				trigger_error ("Invalid signature", E_USER_ERROR);
			}
			return new CPayment($rsField['SOLOPMT_RETURN_STAMP'], null, null, null, False);
	    }
	}

	function RsKeyNordea($ixService) {
		if ($ixService == 'payment')
		{
			return array(
				'SOLOPMT_VERSION',
				'SOLOPMT_STAMP',
				'SOLOPMT_RCV_ID',
				'SOLOPMT_RCV_ACCOUNT',
				'SOLOPMT_RCV_NAME',
				'SOLOPMT_LANGUAGE',
				'SOLOPMT_AMOUNT',
				'SOLOPMT_REF',
				'SOLOPMT_DATE',
				'SOLOPMT_RETURN',
				'SOLOPMT_CANCEL',
				'SOLOPMT_REJECT',
				'SOLOPMT_BUTTON',
				'SOLOPMT_MAC',
				'SOLOPMT_CONFIRM',
				'SOLOPMT_KEYVERS',
				'SOLOPMT_CUR'
			);
		}
		else if ($ixService == 'receipt')
		{
			return array(
				'SOLOPMT_RETURN_VERSION',
				'SOLOPMT_RETURN_STAMP',
				'SOLOPMT_RETURN_REF',
				'SOLOPMT_RETURN_PAID',
				'SOLOPMT_RETURN_MAC'
			);
		}
	}
}
?>